<?php

namespace App\Models;

use CodeIgniter\Model;

class scheduleModel extends Model
{
    protected $table = 'slot'; // Name of the table
    protected $primaryKey = 'slotId'; // Primary key
    protected $allowedFields = ['slotId', 'therapistId', 'date', 'time', 'status']; // Columns allowed for mass assignment

    public function therapistsSchedule($date)
    {
        return $this->db->table('slot')
            ->select('user.name, user.email,therapist.therapistId, slot.slotId, slot.date, slot.time, slot.status') // Select therapistId and name
            ->join('therapist', 'therapist.therapistId = slot.therapistId')   // Join with therapist table
            ->join('user', 'user.userId = therapist.userId') // Join with user table
            ->where('slot.date', $date) // Where date is match with the prompt
            ->get()
            ->getResultArray();
    }

    public function slotSchedule($therapistId)
    {
        return $this->db->table('slot')
            ->select('user.name, user.email,therapist.therapistId, slot.slotId, slot.date, slot.time, slot.status') // Select therapistId and name
            ->join('therapist', 'therapist.therapistId = slot.therapistId')   // Join with therapist table
            ->join('user', 'user.userId = therapist.userId') // Join with user table
            ->where('therapist.therapistId', $therapistId) // Where date is match with the prompt
            ->where('slot.status', 'available')
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
}
