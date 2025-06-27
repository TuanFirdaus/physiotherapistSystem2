<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table = 'schedule';
    protected $primaryKey = 'scheduleId';
    protected $allowedFields = ['slotId', 'therapistId', 'patientId', 'appointmentId'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Fetch schedule for a specific month and year, including therapist and patient details
    public function getScheduleByDate($month, $year)
    {
        return $this->join('slot', 'slot.slotId = schedule.slotId')
            ->join('therapist', 'therapist.therapistId = schedule.therapistId')  // Join therapist
            ->join('patient', 'patient.patientId = schedule.patientId')  // Join patient
            ->where('MONTH(slot.date)', $month)
            ->where('YEAR(slot.date)', $year)
            ->findAll();
    }

    // Fetch schedule by specific day, including therapist and patient details
    public function getScheduleByDay($day, $month, $year)
    {
        return $this->join('slot', 'slot.slotId = schedule.slotId')
            ->join('therapist', 'therapist.therapistId = schedule.therapistId')  // Join therapist
            ->join('patient', 'patient.patientId = schedule.patientId')  // Join patient
            ->where('DAY(slot.date)', $day)
            ->where('MONTH(slot.date)', $month)
            ->where('YEAR(slot.date)', $year)
            ->findAll();
    }

    // Get event details, including therapist, patient, and user details
    public function getScheduleWithSlot($scheduleId)
    {
        return $this->join('slot', 'slot.slotId = schedule.slotId')
            ->join('therapist', 'therapist.therapistId = schedule.therapistId')
            ->join('patient', 'patient.patientId = schedule.patientId')
            ->where('scheduleId', $scheduleId)
            ->first();
    }
}
