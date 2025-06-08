<?php

namespace App\Models;

use CodeIgniter\Model;

class treatmentModel extends Model
{
    protected $table = 'patienttreatmentrecord'; // Name of the table
    // protected $useTimestamps = true; // Enable timestamps for created_at and updated_at
    protected $createdField = 'created_at'; // Name of the created_at field
    protected $updatedField = 'updated_at'; // Name of the updated_at field
    protected $primaryKey = 'recordId'; // Primary key of the table
    protected $allowedFields = ['recordId', 'patientId', 'treatmentId', 'appointmentId', 'treatmentNotes', 'status', 'session_date', 'therapistId', 'slotId']; // Columns allowed for mass assignment


    // Method to retrieve treatment records with patient and user details
    public function getAllWithPatientDetails()
    {
        return $this->db->table('patienttreatmentrecord')
            ->select('patienttreatmentrecord.*, user.name as patientName, user.userId as userId, user.name as therapistName')
            ->join('patient', 'patient.patientId = patienttreatmentrecord.patientId')
            ->join('user', 'user.userId = patienttreatmentrecord.therapistId')
            ->get()
            ->getResultArray();
    }
}
