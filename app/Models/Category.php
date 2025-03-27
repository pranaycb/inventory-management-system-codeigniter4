<?php

namespace App\Models;

use CodeIgniter\Model;

class Category extends Model
{
    protected $table            = 'categories';
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'created',
        'updated',
    ];
}
