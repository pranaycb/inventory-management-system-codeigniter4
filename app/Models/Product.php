<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
    protected $table            = 'products';
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id',
        'brand_id',
        'attributes',
        'name',
        'description',
        'qty',
        'price',
        'image',
        'created',
        'updated',
    ];
}
