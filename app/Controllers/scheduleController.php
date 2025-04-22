<?php

namespace App\Controllers;

use App\Models\ScheduleModel;
use App\Models\UserModel;
use App\Models\AppointmentModel;

class scheduleController extends BaseController
{
    protected $scheduleModel;
    protected $userModel; // Declare userModel property
    protected $appointmentModel;

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
        $this->userModel = new UserModel(); // Instantiate UserModel if needed
        $this->appointmentModel = new AppointmentModel(); // Instantiate AppointmentModel
    }


    public function getSchedule()
    {
        // Fetch slots from the model
        $allSlots = $this->scheduleModel->getScheduleSlot();

        // Ensure $allSlots is not null
        if (!$allSlots) {
            $allSlots = [];
        }

        // Store slots in session
        session()->set('allSlots', $allSlots);
        dd($allSlots);
        // Render the view
        return view('pages/manageSchedule', ['allSlots' => $allSlots]);
    }
    // Method to display the edit form
    public function edit($appointmentId)
    {
        $appointment = $this->appointmentModel->find($appointmentId);
        $therapists = $this->userModel->findAll();

        if (!$appointment) {
            return redirect()->to('/appointments')->with('error', 'Appointment not found.');
        }

        $data = [
            'appointment' => $appointment,
            'therapists' => $therapists,
        ];

        return view('pages/editSlot', $data);
    }

    // Method to handle the update
    public function update($appointmentId)
    {
        $data = [
            'therapistId' => $this->request->getPost('therapistId'),
            'date' => $this->request->getPost('date'),
            'startTime' => $this->request->getPost('startTime'),
            'endTime' => $this->request->getPost('endTime'),
            'status' => $this->request->getPost('status'),
        ];

        if ($this->appointmentModel->update($appointmentId, $data)) {
            return redirect()->to('/appointments')->with('success', 'Appointment updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update appointment.');
        }
    }
}
