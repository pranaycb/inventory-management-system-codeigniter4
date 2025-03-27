<?php

/**
 * Category Rules
 */

namespace App\Validations;

class CategoryRules
{
    public static function getRules()
    {
        return [
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Category name is required",
                ]
            ],
        ];
    }
}
