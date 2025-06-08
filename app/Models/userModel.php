<?php

namespace App\Models;

use CodeIgniter\Model;

class userModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'userId';
    protected $allowedFields = ['name', 'age', 'email', 'password', 'role', 'gender'];

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

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Password is correct, return user data
        }
        return null; // Incorrect password or user not found
    }

    public function getUserDetails()
    {
        return $this->where('userId')->first();
    }

    public function getTherapist()
    {
        return $this->db->table('user')
            ->select('user.userId, user.name, user.email, therapist.therapistId, therapist.expertise, therapist.profile_image')
            ->join('therapist', 'therapist.userId = user.userId')
            ->where('role', 'Therapist')
            ->get()
            ->getResultArray();
    }

    public function getManageTherapists()
    {
        return $this->db->table('user')
            ->select('therapist.therapistId, user.name, therapist.expertise, therapist.availability , therapist.profile_image')
            ->join('therapist', 'therapist.userId = user.userId')
            ->where('user.role', 'Therapist')
            ->get()
            ->getResultArray();
    }

    public function getTherapistDetailsById($userId)
    {
        return $this->db->table('user')
            ->select('user.userId, user.name, user.email, therapist.therapistId, therapist.expertise, therapist.profile_image')
            ->join('therapist', 'therapist.userId = user.userId')
            ->where('role', 'therapist')
            ->where('user.userId', $userId)
            ->get()
            ->getRowArray(); // <- Better to use getRowArray() instead of getResultArray() for single user
    }

    public function getOperationManagerDetailsById($userId)
    {
        return $this->db->table('user')
            ->select('user.userId, user.name, user.email, operationmanager.omId, operationmanager.profile_image')
            ->join('operationmanager', 'operationmanager.userId = user.userId')
            ->where('role', 'Operation Manager')
            ->where('user.userId', $userId)
            ->get()
            ->getRowArray();
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
    public function getManagePatients()
    {
        return $this->db->table('user')
            ->select('patient.patientId, user.name, patient.address, patient.phoneNo')
            ->join('patient', 'patient.userId = user.userId')
            ->where('user.role', 'Patient')
            ->get()
            ->getResultArray();
    }

    public function getTotalUser()
    {
        return $this->db->table('user')
            ->select('role, COUNT(*) as total')
            ->whereIn('role', ['patient', 'therapist']) // Filter for Patient and Therapist roles
            ->groupBy('role') // Group by role
            ->get()
            ->getResultArray();
    }
}
