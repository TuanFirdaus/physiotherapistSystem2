<?php

namespace App\Models;

use CodeIgniter\Model;


class slotModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'userId';
    // protected $allowedFields = ['userId', 'expertise', 'availability'];

    public function getAvailableTherapists()
    {
        // return $this->db->table('user')
        //     ->select('user.userId, user.name')
        //     ->join('therapist', 'therapist.userId = user.userId')
        //     ->where('user.role', 'Therapist')
        //     ->where('therapist.availability', 'available') // Adjust as per your logic
        //     ->get()
        //     ->getResultArray();
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
}
