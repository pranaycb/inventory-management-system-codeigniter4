<?php

/**
 * Authentication rules
 */

namespace App\Validations;

class AuthRules
{

    /**
     * Login rules
     */
    public static function loginRules($table = 'admin'): array
    {
        return [
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[' . $table . '.email]',
                'errors' => [
                    'required' => 'Email id is required',
                    'valid_email' => 'Invalid email id',
                    'is_not_unique' => 'Email id is wrong'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password is required',
                ]
            ],
        ];
    }

    /**
     * Forgot password rules
     */
    public static function forgotPasswordRules($table = 'admin'): array
    {
        return [
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[' . $table . '.email]',
                'errors' => [
                    'required' => 'Email id is required',
                    'valid_email' => 'Invalid email id',
                    'is_not_unique' => 'Email id is wrong'
                ]
            ],
        ];
    }
}
