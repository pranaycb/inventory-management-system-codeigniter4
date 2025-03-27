<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Validations\AuthRules;

class Login extends BaseController
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
     * Login view
     */
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('user/auth/login', $data);
    }

    /**
     * Validate submit data
     */
    public function validateSubmitData()
    {
        /**
         * Validate form data
         */
        $this->validate(AuthRules::loginRules('users'));

        if ($this->validation->run()) {

            $email = getPostInput('email');

            $password = getPostInput('password');

            $user = $this->user_model->where(['email' => $email])->first();

            if (password_verify($password, $user->password)) {

                /**
                 * do logged in
                 */
                setSession([
                    'user_id' => $user->id,
                    'auth_token' => password_hash($user->id, PASSWORD_BCRYPT),
                ]);

                return jsonResponse('success', [
                    "msg" => "Login successful. Redirecting to dashboard...",
                    "redirect" => route_to('route.users.dashboard')
                ], 200);
            }

            return jsonResponse('validation-error', ['password' => 'Password is wrong'], 400);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }
}
