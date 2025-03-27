<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

use Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter4;

use App\Validations\UserRules;

class User extends BaseController
{

    protected $user_model;

    public function __construct()
    {
        /**
         * Brand model
         */
        $this->user_model = model('App\Models\User');
    }

    /**
     * Brand page
     */
    public function index()
    {
        $data = [
            'title' => 'Users',
        ];

        return view('dashboard/users/all', $data);
    }

    /**
     * Fetch all users
     */
    public function fetch()
    {

        $data = $this->user_model->builder()->orderBy('id', 'DESC');

        $datatables = new DataTablesCodeIgniter4($data);

        $datatables->addSequenceNumber('serial');

        $datatables->addColumn('select', function ($row) {

            return '<input type="checkbox" class="form-check-input input-check-selected" value="' . $row->id . '">';
        });

        $datatables->addColumn('action', function ($row) {

            return '
            <a class="btn btn-primary btn-sm rounded" href="' . route_to("route.users.edit", $row->id) . '">
                <i class="far fa-edit"></i> Edit
            </a>';
        });

        $datatables->except(['id']);

        $datatables->asObject();

        $datatables->generate();
    }

    /**
     * New user page
     */
    public function new()
    {
        $data = [
            'title' => 'New User',
        ];

        return view('dashboard/users/new', $data);
    }

    /**
     * Create new user
     */
    public function create()
    {

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

                return jsonResponse('success', "New user created successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Edit user
     */
    public function edit($id)
    {
        $details = $this->user_model->find($id);

        if (!empty($details)) {

            $data = [
                'title' => 'Update User',
                'details' => $details,
            ];

            return view('dashboard/users/edit', $data);
        }

        return show404();
    }

    /**
     * Update user profile
     */
    public function updateProfile($id)
    {
        /**
         * Validate form data
         */
        $this->validate(UserRules::getRules($id, false));

        if ($this->validation->run()) {

            $data = [
                'name' => getPostInput('name'),
                'email' => getPostInput('email'),
                'phone' => getPostInput('phone'),
                'address' => getPostInput('address'),
            ];

            $action = $this->user_model->update($id, $data);

            if ($action) {

                return jsonResponse('success', "User updated successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Update user
     */
    public function updatePassword($id)
    {
        /**
         * Validate form data
         */
        $this->validate(UserRules::getPasswordRules());

        if ($this->validation->run()) {

            $data = [
                'password' => password_hash(getPostInput('password'), PASSWORD_BCRYPT),
            ];

            $action = $this->user_model->update($id, $data);

            if ($action) {

                return jsonResponse('success', "Password updated successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Delete user
     */
    public function delete()
    {
        $ids = getRawInput('ids');

        if (!empty($ids) && count($ids) > 0) {

            $result = $this->user_model->whereIn('id', $ids)->delete();

            if ($result) {

                return jsonResponse("success", "Records deleted successfully", 200);
            }

            return jsonResponse("error", "Something went wrong!", 500);
        }

        return jsonResponse("error", "No data selected!", 400);
    }
}
