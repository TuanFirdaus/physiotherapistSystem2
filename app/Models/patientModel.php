<?php

namespace App\Models;

use CodeIgniter\Model;

class patientModel extends Model
{
    protected $table = 'patient';
    protected $primaryKey = 'patientId';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['userId', 'address', 'phoneNo', 'profilePicture', 'patientCode'];

    // Method to retrieve patient details with user data
    public function getPatientDetails($patientId)
    {
        return $this->db->table('patient')
            ->select('patient.patientId, patient.address, patient.phoneNo, user.name, user.userId, patient.profilePicture')
            ->join('user', 'user.userId = patient.userId')
            ->where('patient.patientId', $patientId)
            ->get()
            ->getRowArray();
    }

    public function getPatientDetailsByUserId($userId)
    {
        return $this->db->table('patient')
            ->select('patient.patientId, patient.address, patient.phoneNo, user.name, user.userId, patient.profilePicture')
            ->join('user', 'user.userId = patient.userId')
            ->where('user.userId', $userId)
            ->get()
            ->getRowArray();
    }

    // Method to update patient and user data
    public function updatePatientDetails($patientId, $userId, $data)
    {
        // Update the user table
        if (isset($data['name'])) {
            $this->db->table('user')
                ->where('userId', $userId)
                ->update(['name' => $data['name']]);
        }

        // Update the patient table
        $patientData = array_intersect_key($data, array_flip($this->allowedFields));
        if (!empty($patientData)) {
            $this->db->table('patient')
                ->where('patientId', $patientId)
                ->update($patientData);
        }

        return true;
    }
    // App\Models\PatientModel.php
    public function getAllWithUserInfo()
    {
        return $this->db->table('patient')
            ->select('patient.patientId as id, user.name')
            ->join('user', 'user.userId = patient.userId')
            ->get()
            ->getResultArray();
    }

    public function treatmentFormDetails($patientId)
    {
        return $this->db->table('appointment')
            ->select('appointment.appointmentId, appointment.patientId, appointment.therapistId, appointment.slotId, appointment.treatmentId, treatment.name as treatmentName, slot.date as session_date, slot.startTime, slot.endTime')
            ->join('patient', 'patient.patientId = appointment.patientId')
            ->join('therapist', 'therapist.therapistId = appointment.therapistId')
            ->join('slot', 'slot.slotId = appointment.slotId')
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId')
            ->join('user', 'user.userId = therapist.userId')
            ->where('appointment.patientId', $patientId)
            ->get()
            ->getResultArray();
    }



    public function getPatientWithUser($patientId)
    {
        return $this->db->table('patient')
            ->select('patient.*, user.name')
            ->join('user', 'user.userId = patient.userId')
            ->where('patient.patientId', $patientId)
            ->get()
            ->getRowArray();
    }
}
