<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'appointmentId';
    protected $allowedFields = ['therapistId', 'patientId', 'slotId', 'status', 'treatmentId'];
    protected $returnType = 'array';
    public function getTreatmentIdByAppointment($appointmentId)
    {
        $appointment = $this->find($appointmentId);
        return $appointment['treatmentId'] ?? null;
    }
    public function getPatientIdByAppointment($appointmentId)
    {
        $appointment = $this->find($appointmentId);
        return $appointment['patientId'] ?? null;
    }
    public function getPendingAppointments($patientId)
    {
        return $this->db->table('appointment')
            ->select('
            patient_user.name AS patientName,
            patient_user.email AS patientEmail,
            patient.phoneNo AS patientPhoneNum,
            therapist_user.name AS therapistName,
            therapist.therapistId,
            appointment.appointmentId,
            slot.date,
            slot.startTime,
            slot.endTime,
            appointment.status,
            treatment.treatmentId,
            treatment.price,
            treatment.name AS treatmentName
        ')
            ->join('patient', 'patient.patientId = appointment.patientId')
            ->join('user AS patient_user', 'patient_user.userId = patient.userId') // Patient's user info
            ->join('therapist', 'therapist.therapistId = appointment.therapistId')
            ->join('user AS therapist_user', 'therapist_user.userId = therapist.userId') // Therapist's user info
            ->join('slot', 'slot.slotId = appointment.slotId')
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId')
            ->where('appointment.patientId', $patientId)
            ->where('appointment.status', 'pending')
            ->get()
            ->getResultArray();
    }

    public function AllPendingAppointments()
    {
        return $this->db->table('appointment')
            ->select('
            user.name AS patientName, 
            user.email, 
            therapist.therapistId, 
            appointment.appointmentId, 
            slot.date, 
            slot.startTime, 
            slot.endTime, 
            appointment.status, 
            treatment.treatmentId,  
            treatment.price as treatmentPrice, 
            treatment.name as treatmentName, 
            patient.phoneNo as patientPhoneNum
        ')
            ->join('patient', 'patient.patientId = appointment.patientId') // Join patient table first
            ->join('user', 'user.userId = patient.userId') // Join user table for patient name
            ->join('therapist', 'therapist.therapistId = appointment.therapistId') // Join therapist table
            ->join('slot', 'slot.slotId = appointment.slotId') // Join slot table
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId') // Join treatment table
            ->where('appointment.status', 'pending')
            ->get()
            ->getResultArray();
    }

    public function getTreatmentName($appointmentId)
    {
        return $this->db->table('appointment')
            ->select('treatment.treatmentId, treatment.name, treatment.price, appointment.appointmentId')
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId')
            ->where('appointmentId', $appointmentId)
            ->get()
            ->getRowArray();
    }

    public function getAppointmentsWithDetails()
    {
        return $this->db->table('appointment')
            ->select('appointment.appointmentId, user.name AS patientName, patient.phoneNo as patientPhoneNum, treatment.name as treatmentName, treatment.price as treatmentPrice, appointment.status')
            ->join('patient', 'patient.patientId = appointment.patientId')
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId')
            ->join('user', 'user.userId = patient.userId')
            ->whereIn('appointment.status', ['approved', 'cancelled']) // Add condition for status
            ->get()
            ->getResultArray();
    }

    public function getRecentAppointment($limit = 5)
    {
        return $this->db->table('appointment')
            ->select('
            appointment.appointmentId,
            user.name AS patientName,
            patient.phoneNo as patientPhoneNum,
            treatment.name as treatmentName,
            treatment.price as treatmentPrice,
            appointment.status,
            slot.date,
            slot.startTime,
            slot.endTime
        ')
            ->join('patient', 'patient.patientId = appointment.patientId')
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId')
            ->join('user', 'user.userId = patient.userId')
            ->join('slot', 'slot.slotId = appointment.slotId')
            ->orderBy('appointment.appointmentId', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
    public function getAppointmentDetailsById($appointmentId)
    {
        return $this->db->table('appointment')
            ->select('
            appointment.*,
            patient.phoneNo AS patientPhoneNum,
            user.name AS patientName,
            user.email AS patientEmail,
            therapist_user.name AS therapistName,
            therapist_user.email AS therapistEmail,
            treatment.name AS treatmentName,
            treatment.price AS treatmentPrice,
            slot.date,
            slot.startTime,
            slot.endTime
        ')
            ->join('patient', 'patient.patientId = appointment.patientId')
            ->join('user', 'user.userId = patient.userId') // patient user
            ->join('therapist', 'therapist.therapistId = appointment.therapistId')
            ->join('user AS therapist_user', 'therapist_user.userId = therapist.userId') // therapist user
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId')
            ->join('slot', 'slot.slotId = appointment.slotId')
            ->where('appointment.appointmentId', $appointmentId)
            ->get()
            ->getRowArray();
    }



    public function getHistoryAppointments($patientId)
    {
        return $this->db->table('appointment')
            ->select('appointment.appointmentId, user.name AS patientName, user.email AS patientEmail, patient.phoneNo as patientPhoneNum, treatment.name as treatmentName, treatment.price as treatmentPrice, appointment.status,slot.date,slot.startTime,slot.endTime')
            ->join('patient', 'patient.patientId = appointment.patientId')
            ->join('slot', 'slot.slotId = appointment.slotId')
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId')
            ->join('user', 'user.userId = patient.userId')
            ->where('appointment.patientId', $patientId)
            ->whereIn('appointment.status', ['approved', 'cancelled']) // Add condition for status
            ->get()
            ->getResultArray();
    }


    public function deleteAppointment($appointmentId)
    {
        return $this->db->table('appointment')
            ->where('appointmentId', $appointmentId)
            ->delete();
    }

    public function approveAppointment($appointmentId)
    {
        return $this->db->table('appointment')
            ->where('appointmentId', $appointmentId)
            ->update(['status' => 'approved']);
    }

    public function getAppointmentsByTherapist($therapistId)
    {
        return $this->db->table('appointment')
            ->select('
                appointment.appointmentId,
                slot.date,
                slot.time,
                appointment.status,
                user.name AS patientName,
                patient.phoneNo AS patientPhone,
                treatment.name AS treatmentName,
                treatment.price AS treatmentPrice
            ')
            ->join('patient', 'patient.patientId = appointment.patientId')
            ->join('user', 'user.userId = patient.userId')
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId')
            ->join('slot', 'slot.slotId = appointment.slotId')
            ->where('appointment.therapistId', $therapistId)
            ->get()
            ->getResultArray();
    }

    public function getTreatmentStats() //utk dptkan total appointment by treatment
    {
        return $this->db->table('appointment')
            ->select('treatment.name, COUNT(*) as total')
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId')
            ->where('appointment.status', 'approved') // Only approved appointments
            ->groupBy('treatment.name')
            ->get()
            ->getResultArray();
    }

    public function TotalAppointment()
    {
        return $this->db->table('appointment')
            ->select('COUNT(*) as total')
            ->where('status', 'approved') // Only approved appointments
            ->countAllResults();
    }

    public function getFilteredAppointments($filters)
    {
        $builder = $this->db->table('appointment')
            ->select('appointment.*, therapist_user.name AS therapist_name, patient_user.name AS patient_name, slot.date, slot.startTime, slot.endTime')
            ->join('therapist', 'therapist.therapistId = appointment.therapistId')
            ->join('user AS therapist_user', 'therapist_user.userId = therapist.userId') // Therapist name
            ->join('patient', 'patient.patientId = appointment.patientId')
            ->join('user AS patient_user', 'patient_user.userId = patient.userId') // Patient name
            ->join('slot', 'slot.slotId = appointment.slotId'); // Join with slot table

        if (!empty($filters['date'])) {
            $builder->where('slot.date', $filters['date']);
        }

        if (!empty($filters['therapist_id'])) {
            $builder->where('appointment.therapistId', $filters['therapist_id']);
        }

        if (!empty($filters['status'])) {
            $builder->where('appointment.status', $filters['status']);
        }

        // Order by latest appointment first
        $builder->orderBy('appointment.appointmentId', 'DESC');

        return $builder->get()->getResultArray();
    }
}
