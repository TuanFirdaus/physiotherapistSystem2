<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\SlotModel;
use App\Models\PatientModel;
use App\Models\treatmentPackage;
use App\Models\UserModel;
use CodeIgniter\Controller;
use Faker\Provider\Base;
use App\Models\therapistModel;

class CalendarController extends BaseController
{
    protected $appointmentModel;
    protected $slotModel;
    protected $treatmentModel;
    protected $patientModel;
    protected $therapistModel;

    function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->slotModel = new SlotModel();
        $this->treatmentModel = new treatmentPackage();
        $this->patientModel = new PatientModel();
        $this->therapistModel = new therapistModel();
    }
    public function getCalendar()
    {
        $userId = session()->get('userId');
        $role = session()->get('role');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Unauthorized access.');
        }

        // Block access if role is patient
        if ($role === 'patient') {
            return redirect()->to('/')->with('error', 'You are not authorized to access the calendar.');
        }


        // Find therapistId connected to this userId
        $therapistModel = new \App\Models\therapistModel();
        $therapist = $therapistModel->where('userId', $userId)->first();
        if (!$therapist) {
            return redirect()->to('/login')->with('error', 'Therapist not found.');
        }
        $therapistId = $therapist['therapistId'];

        $appointmentModel = new AppointmentModel();
        $slotModel = new SlotModel();
        $patientModel = new PatientModel();
        $treatmentPackage = new treatmentPackage();
        $userModel = new UserModel();

        // Only retrieve approved appointments for this therapist
        $appointments = $appointmentModel
            ->where('status', 'Approved')
            ->where('therapistId', $therapistId)
            ->findAll();

        $calendarData = [];

        foreach ($appointments as $appointment) {
            $patient = $patientModel->find($appointment['patientId']);
            $user = $userModel->find($patient['userId']);
            $slot = $slotModel->find($appointment['slotId']);
            $treatment = $treatmentPackage->find($appointment['treatmentId']);

            $calendarData[] = [
                'patient_name' => $user['name'],
                'treatment' => $treatment['name'],
                'date' => $slot['date'],
                'start_time' => $slot['startTime'],
                'end_time' => $slot['endTime'],
            ];
        }

        return view('pages/calendar', ['appointments' => $calendarData]);
    }
}
