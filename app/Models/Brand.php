<?php

namespace App\Models;

use CodeIgniter\Model;

class Brand extends Model
{
    protected $table            = 'brands';
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'created',
        'updated',
    ];
}
