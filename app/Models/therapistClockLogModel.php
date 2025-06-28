<?php

namespace App\Models;

use CodeIgniter\Model;

class TherapistClockLogModel extends Model
{
    // Define the table name
    protected $table = 'therapist_clock_log';

    // Define the primary key
    protected $primaryKey = 'clockLogId';

    // Define the allowed fields for the model (columns in the table)
    protected $allowedFields = ['therapistId', 'clock_in', 'clock_out'];

    // Automatically manage timestamps (created_at, updated_at)
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Define the method to insert a clock-in record
    public function clockIn($therapistId)
    {
        $data = [
            'therapistId' => $therapistId,
            'clock_in' => date('Y-m-d H:i:s'),  // Set current timestamp for clock-in
        ];

        // Insert the data and return the result
        return $this->insert($data);
    }

    // Define the method to update the clock-out record
    public function clockOut($therapistId)
    {
        // Get the last clock-in record for this therapist where clock_out is null (still clocked in)
        $lastClockIn = $this->where('therapistId', $therapistId)
            ->where('clock_out', null)
            ->first();

        if (!$lastClockIn) {
            return false;  // No clock-in found (cannot clock out)
        }

        // Update the clock-out time
        $data = [
            'clock_out' => date('Y-m-d H:i:s'),  // Set current timestamp for clock-out
        ];

        // Update the record
        return $this->update($lastClockIn['clockLogId'], $data);
    }

    // Define the method to get the most recent clock-in status (clocked in or clocked out)
    public function getClockStatus($therapistId)
    {
        // Get the most recent clock-in record for this therapist
        $status = $this->where('therapistId', $therapistId)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($status && !$status['clock_out']) {
            return 'Clocked In'; // Therapist is still clocked in
        }

        return 'Clocked Out'; // Therapist is clocked out or never clocked in
    }
}
