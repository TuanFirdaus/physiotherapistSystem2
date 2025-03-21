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
}
