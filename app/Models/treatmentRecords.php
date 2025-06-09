<?php

namespace App\Models;

use CodeIgniter\Model;

class treatmentRecords extends Model
{
    protected $table = 'patienttreatmentrecord';
    protected $primaryKey = 'recordId';
    protected $allowedFields = ['patientId', 'treatmentId', 'appointmentId', 'treatmentNotes', 'status', 'createdAt', 'updated_at', 'session_date', 'therapistId', 'slotId '];
    protected $returnType = 'array';
    protected $useTimestamps = true;

    public function getAllTreatmentRecords()
    {
        return $this->findAll();
    }

    public function getTotalRecords()
    {
        return $this->db->table('patienttreatmentrecord')
            ->select('COUNT(*) as totalRecords')
            ->countAllResults();
    }

    public function getTreatmentRecordById($treatmentId)
    {
        return $this->where('treatmentId', $treatmentId)->first();
    }

    public function addTreatmentRecord($data)
    {
        return $this->insert($data);
    }

    public function updateTreatmentRecord($treatmentId, $data)
    {
        return $this->update($treatmentId, $data);
    }

    public function deleteTreatmentRecord($treatmentId)
    {
        return $this->delete($treatmentId);
    }
}
