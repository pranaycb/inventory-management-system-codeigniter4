<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Validations\AuthRules;

class Login extends BaseController
{
    protected $admin_model;

    public function __construct()
    {
        /**
         * Admin model
         */
        $this->admin_model = model('App\Models\Admin');
    }

    /**
     * Login view
     */
    public function index()
    {
        $data = [
            'title' => 'Login'
        ];

        return view('dashboard/auth/login', $data);
    }

    /**
     * Validate submit data
     */
    public function validateSubmitData()
    {
        /**
         * Validate form data
         */
        $this->validate(AuthRules::loginRules());

        if ($this->validation->run()) {

            $email = getPostInput('email');

            $password = getPostInput('password');

            $admin = $this->admin_model->where(['email' => $email])->first();

            if (password_verify($password, $admin->password)) {

                /**
                 * do logged in
                 */
                setSession([
                    'admin_id' => $admin->id,
                    'auth_token' => password_hash($admin->id, PASSWORD_BCRYPT),
                ]);

                return jsonResponse('success', [
                    "msg" => "Login successful. Redirecting to dashboard...",
                    "redirect" => route_to('route.dashboard')
                ], 200);
            }

            return jsonResponse('validation-error', ['password' => 'Password is wrong'], 400);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }
}
