<?php

namespace App\Models;

use CodeIgniter\Model;

class treatmentPackage extends Model
{
    protected $table = 'treatment';
    protected $primaryKey = 'treatmentId';
    protected $allowedFields = [
        'treatmentId',
        'name',
        'details',
        'price',
    ];
}
