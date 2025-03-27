<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

use App\Validations\UserRules;

class Account extends BaseController
{

    protected $user_model;

    public function __construct()
    {
        /**
         * User model
         */
        $this->user_model = model('App\Models\User');
    }

    /**
     * Account page
     */
    public function index()
    {
        $data = [
            'title' => 'Users',
            'details' => $this->user_model->find(getSession('user_id')),
        ];

        return view('user/account', $data);
    }

    /**
     * Update profile
     */
    public function updateProfile()
    {
        /**
         * Validate form data
         */
        $this->validate(UserRules::getRules(getSession('user_id'), false));

        if ($this->validation->run()) {

            $data = [
                'name' => getPostInput('name'),
                'email' => getPostInput('email'),
                'phone' => getPostInput('phone'),
                'address' => getPostInput('address'),
            ];

            $action = $this->user_model->update(getSession('user_id'), $data);

            if ($action) {

                return jsonResponse('success', "Account successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Update password
     */
    public function updatePassword()
    {
        /**
         * Validate form data
         */
        $this->validate(UserRules::getPasswordRules());

        if ($this->validation->run()) {

            $data = [
                'password' => password_hash(getPostInput('password'), PASSWORD_BCRYPT),
            ];

            $action = $this->user_model->update(getSession('user_id'), $data);

            if ($action) {

                return jsonResponse('success', "Password updated successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }
}
