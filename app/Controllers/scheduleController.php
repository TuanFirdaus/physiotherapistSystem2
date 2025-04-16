<?php

namespace App\Controllers;

use App\Models\ScheduleModel;
use App\Models\UserModel;

class scheduleController extends BaseController
{
    protected $scheduleModel;
    protected $userModel; // Declare userModel property

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
        $this->userModel = new UserModel(); // Instantiate UserModel if needed
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
        $allSlots = $this->scheduleModel->getScheduleSlot(); // call the model method

        // Store data in session
        session()->set('allSlots', $allSlots);

        // Render the first view
        return view('pages/manageSchedule');
    }

    public function getTry()
    {
        return view('pages/schedule');
    }

    public function TrySchedule()
    {
        //retrive the data from the form input
        $date = $this->request->getVar('date');

        //fetch therapist assigned to the specified date
        $therapists = $this->scheduleModel->therapistsSchedule($date);

        $data = [
            'date' => $date,
            'therapistsSchedule' => $therapists
        ];

        // Load session
        session()->set('scheduleData', $data);

        // dd($data);
        return view('/pages/schedule', $data);
    }

    public function deleteSlot($slotId)
    {
        $this->scheduleModel->delete($slotId);
        return redirect()->back()->with('success', 'Slot deleted successfully.');
    }
}
