<?php

/**
 * Brand Rules
 */

namespace App\Validations;

class BrandRules
{
    public static function getRules()
    {
        return [
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Brand name is required",
                ]
            ],
        ];
    }
}
