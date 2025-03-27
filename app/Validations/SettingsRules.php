<?php

/**
 * Settings Rules
 */

namespace App\Validations;

class SettingsRules
{
    /**
     * General settings rules
     */
    public static function getAppUpdateRules()
    {
        return [
            'site_title' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Site title is required",
                ]
            ],
            'site_subtitle' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Site subtitle is required",
                ]
            ],
        ];
    }

    /**
     * General settings rules
     */
    public static function getAuthUpdateRules()
    {
        return [
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Login email is required',
                ]
            ],
            'current_password' => [
                'rules' => 'required_with[new_password,retyped_new_password]',
                'errors' => [
                    'required_with' => 'CXurrent password is required',
                ]
            ],
            'new_password' => [
                'rules' => 'required_with[current_password]',
                'errors' => [
                    'required_with' => 'New password is required',
                ]
            ],
            'retyped_new_password' => [
                'rules' => 'required_with[current_password,new_password]|matches[new_password]',
                'errors' => [
                    'required_with' => 'Rewrite new password is required',
                    'matches'  => 'Passwords doesn\'t matched'
                ]
            ],
        ];
    }
}
