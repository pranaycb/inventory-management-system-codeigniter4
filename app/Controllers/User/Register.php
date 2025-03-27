<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Validations\UserRules;

class Register extends BaseController
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
     * Register view
     */
    public function index()
    {
        $data = [
            'title' => 'Registration'
        ];

        return view('user/auth/register', $data);
    }

    /**
     * Validate submit data
     */
    public function validateSubmitData()
    {
        /**
         * Validate form data
         */
        $this->validate(UserRules::getRules());

        if ($this->validation->run()) {

            $data = [
                'name' => getPostInput('name'),
                'email' => getPostInput('email'),
                'phone' => getPostInput('phone'),
                'address' => getPostInput('address'),
                'password' => password_hash(getPostInput('password'), PASSWORD_BCRYPT),
            ];

            $action = $this->user_model->insert($data, false);

            if ($action) {

                /**
                 * do log in
                 */
                setSession([
                    'user_id' => $this->user_model->getInsertID(),
                    'auth_token' => password_hash($this->user_model->getInsertID(), PASSWORD_BCRYPT),
                ]);

                return jsonResponse('success', [
                    "msg" => "Registration is successful. Redirecting to dashboard...",
                    "redirect" => route_to('route.users.dashboard')
                ], 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }
}
