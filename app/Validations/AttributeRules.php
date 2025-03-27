<?php

/**
 * Attribute Rules
 */

namespace App\Validations;

class AttributeRules
{
    public static function getRules()
    {
        return [
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Attribute name is required",
                ]
            ],
            'values' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Attribute values are required",
                ]
            ],
        ];
    }
}
