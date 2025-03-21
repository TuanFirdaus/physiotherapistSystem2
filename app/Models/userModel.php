<?php

namespace App\Models;

use CodeIgniter\Model;

class userModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'userId';
    // protected $useTimestamps = true;
    public function login($email = false)
    {

        if ($email == false) {
            return $this->findAll();
        }

        return $this->where(['email' => $email])->first();
    }

    public function verify($email, $password)
    {
        return $this->where('email', $email)
            ->select('userId, name, email, password, role') // Include the role field
            ->first();
    }


    public function getTherapist()
    {
        return $this->db->table('user')
            ->select('user.userId, user.name, therapist.therapistId, therapist.expertise, therapist.profile_image')
            ->join('therapist', 'therapist.userId = user.userId')
            ->where('role', 'Therapist')
            ->get()
            ->getResultArray();
    }

    public function getPatient($userId)
    {
        // dd($userId);

        return $this->db->table('user')
            ->select('user.userId, user.name, patient.patientId,patient.address, patient.phoneNo')
            ->join('patient', 'patient.userId = user.userId')
            ->where('role', 'Patient')
            ->where('patient.userId', $userId)
            ->get()
            ->getRowArray();
    }
}
