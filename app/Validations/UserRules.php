<?php

/**
 * User Rules
 */

namespace App\Validations;

class UserRules
{
    public static function getRules($id = null, $hasPassword = true)
    {
        $rules =  [
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "User name is required",
                ]
            ],
            'email' => [
                'rules' => 'required|is_unique[users.email, id, ' . $id . ']',
                'errors' => [
                    'required' => "User email is required",
                    'is_unique' => "User email already exists",
                ]
            ],
            'phone' => [
                'rules' => 'required|is_unique[users.phone, id, ' . $id . ']',
                'errors' => [
                    'required' => "User phone is required",
                    'is_unique' => "User phone already exists",
                ]
            ],
            'address' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "User address is required",
                ]
            ],
        ];

        if ($hasPassword) {

            $rules = array_merge($rules, self::getPasswordRules());
        }

        return $rules;
    }

    public static function getPasswordRules()
    {
        return [
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "User password is required",
                ]
            ],
        ];
    }
}
