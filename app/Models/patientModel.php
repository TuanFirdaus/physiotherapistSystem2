<?php

namespace App\Models;

use CodeIgniter\Model;

class patientModel extends Model
{
    protected $table = 'patient';
    protected $primaryKey = 'patientId';
    protected $allowedFields = ['address', 'phoneNo'];

    // Method to retrieve patient details with user data
    public function getPatientDetails($patientId)
    {
        return $this->db->table('patient')
            ->select('patient.patientId, patient.address, patient.phoneNo, user.name, user.userId')
            ->join('user', 'user.userId = patient.userId')
            ->where('patient.patientId', $patientId)
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
}
