<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table = 'appointment';
    protected $primaryKey = 'appointmentId';
    protected $allowedFields = ['therapistId', 'patientId', 'slotId', 'status', 'treatmentId'];
    protected $returnType = 'array';

    public function getPendingAppointments($patientId)
    {
        return $this->db->table('appointment')
            ->select('user.name, user.email, therapist.therapistId, appointment.appointmentId, slot.date, slot.time, appointment.status, treatment.treatmentId, treatment.price')
            ->join('therapist', 'therapist.therapistId = appointment.therapistId')
            ->join('user', 'user.userId = therapist.userId')
            ->join('slot', 'slot.slotId = appointment.slotId') // Join with slot table
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId') // Join with treatment table
            ->where('appointment.patientId', $patientId)
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
            ->whereIn('appointment.status', ['pending', 'cancelled']) // Add condition for status
            ->get()
            ->getResultArray();
    }
    public function getHistoryAppointments()
    {
        return $this->db->table('appointment')
            ->select('appointment.appointmentId, user.name AS patientName, patient.phoneNo as patientPhoneNum, treatment.name as treatmentName, treatment.price as treatmentPrice, appointment.status,slot.date,slot.time')
            ->join('patient', 'patient.patientId = appointment.patientId')
            ->join('slot', 'slot.slotId = appointment.slotId')
            ->join('treatment', 'treatment.treatmentId = appointment.treatmentId')
            ->join('user', 'user.userId = patient.userId')
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
}
