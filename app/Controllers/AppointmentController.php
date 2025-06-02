<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\slotModel;
use App\Models\manageAppointment;
use App\Models\UserModel;
use App\Models\ScheduleModel;
use App\Models\AppointmentModel;

class AppointmentController extends BaseController
{
    protected $db;
    protected $session;
    protected $appointmentModel;

    public function __construct()
    {
        // Assign the database connection to the $db property
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->appointmentModel = new AppointmentModel(); // Initialize the AppointmentModel
    }



    public function getIndex()
    {
        return view('manageAppointment/index');
    }

    public function getSlotForm()
    {
        $SlotModel = new slotModel();
        // Fetch all therapists for the table and only available ones for the form
        $data['allTherapists'] = $this->db->table('user')
            ->select('user.name, therapist.expertise, therapist.availability,therapist.therapistId, user.userId')
            ->join('therapist', 'therapist.userId = user.userId')
            ->where('user.role', 'Therapist')
            ->get()
            ->getResultArray();


        $data['availableTherapists'] = $SlotModel->getAvailableTherapists();

        // dd($data['availableTherapists']);

        return view('pages/slot', $data);
    }

    public function booking()
    {
        $model = new manageAppointment(); // Load the model
        $data['getTreatment'] = $model->getTreatment(); // Fetch the data
        return view('pages/booking', $data); // Pass data to the view
    }

    public function patientTreatment()
    {
        $therapist = new UserModel();
        $treatmentName = $this->request->getVar('treatmentName'); // Changed to getPost for POST data
        $treatmentPrice = $this->request->getVar('treatmentPrice');
        $treatmentId = $this->request->getVar('treatmentId');
        $data = [
            'treatmentName' => $treatmentName,
            'treatmentPrice' => $treatmentPrice,
            'treatmentId' => $treatmentId,
            'getTherapist' => $therapist->getTherapist(),
        ];

        return view('/manageAppointment/cTherapist', $data);
    }
    public function confirmTherapist()
    {
        $slotSchedule = new ScheduleModel();
        $therapistId = $this->request->getVar('therapistId');
        $therapistName = $this->request->getVar('therapistName');
        $treatmentId = $this->request->getVar('treatmentId');
        $treatmentName = $this->request->getVar('treatmentName');
        $treatmentPrice = $this->request->getVar('treatmentPrice');


        // $this->session->set('therapistId', $therapistId);
        // return redirect()->to('/manageAppointment/cTherapist');

        $data = [
            'therapistId' => $therapistId,
            'therapistName' => $therapistName,
            'treatmentId' => $treatmentId,
            'treatmentPrice' => $treatmentPrice,
            'treatmentName' => $treatmentName,
            'slotSchedule' => $slotSchedule->slotSchedule($therapistId)
        ];

        return view('/manageAppointment/cSlot', $data);
        // dd($data);
    }
    public function confirmAndShowSuccess()
    {
        $session = session();
        $userId = $session->get('userId');

        $appointmentModel = new AppointmentModel();
        $userModel = new UserModel();

        $therapistId = $this->request->getPost('therapistId');
        $slotId = $this->request->getPost('slotId');
        $treatmentId = $this->request->getPost('treatmentId');

        // dd($treatmentId);

        $patient = $userModel->getPatient($userId);
        if (!$patient) {
            return redirect()->back()->with('error', 'No patient found.');
        }

        $patientId = $patient['patientId'];

        // Insert appointment
        $appointmentData = [
            'appointmentId' => '',
            'therapistId'   => $therapistId,
            'patientId'     => $patientId,
            'slotId'        => $slotId,
            'status'        => 'pending',
            'treatmentId'   => $treatmentId
        ];

        if (!$appointmentModel->insert($appointmentData)) {
            return redirect()->back()->withInput()->with('error', 'Failed to book the appointment.');
        }

        $lastAppointmentId = $appointmentModel->insertID();

        // Payment
        $treatmentPackage = new \App\Models\treatmentPackage();
        $paymentModel = new \App\Models\PaymentModel();

        $treatment = $treatmentPackage->find($treatmentId);
        $paymentAmount = $treatment['treatmentPrice'] ?? 0;

        // dd($treatment);

        $paymentData = [
            'paymentId'      => '',
            'appointmentId'  => $lastAppointmentId,
            'patientId'      => $patientId,
            'treatmentId'    => $treatmentId,
            'payment_amount' => $paymentAmount,
            'paymentStatus'  => 'pending'
        ];
        $paymentModel->addPayment($paymentData);

        // Update slot to 'booked'
        $slotModel = new \App\Models\ScheduleModel();
        try {
            $slotModel->update($slotId, ['status' => 'booked']);
        } catch (\Exception $e) {
            log_message('error', 'Failed to update slot status: ' . $e->getMessage());
            return redirect()->to('/')->with('error', 'An error occurred while updating the slot status.');
        }

        $appointments = $appointmentModel->getPendingAppointments($patientId);

        // Find the appointment with the matching appointmentId
        $detailForm = null;
        foreach ($appointments as $app) {
            if ($app['appointmentId'] == $lastAppointmentId) {
                $detailForm = $app;
                break;
            }
        }
        // dd($detailForm);

        //  handle if not found
        if (!$detailForm) {
            // fallback or error handling
            $detailForm = [];
        }
        // Fetch appointment details for success page
        $appointment = $appointmentModel->find($lastAppointmentId);
        // dd($appointment);
        if (!$appointment) {
            return redirect()->to('/')->with('error', 'Invalid booking.');
        }

        return view('pages/successBooking', ['appointment' => $appointment, 'treatment' => $treatment, 'detailForm' => $detailForm]);
    }


