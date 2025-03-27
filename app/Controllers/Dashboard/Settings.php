<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

use App\Validations\SettingsRules;

class Settings extends BaseController
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
     * Setting page
     */
    public function index()
    {
        $data = [
            'title' => 'Settings',
            'admin' => $this->admin_model->find(getSession('admin_id')),
        ];

        return view('dashboard/settings', $data);
    }

    /**
     * Update app
     */
    public function updateApp()
    {
        /**
         * Validate form data
         */
        $this->validate(SettingsRules::getAppUpdateRules());

        if ($this->validation->run()) {

            $data = [
                'site_title'                => getPostInput('site_title'),
                'site_subtitle'             => getPostInput('site_subtitle'),
            ];

            foreach ($data as $key => $value) {

                setSetting($key, $value);
            }

            return jsonResponse('success', "Settings updated successfully", 200);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Update auth
     */
    public function updateAuth()
    {

        /**
         * Validate form data
         */
        $this->validate(SettingsRules::getAuthUpdateRules());

        if ($this->validation->run()) {

            $admin = $this->admin_model->find(getSession('admin_id'));

            $data = [
                'email' => getPostInput('email'),
            ];

            if (!empty(getPostInput('current_password'))) {

                if (!password_verify(getPostInput('current_password'), $admin->password)) {

                    return jsonResponse('validation-error', ['current_password' => 'Your current password is wrong'], 400);
                }

                $data['password'] = password_hash(getPostInput('new_password'), PASSWORD_ARGON2ID);
            }

            $result = $this->admin_model->update($admin->id, $data);

            if ($result) {

                return jsonResponse('succes', "Settings updated successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }
}
