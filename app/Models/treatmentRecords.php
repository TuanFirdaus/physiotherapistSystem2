<?php

namespace App\Models;

use CodeIgniter\Model;

class treatmentRecords extends Model
{
    protected $table = 'patienttreatmentrecord';
    protected $primaryKey = 'recordId';
    protected $allowedFields = ['patientId', 'treatmentId', 'appointmentId', 'treatmentNotes', 'status', 'created_at', 'updated_at', 'session_date', 'therapistId', 'slotId ', 'pain_rate'];
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
    public function saveTreatmentOutcome($appointmentId, $treatmentId, $patientId, $therapistId, $treatmentNotes, $painRate)
    {
        $existing = $this->where([
            'appointmentId' => $appointmentId,
            'therapistId' => $therapistId
        ])->first();

        $data = [
            'appointmentId'   => $appointmentId,
            'treatmentId'     => $treatmentId,
            'therapistId'     => $therapistId,
            'patientId'       => $patientId,
            'treatmentNotes'  => $treatmentNotes,
            'painRate'        => $painRate,  // optional, if you have this column
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        if ($existing) {
            return $this->update($existing['recordId'], $data);
        } else {
            $data['createdAt'] = date('Y-m-d H:i:s');
            return $this->insert($data);
        }
    }
}
