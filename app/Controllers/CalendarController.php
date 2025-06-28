<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\SlotModel;
use App\Models\PatientModel;
use App\Models\treatmentPackage;
use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\therapistModel;

class CalendarController extends BaseController
{
    protected $appointmentModel;
    protected $slotModel;
    protected $treatmentModel;
    protected $patientModel;
    protected $therapistModel;
    protected $userModel;

    function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->slotModel = new SlotModel();
        $this->treatmentModel = new treatmentPackage();
        $this->patientModel = new PatientModel();
        $this->therapistModel = new therapistModel();
        $this->userModel = new userModel();
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
        $therapist = $this->therapistModel->where('userId', $userId)->first();
        if (!$therapist) {
            return redirect()->to('/login')->with('error', 'Therapist not found.');
        }
        $therapistId = $therapist['therapistId'];

        // Retrieve slots and appointments for this therapist
        $appointments = $this->appointmentModel
            ->where('status', 'Approved')
            ->where('therapistId', $therapistId)
            ->findAll();

        $allSlots = $this->slotModel->where('therapistId', $therapistId)->findAll();
        $bookedSlotIds = array_column($appointments, 'slotId');

        // Find available slots (not booked)
        $availableSlots = array_filter($allSlots, function ($slot) use ($bookedSlotIds) {
            return !in_array($slot['slotId'], $bookedSlotIds);
        });

        $calendarData = [];

        // Add booked appointments to calendar
        foreach ($appointments as $appointment) {
            $patient = $this->patientModel->find($appointment['patientId']);
            $user = $this->userModel->find($patient['userId']);
            $slot = $this->slotModel->find($appointment['slotId']);
            $treatment = $this->treatmentModel->find($appointment['treatmentId']);

            $calendarData[] = [
                'title' => $user['name'] . ' - ' . $treatment['name'],
                'start' => $slot['date'] . 'T' . $slot['startTime'],
                'end' => $slot['date'] . 'T' . $slot['endTime'],
                'className' => 'booked', // Custom class for styling
                'slotId' => $slot['slotId'],
                'patientName' => $user['name'],
                'treatment' => $treatment['name'],
                'startTime' => $slot['startTime'],
                'endTime' => $slot['endTime'],
            ];
        }

        // Add available slots to calendar
        foreach ($availableSlots as $slot) {
            $calendarData[] = [
                'title' => 'Available',
                'start' => $slot['date'] . 'T' . $slot['startTime'],
                'end' => $slot['date'] . 'T' . $slot['endTime'],
                'className' => 'available',
                'slotId' => $slot['slotId'],
                'patientName' => '',
                'treatment' => 'Available',
                'startTime' => $slot['startTime'],
                'endTime' => $slot['endTime'],
            ];
        }

        return view('pages/calendar', ['calendarEvents' => $calendarData]);
    }

    // Add any new methods for swapping or managing the slot here
}