    // public function test($appointmentId)
    // {
    //     echo $appointmentId;
    // }
    public function pendingAppointments()
    {
        $userModel = new UserModel();
        // Get the logged-in user's ID (assuming session stores it)
        $session = session();
        $userId = $session->get('userId');
        $patientId =  $userModel->getPatient($userId);


        // Ensure $patient is not null
        if (!$patientId) {
            return redirect()->to('/noPatientFound'); // Redirect or handle error
        }

        $patientId = $patientId['patientId']; // Extract the patientId

        $appointmentModel = new AppointmentModel();
        $appointments = $appointmentModel->getPendingAppointments($patientId);
        $historyAppointments = $appointmentModel->getHistoryAppointments($patientId);
        // dd($historyAppointments);

        // Pass both variables to the view
        return view('pages/bookedApp', [
            'appointments' => $appointments,
            'historyAppointments' => $historyAppointments,
        ]);
    }

    public function cancelBooking()
    {
        // Load models
        $appointmentModel = new AppointmentModel();
        $slotModel = new ScheduleModel(); // Assuming this model handles slots


        $appointmentId = $this->request->getPost('appointmentId');

        $appointmentModel = new AppointmentModel();
        $appointmentModel->update($appointmentId, ['status' => 'cancelled']);

        $paymentModel = new \App\Models\PaymentModel();
        $payment = $paymentModel->where('appointmentId', $appointmentId)->first();
        if ($payment) {
            $paymentModel->update($payment['paymentId'], ['paymentStatus' => 'cancelled']);
        }

        // return redirect()->to('/appointments')->with('message', 'Booking cancelled successfully.');
        $appointment = $appointmentModel->find($appointmentId);

        if (!$appointment) {
            return redirect()->to('/')->with('error', 'Invalid booking.');
        }

        // Update the slot status to 'available'
        $slotId = $appointment['slotId']; // Retrieve the slotId from the appointment
        $slotUpdateData = ['status' => 'available'];



        try {
            // Update the slot's status in the database
            if ($slotModel->update($slotId, $slotUpdateData)) {
                return view('pages/cancelBooking', ['appointment' => $appointment]);
            } else {
                return redirect()->to('/')->with('error', 'Failed to update slot status.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to update slot status: ' . $e->getMessage());
            return redirect()->to('/')->with('error', 'An error occurred while updating the slot status.');
        }
    }

    public function listAppointment()
    {
        // Get the session instance
        $session = session();

        // Check if the user is logged in
        if (!$session->has('userId')) {
            return redirect()->to('/login')->with('error', 'Please log in to access this page.');
        }

        // Check if the user's role is 'Operation Manager'
        $userRole = $session->get('role'); // Assuming the user's role is stored in the session

        if ($userRole !== 'Operation Manager') {
            return redirect()->to('/')->with('error', 'You do not have permission to access this page.');
        }

        // Load the AppointmentModel
        $appointModel = new AppointmentModel();

        // Fetch appointments with details
        $data = [
            'appointments' => $appointModel->getAppointmentsWithDetails(),
            'pendingAppointments' => $appointModel->AllPendingAppointments(),
        ];
        // $appointments = $appointModel->getAppointmentsWithDetails();
        // $pendingAppointments = $appointModel->AllPendingAppointments();

        // Debug appointments (remove or comment this in production)
        // dd($appointments);

        // Return the view with appointments
        return view('pages/approveApp', $data);
    }


    public function deleteAppointment($appointmentId)
    {
        $appointModel = new AppointmentModel();

        // Attempt to delete the appointment
        if ($appointModel->deleteAppointment($appointmentId)) {
            return redirect()->to('/appointments')->with('success', 'Appointment deleted successfully.');
        } else {
            return redirect()->to('/appointments')->with('error', 'Failed to delete appointment.');
        }
    }

    public function approveAppointment($appointmentId)
    {
        $appointModel = new AppointmentModel();
        $status = $this->request->getPost('status');

        // Check if the status is 'cancelled'
        if ($status === 'cancelled') {
            return redirect()->to('/approveApp')->with('error', 'Cannot approve an appointment that is cancelled.');
        }

        // Attempt to update the appointment status to 'approved'
        if ($appointModel->approveAppointment($appointmentId)) {
            return redirect()->to('/approveApp')->with('success', 'Appointment approved successfully.');
        } else {
            return redirect()->to('/approveApp')->with('error', 'Failed to approve appointment.');
        }
    }

    public function viewAppointments()
    {
        $session = session();
        $therapistId = $session->get('userId'); // Assuming the therapist's ID is stored in the session

        // Fetch appointments for the therapist
        $appointments = $this->appointmentModel->getAppointmentsByTherapist($therapistId);

        return view('pages/patientApp', ['appointments' => $appointments]);
    }

    public function viewAllAppointments()
    {
        $appointmentModel = new \App\Models\AppointmentModel();
        $therapistModel = new \App\Models\UserModel(); // Assuming therapists are stored in UserModel

        $date = $this->request->getGet('date');
        $therapistId = $this->request->getGet('therapist_id');
        $status = $this->request->getGet('status');

        $filters = [
            'date' => $date,
            'therapist_id' => $therapistId,
            'status' => $status
        ];

        $data = [
            'appointments' => $appointmentModel->getFilteredAppointments($filters),
            'therapists' => $therapistModel->getTherapist(), // you can reuse your existing method
            'filter_date' => $date,
            'filter_therapist' => $therapistId,
            'filter_status' => $status
        ];

        return view('pages/allAppointment', $data);
    }
}
