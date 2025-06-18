<?php

namespace App\Controllers;

use App\Models\SlotModel;
use App\Models\ScheduleModel;

class slotController extends BaseController
{
    protected $slotModel;
    protected $scheduleModel; // Declare scheduleModel property

    public function __construct()
    {
        $this->slotModel = new SlotModel();
        $this->scheduleModel = new ScheduleModel(); // Instantiate ScheduleModel if needed
    }

    public function assignSlot()
    {
        // Get therapistId, date, and time from the request
        $therapistId = $this->request->getVar('therapistId');
        $date = $this->request->getVar('date');
        $startTime = $this->request->getVar('start_time');
        $endTime = $this->request->getVar('end_time');

        // Check if a pending slot already exists for this therapist and also detect overlapping time
        $existingSlot = $this->slotModel
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
        $this->slotModel->save([
            'slotId' => "", // Auto-generate or define slotId as needed
            'therapistId' => $therapistId,
            'date' => $date,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'status' => "available"
        ]);

        return redirect()->to('/slotForm')->with('success', 'Slot successfully assigned to therapist.');
    }

    // Method to retrieve and display slots
    public function slotManagement()
    {
        // Retrieve all slots with therapist details
        $slots = $this->slotModel->getSlotsWithDetails();

        // Store slots in session
        session()->set('slotsData', $slots);

        // dd($slots); // Debugging line to check the retrieved slots

        // Pass slots to the view
        return view('pages/manageSlot', ['slots' => $slots]);
    }

    public function deleteSlot()
    {
        $slotId = $this->request->getPost('slotId');

        if (!$slotId) {
            return redirect()->back()->with('error', 'No slot selected.');
        }

        // Delete the slot from the database
        $this->slotModel->delete($slotId);

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

    public function EditSlot()
    {
        $slotId = $this->request->getPost('slotId');
        $availableTherapists = $this->slotModel->getAvailableTherapists();
        // $slot = $this->scheduleModel->find($slotId);
        $slotDetails = $this->slotModel->getSlotDetails($slotId);


        if (!$slotDetails) {
            return redirect()->to('/slot/manage')->with('error', 'Slot not found.');
        }

        $data = [
            'slot' => $slotDetails,
            'availableTherapists' => $availableTherapists,
        ];

        return view('pages/editSlot', $data);
    }

    public function updateSlot()
    {
        // Get the slotId and updated data from the request
        $slotId = $this->request->getPost('slotId');
        $therapistId = $this->request->getPost('therapistId');
        $date = $this->request->getPost('date');
        $startTime = $this->request->getPost('startTime');
        $endTime = $this->request->getPost('endTime');
        $status = $this->request->getPost('status');

        // Validate the input
        if (!$slotId || !$therapistId || !$date || !$startTime || !$endTime || !$status) {
            return redirect()->back()->with('error', 'All fields are required.');
        }

        // Check for overlapping slots for the same therapist
        $existingSlot = $this->slotModel
            ->where('therapistId', $therapistId)
            ->where('date', $date)
            ->where('slotId !=', $slotId) // Exclude the current slot
            ->groupStart()
            ->where('startTime <=', $endTime)
            ->where('endTime >=', $startTime)
            ->groupEnd()
            ->first();

        if ($existingSlot) {
            return redirect()->back()->with('error', 'This therapist already has a conflicting slot.');
        }

        // Update the slot in the database
        $updateData = [
            'therapistId' => $therapistId,
            'date' => $date,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'status' => $status,
        ];

        if ($this->slotModel->update($slotId, $updateData)) {
            return redirect()->to('/ManageSlot')->with('success', 'Slot updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update the slot.');
        }
    }
}
