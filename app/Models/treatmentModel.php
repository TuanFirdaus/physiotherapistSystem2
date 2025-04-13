<?php

namespace App\Models;

use CodeIgniter\Model;

class treatmentModel extends Model
{
    protected $table = 'treatment'; // Name of the table
    protected $primaryKey = 'treatmentId'; // Primary key of the table
    protected $allowedFields = ['treatmentId', 'name', 'details', 'price']; // Columns allowed for mass assignment



}
