<?php

namespace App\Controllers;

use App\Models\ScheduleModel;

class scheduleController extends BaseController
{
    protected $scheduleModel;

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
    }
    public function assignSlot()
    {
        // Get therapistId, date, and time from the request
        $therapistId = $this->request->getVar('therapistId');
        $date = $this->request->getVar('date');
        $time = $this->request->getVar('time');

        // Check if a pending slot already exists for this therapist
        $existingSlot = $this->scheduleModel->where([
            'therapistId' => $therapistId,
            'status' => 'Pending'
        ])->first();

        if ($existingSlot) {
            // If a pending slot exists, return with a message or error
            return redirect()->back()->with('error', 'This therapist already has a pending slot assigned.');
        }

        // If no pending slot exists, save the new slot
        $this->scheduleModel->save([
            'slotId' => "", // Auto-generate or define slotId as needed
            'therapistId' => $therapistId,
            'date' => $date,
            'time' => $time,
            'status' => "available"
        ]);

        return redirect()->to('/slotForm')->with('success', 'Slot successfully assigned to therapist.');
    }


    public function getSchedule()
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
}
