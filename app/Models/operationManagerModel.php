<?php

namespace App\Models;

use CodeIgniter\Model;

class operationManagerModel extends Model
{
    protected $table = 'operationmanager';
    protected $primaryKey = 'omId';
    protected $allowedFields = ['userId', 'profile_image', 'outlet', 'address', 'phoneNo'];
}
