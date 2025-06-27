<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table = 'schedule';  // Ensure you're using the correct table name ('events' or 'schedule')
    protected $primaryKey = 'scheduleId';
    protected $allowedFields = ['slotId', 'therapistId', 'patientId', 'userId'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Fetch events for a specific month and year, including therapist and patient details
    public function getScheduleByDate($month, $year)
    {
        return $this->join('slot', 'slot.slotId = events.slotId')
            ->join('therapist', 'therapist.therapistId = events.therapistId')  // Join therapist
            ->join('patient', 'patient.patientId = events.patientId')  // Join patient
            ->join('user', 'user.userId = events.userId')  // Join user (for patient or therapist)
            ->where('MONTH(slot.date)', $month)
            ->where('YEAR(slot.date)', $year)
            ->findAll();
    }

    // Fetch events by specific day, including therapist and patient details
    public function getScheduleByDay($day, $month, $year)
    {
        return $this->join('slot', 'slot.slotId = events.slotId')
            ->join('therapist', 'therapist.therapistId = events.therapistId')  // Join therapist
            ->join('patient', 'patient.patientId = events.patientId')  // Join patient
            ->join('user', 'user.userId = events.userId')  // Join user (for patient or therapist)
            ->where('DAY(slot.date)', $day)
            ->where('MONTH(slot.date)', $month)
            ->where('YEAR(slot.date)', $year)
            ->findAll();
    }

    // Get event details, including therapist, patient, and user details
    public function getScheduleWithSlot($scheduleId)
    {
        return $this->join('slot', 'slot.slotId = events.slotId')
            ->join('therapist', 'therapist.therapistId = events.therapistId')
            ->join('patient', 'patient.patientId = events.patientId')
            ->join('user', 'user.userId = events.userId')
            ->where('event_id', $scheduleId)
            ->first();
    }
}
