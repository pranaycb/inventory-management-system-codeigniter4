<?php

namespace App\Models;

use CodeIgniter\Model;

class Sale extends Model
{
    protected $table            = 'sales';
    protected $returnType       = 'object';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'product_id',
        'price',
        'qty',
        'sold_as',
        'tax_rate',
        'total',
        'order_id',
        'sales_date',
        'created',
        'updated',
    ];
}
