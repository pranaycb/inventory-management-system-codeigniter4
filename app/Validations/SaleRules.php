<?php

/**
 * Sale Rules
 */

namespace App\Validations;

class SaleRules
{
    public static function getRules()
    {
        return [
            'user' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "User is required",
                ]
            ],
            'product' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Product is required",
                ]
            ],
            'sales_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Sales date is required",
                ]
            ],
            'qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Product quantity is required",
                ]
            ],
            'sold_as' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Sold type is required",
                ]
            ],
            'tax_rate' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Tax rate is required",
                ]
            ],
        ];
    }
}
