<?php

namespace App\Models;

use CodeIgniter\Model;

class manageAppointment extends Model
{
    protected $table = 'treatment'; // Name of the table
    protected $primaryKey = 'treatmentId'; // Primary key
    protected $allowedFields = ['treatmentId', 'name', 'details', 'price']; // Columns allowed for mass assignment

    public function getTreatment()
    {
        return $this->db->table('treatment')
            ->select('treatmentId, name, details, price')
            ->get()
            ->getResultArray();
    }
}
