<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\TherapistModel;
use App\Models\treatmentRecords;
use App\Models\userActivityModel;
use App\Helpers\activity_helper;
use CodeIgniter\HTTP\RedirectResponse;

class therapistController extends BaseController
{
    protected $userModel;
    protected $patientModel;
    protected $therapistModel;
    protected $treatmentRecords;

    public function __construct()
    {
        $this->userModel = new userModel();
        $this->patientModel = new PatientModel();
        $this->therapistModel = new TherapistModel();
        $this->treatmentRecords = new treatmentRecords();
    }

    public function therapistProfile()
    {
        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);
        $therapist = $this->therapistModel->where('userId', $userId)->first();

        if (!$therapist) {
            return redirect()->back()->with('error', 'Therapist not found.');
        }
        $activityModel = new \App\Models\userActivityModel();
        $activities = $activityModel
            ->where('userId', session()->get('userId'))
            ->orderBy('create_at', 'DESC')
            ->findAll(5);

        $data = [
            'user' => $user,
            'therapist' => $therapist,
            'activities' => $activities,
        ];

        return view('pages/therapistProfileView', $data);
    }

    public function updateTherapistProfile()
    {
        $session = session();
        $userId = $session->get('userId');
        if (!$userId || $session->get('role') !== 'therapist') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $userModel = new UserModel();
        $therapistModel = new TherapistModel();

        // Validate input
        $rules = [
            'name'      => 'required|min_length[3]|max_length[50]',
            'email'     => 'required|valid_email',
            'phone'     => 'permit_empty',
            'age'       => 'required|integer|greater_than[0]',
            'gender'    => 'required|in_list[male,female]',
            'expertise' => 'permit_empty',
            'password'  => 'permit_empty|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please check your input.');
        }

        // Update user table
        $userData = [
            'name'   => $this->request->getPost('name'),
            'email'  => $this->request->getPost('email'),
            'age'    => $this->request->getPost('age'),
            'gender' => $this->request->getPost('gender'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($userId, $userData);

        // Update therapist table
        $therapist = $therapistModel->where('userId', $userId)->first();
        if ($therapist) {
            $therapistData = [
                'phoneNo'   => $this->request->getPost('phone'),
                'expertise' => $this->request->getPost('expertise'),
            ];
            $therapistModel->update($therapist['therapistId'], $therapistData);
        }
        log_user_activity(session()->get('userId'), "updated your profile on " . date('Y-m-d H:i:s'));

        // Optionally update session data
        $session->set([
            'name'          => $userData['name'],
            'email'         => $userData['email'],
            'expertise'     => $this->request->getPost('expertise'),
            'phoneNo'       => $this->request->getPost('phone'),
        ]);

        return redirect()->to('/therapistProfileView')->with('success', 'Profile updated successfully.');
    }

    public function uploadTherapistProfilePicture()
    {
        $session = session();
        $userId = $session->get('userId');
        if (!$userId || $session->get('role') !== 'therapist') {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $file = $this->request->getFile('profilePicture');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validate file type and size if needed
            $newName = $file->getRandomName();
            $file->move('uploads/profile_pictures', $newName);

            // Update in DB
            $therapistModel = new \App\Models\TherapistModel();
            $therapist = $therapistModel->where('userId', $userId)->first();
            if ($therapist) {
                $therapistModel->update($therapist['therapistId'], [
                    'profile_image' => 'uploads/profile_pictures/' . $newName
                ]);
            }
            log_user_activity(session()->get('userId'), "updated your profile picture on " . date('Y-m-d H:i:s'));

            // Update session
            $session->set('profile_image', 'uploads/profile_pictures/' . $newName);

            return redirect()->to('/therapistProfileView')->with('success', 'Profile picture updated successfully.');
        }

        return redirect()->to('/therapistProfileView')->with('error', 'Failed to upload profile picture.');
    }

    public function removeTherapistProfilePicture()
    {
        $session = session();
        $userId = $session->get('userId');

        // Optionally remove the file from the server
        $currentPicture = $session->get('profile_image');
        if ($currentPicture && file_exists($currentPicture) && $currentPicture !== 'assets/img/defaultProfilePic.jpg') {
            unlink($currentPicture);
        }

        // Set to default
        $defaultPath = 'assets/img/defaultProfilePic.jpg';

        // Update in session
        $session->set('profile_image', $defaultPath);

        // Update in database (optional)
        $this->therapistModel->where('userId', $userId)->set(['profile_image' => $defaultPath])->update();
        log_user_activity(session()->get('userId'), "remove your profile picture on " . date('Y-m-d H:i:s'));

        return redirect()->back()->with('message', 'Profile picture removed.');
    }

    public function myPatients()
    {
        $therapistId = session()->get('therapistId');
        if (!$therapistId) {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('appointment')
            ->select('appointment.*, patient.patientId, user.name as patient_name, user.email, patient.phoneNo, slot.date as appointment_date')
            ->join('patient', 'patient.patientId = appointment.patientId')
            ->join('user', 'user.userId = patient.userId')
            ->join('slot', 'slot.slotId = appointment.slotId') // Join slot table
            ->where('appointment.therapistId', $therapistId)
            ->orderBy('appointment.appointmentId', 'DESC');

        $appointments = $builder->get()->getResultArray();

        return view('pages/myPatients', ['appointments' => $appointments]);
    }

    public function addTreatmentOutcome($appointmentId)
    {
        $therapistId = session()->get('therapistId');
        if (!$therapistId) {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $appointmentModel = new \App\Models\AppointmentModel();
        $treatmentId = $appointmentModel->getTreatmentIdByAppointment($appointmentId);

        if ($this->request->getMethod() === 'post') {
            $outcome = $this->request->getPost('treatment_outcome');
            $treatmentRecordModel = new \App\Models\TreatmentRecords();

            $treatmentRecordModel->save([
                'appointmentId' => $appointmentId,
                'treatmentId' => $treatmentId,
                'therapistId' => $therapistId,
                'outcome' => $outcome,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return redirect()->to('/therapist/myPatients')->with('success', 'Treatment outcome saved.');
        }


        return view('pages/addTreatmentOutcome', [
            'appointmentId' => $appointmentId,
            'treatmentId'   => $treatmentId,
            'outcome'       => $record['treatmentNotes'] ?? '',
            'pain_rate'     => $record['pain_rate'] ?? '',
        ]);
    }

    public function saveTreatmentOutcome()
    {
        // $appointmentId = $this->request->getPost('appointmentId');
        $therapistId = session()->get('therapistId');
        if (!$therapistId) {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        $treatmentId = $this->request->getPost('treatmentId');
        if (!$treatmentId) {
            return redirect()->back()->with('error', 'Treatment ID is required.');
        }

        $appointmentId = $this->request->getPost('appointmentId');
        $treatmentNotes = $this->request->getPost('treatment_outcome');
        $appointmentModel = new \App\Models\AppointmentModel();
        $patientId = $appointmentModel->getPatientIdByAppointment($appointmentId);
        $treatmentRecordModel = new \App\Models\treatmentRecords();
        // dd($appointmentId, $treatmentId, $patientId, $therapistId, $treatmentNotes);
        // Use the model method you added earlier
        $painRate = $this->request->getPost('pain_rate');
        $treatmentRecordModel->saveTreatmentOutcome($appointmentId, $treatmentId, $patientId, $therapistId, $treatmentNotes, $painRate);
        return redirect()->to('/therapist/myPatients')->with('success', 'Treatment outcome saved.');
    }
}
