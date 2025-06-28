<?php

namespace App\Models;

use CodeIgniter\Model;

class treatmentRecords extends Model
{
    protected $table = 'patienttreatmentrecord';
    protected $primaryKey = 'recordId';
    protected $allowedFields = ['patientId', 'treatmentId', 'appointmentId', 'therapistId', 'treatmentNotes', 'status', 'created_at', 'updated_at', 'therapistId', 'slotId', 'pain_rate', 'diagnosis', 'nextAppointment'];
    protected $returnType = 'array';
    protected $useTimestamps = true;

    public function getAllTreatmentRecords()
    {
        return $this->findAll();
    }
    //sini
    public function getAllDetailedRecords()
    {
        return $this->db->table($this->table)
            ->select('
                patienttreatmentrecord.*,
                patientUser.name as patientName,
                patientUser.email as patientEmail,
                patient.phoneNo as patientPhone,
                therapistUser.name as therapistName,
                treatment.name as treatmentName,
                slot.date as appointmentDate
            ')
            // Join to patient → then to user as patientUser
            ->join('patient', 'patient.patientId = patienttreatmentrecord.patientId')
            ->join('user as patientUser', 'patientUser.userId = patient.userId')

            // Join to therapist → then to user as therapistUser
            ->join('therapist', 'therapist.therapistId = patienttreatmentrecord.therapistId')
            ->join('user as therapistUser', 'therapistUser.userId = therapist.userId')

            ->join('treatment', 'treatment.treatmentId = patienttreatmentrecord.treatmentId')
            ->join('slot', 'slot.slotId = patienttreatmentrecord.slotId')
            ->orderBy('patienttreatmentrecord.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getRecordsByPatient($patientId)
    {
        return $this->db->table($this->table)
            ->select('
                patienttreatmentrecord.*,
                therapistUser.name as therapistName,
                treatment.name as treatmentName,
                slot.date as appointmentDate,
                patientUser.name as patientName,
                patientUser.email as patientEmail
            ')
            // Join to patient → then to user as patientUser
            ->join('patient', 'patient.patientId = patienttreatmentrecord.patientId')
            ->join('user as patientUser', 'patientUser.userId = patient.userId')
            // Join to therapist → then to user as therapistUser
            ->join('therapist', 'therapist.therapistId = patienttreatmentrecord.therapistId')
            ->join('user as therapistUser', 'therapistUser.userId = therapist.userId')
            ->join('treatment', 'treatment.treatmentId = patienttreatmentrecord.treatmentId')
            ->join('slot', 'slot.slotId = patienttreatmentrecord.slotId')
            ->where('patienttreatmentrecord.patientId', $patientId)
            ->orderBy('patienttreatmentrecord.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
    //sampai sini
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
    public function saveTreatmentOutcome($appointmentId, $treatmentId, $patientId, $therapistId, $treatmentNotes, $painRate,  $slotId)
    {
        $existing = $this->where([
            'appointmentId' => $appointmentId,
            'therapistId' => $therapistId,
            'treatmentId' => $treatmentId,
            'patientId' => $patientId
        ])->first();

        $data = [
            'appointmentId'   => $appointmentId,
            'treatmentId'     => $treatmentId,
            'therapistId'     => $therapistId,
            'patientId'       => $patientId,
            'slotId'          => $slotId,
            'status'          => 'completed',
            'treatmentNotes'  => $treatmentNotes,
            'pain_rate'        => $painRate,
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
