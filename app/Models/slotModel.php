<?php

namespace App\Models;

use CodeIgniter\Model;


class slotModel extends Model
{
    //kena check balik method getAvailableTherapists ni
    protected $table = 'slot';
    protected $primaryKey = 'slotId';
    protected $allowedFields = [
        'slotId',
        'therapistId',
        'date',
        'startTime',
        'endTime',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;            // Enables auto timestamps
    protected $createdField  = 'created_at';    // Field name for created
    protected $updatedField  = 'updated_at';

    public function getAvailableTherapists()
    {
        return $this->db->table('user')
            ->select('therapist.therapistId, user.name') // Select therapistId and name
            ->join('therapist', 'therapist.userId = user.userId')
            ->where('user.role', 'Therapist')
            ->where('therapist.availability', 'available') // Adjust as per your logic
            ->get()
            ->getResultArray();
    }
    public function getSlotsWithDetails()
    {
        return $this->db->table('slot')
            ->select('slot.slotId, slot.date, slot.startTime, slot.endTime, slot.status, user.name as therapistName')
            ->join('therapist', 'therapist.therapistId = slot.therapistId')
            ->join('user', 'user.userId = therapist.userId')
            ->get()
            ->getResultArray();
    }

    public function update($id = null, $data = null): bool
    {
        if ($id === null || $data === null) {
            return false; // Return false if parameters are missing
        }

        return $this->db->table('slot')
            ->where('slotId', $id)
            ->update($data);
    }


    public function getSlotDetails($slotId)
    {
        return $this->db->table('slot')
            ->select('user.name as therapistName, user.email, therapist.therapistId, slot.slotId, slot.date, slot.startTime, slot.endTime, slot.status')
            ->join('therapist', 'therapist.therapistId = slot.therapistId')
            ->join('user', 'user.userId = therapist.userId')
            ->where('slot.slotId', $slotId)
            ->get()
            ->getRowArray();
    }

    public function getWeeklySessionHoursByTherapist($therapistId)
    {
        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        $endOfWeek = date('Y-m-d', strtotime('sunday this week'));

        $slots = $this->where('therapistId', $therapistId)
            ->where('date >=', $startOfWeek)
            ->where('date <=', $endOfWeek)
            ->findAll();

        $totalHours = 0;

        foreach ($slots as $slot) {
            $start = strtotime($slot['startTime']);
            $end = strtotime($slot['endTime']);
            $durationInHours = ($end - $start) / 3600; // convert seconds to hours
            $totalHours += $durationInHours;
        }

        return round($totalHours, 1); // rounded to 1 decimal
    }

    public function slotSchedule($therapistId)
    {
        return $this->db->table('slot')
            ->select('user.name, user.email,therapist.therapistId, slot.slotId, slot.date, slot.startTime, slot.endTime, slot.status') // Select therapistId and name
            ->join('therapist', 'therapist.therapistId = slot.therapistId')   // Join with therapist table
            ->join('user', 'user.userId = therapist.userId') // Join with user table
            ->where('therapist.therapistId', $therapistId) // Where date is match with the prompt
            ->where('slot.status', 'available')
            ->get()
            ->getResultArray();
    }

    public function therapistsSchedule($date)
    {
        return $this->db->table('slot')
            ->select('user.name, user.email,therapist.therapistId, slot.slotId, slot.date, slot.startTime, slot.endTime, slot.status') // Select therapistId and name
            ->join('therapist', 'therapist.therapistId = slot.therapistId')   // Join with therapist table
            ->join('user', 'user.userId = therapist.userId') // Join with user table
            ->where('slot.date', $date) // Where date is match with the prompt
            ->get()
            ->getResultArray();
    }

    public function getScheduleSlot()
    {
        return $this->db->table('slot')
            ->select('user.name, user.email, therapist.therapistId, slot.slotId, slot.date, slot.startTime, slot.endTime, slot.status')
            ->join('therapist', 'therapist.therapistId = slot.therapistId')
            ->join('user', 'user.userId = therapist.userId')
            ->get()
            ->getResultArray();
    }
}
