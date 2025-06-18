<?php

namespace App\Models;

use CodeIgniter\Model;

class therapistModel extends Model
{
    protected $table = 'therapist';
    protected $primaryKey = 'therapistId';
    protected $allowedFields = ['userId', 'expertise', 'availability', 'profile_image', 'phoneNo'];

    // Method to retrieve therapist details with user data
    public function getTherapistDetails($therapistId)
    {
        return $this->db->table('therapist')
            ->select('therapist.therapistId, therapist.expertise, therapist.availability, user.name, user.userId , profile_image')
            ->join('user', 'user.userId = therapist.userId')
            ->where('therapist.therapistId', $therapistId)
            ->get()
            ->getRowArray();
    }

    // Method to retrieve all therapists with user data
    public function getTherapist()
    {
        return $this->db->table('therapist')
            ->select('therapist.therapistId, therapist.expertise, therapist.availability, user.name, user.userId , profile_image, user.name as therapistName')
            ->join('user', 'user.userId = therapist.userId')
            ->get()
            ->getResultArray();
    }

    // Method to update therapist and user data
    public function updateTherapistDetails($therapistId, $userId, $data)
    {
        // Update the user table
        if (isset($data['name'])) {
            $this->db->table('user')
                ->where('userId', $userId)
                ->update(['name' => $data['name']]);
        }

        // Update the therapist table
        $therapistData = array_intersect_key($data, array_flip($this->allowedFields));
        if (!empty($therapistData)) {
            $this->db->table('therapist')
                ->where('therapistId', $therapistId)
                ->update($therapistData);
        }

        return true;
    }
}
