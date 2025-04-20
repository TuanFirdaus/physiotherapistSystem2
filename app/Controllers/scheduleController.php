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
    public function assignSlot()
    {
        // Get therapistId, date, and time from the request
        $therapistId = $this->request->getVar('therapistId');
        $date = $this->request->getVar('date');
        $startTime = $this->request->getVar('start_time');
        $endTime = $this->request->getVar('end_time');

        // Check if a pending slot already exists for this therapist and also detect overlapping time
        $existingSlot = $this->scheduleModel
            ->where('therapistId', $therapistId)
            ->where('date', $date)
            ->groupStart()
            ->where('startTime <=', $endTime)
            ->where('endTime >=', $startTime)
            ->groupEnd()
            ->first();

        if ($existingSlot) {
            // If a pending slot exists, return with a message or error
            return redirect()->back()->with('error', 'This therapist already has a pending slot assigned.');
        }

        // If no pending slot exists, save the new slot
        $this->scheduleModel->save([
            'slotId' => "", // Auto-generate or define slotId as needed
            'therapistId' => $therapistId,
            'date' => $date,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'status' => "available"
        ]);

        return redirect()->to('/slotForm')->with('success', 'Slot successfully assigned to therapist.');
    }


    public function getSchedule()
    {
        // Get all slots with therapist and user info
        $data = [
            $allSlots = $this->scheduleModel->getScheduleSlot(), // call the model method\
            $appointments = $this->appointmentModel->getAppointmentsWithDetails(),
        ];
        // Store data in session
        session()->set('allSlots', $allSlots);

        // Render the first view
        return view('pages/manageSchedule');
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

    public function deleteSlot()
    {
        $slotId = $this->request->getPost('slotId');

        if (!$slotId) {
            return redirect()->back()->with('error', 'No slot selected.');
        }

        // Delete the slot from the database
        $this->scheduleModel->delete($slotId);

        // Retrieve the current session data
        $allSlots = session()->get('allSlots') ?? [];

        // Filter out the deleted slot from the session
        $updatedSlots = array_filter($allSlots, function ($slot) use ($slotId) {
            return $slot['slotId'] != $slotId;
        });

        // Update the session with the filtered slots
        session()->set('allSlots', $updatedSlots);

        return redirect()->back()->with('success', 'Slot deleted successfully.');
    }

    public function EditSlot($slotId)
    {
        // $slot = $this->scheduleModel->find($slotId);
        $slotDetails = $this->scheduleModel->getSlotDetails($slotId);

        if (!$slotDetails) {
            return redirect()->to('/slot/manage')->with('error', 'Slot not found.');
        }
        dd($slotDetails);
        // Merge slot details into the slot array
        // $slotS = array_merge($slot, $slotDetails);
        // dd($slot);
        return view('pages/editSlot', ['slot' => $slotDetails,]);
    }
}
