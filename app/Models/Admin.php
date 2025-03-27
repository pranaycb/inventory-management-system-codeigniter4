<?php

namespace App\Models;

use CodeIgniter\Model;

class Admin extends Model
{
    protected $table            = 'admin';
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'email',
        'password',
        'created',
        'updated',
    ];
}
