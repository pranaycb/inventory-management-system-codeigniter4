<?php

namespace App\Models;

use CodeIgniter\Model;

class Attribute extends Model
{
    protected $table            = 'attributes';
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'values',
        'created',
        'updated',
    ];
}
