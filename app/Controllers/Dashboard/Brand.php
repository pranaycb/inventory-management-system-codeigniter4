<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

use Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter4;

use App\Validations\BrandRules;

class Brand extends BaseController
{

    protected $brand_model;

    public function __construct()
    {
        /**
         * Brand model
         */
        $this->brand_model = model('App\Models\Brand');
    }

    /**
     * Brand page
     */
    public function index()
    {
        $data = [
            'title' => 'Brands',
        ];

        return view('dashboard/brands/all', $data);
    }

    /**
     * Fetch all brands
     */
    public function fetch()
    {

        $data = $this->brand_model->builder()->orderBy('id', 'DESC');

        $datatables = new DataTablesCodeIgniter4($data);

        $datatables->addSequenceNumber('serial');

        $datatables->addColumn('select', function ($row) {

            return '<input type="checkbox" class="form-check-input input-check-selected" value="' . $row->id . '">';
        });

        $datatables->format('created', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->format('updated', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->addColumn('action', function ($row) {

            return '
            <a class="btn btn-primary btn-sm rounded" href="' . route_to("route.brands.edit", $row->id) . '">
                <i class="far fa-edit"></i> Edit
            </a>';
        });

        $datatables->except(['id']);

        $datatables->asObject();

        $datatables->generate();
    }

    /**
     * New brand page
     */
    public function new()
    {
        $data = [
            'title' => 'New Brand',
        ];

        return view('dashboard/brands/new', $data);
    }

    /**
     * Create new brand
     */
    public function create()
    {

        $this->validate(BrandRules::getRules());

        if ($this->validation->run()) {

            $data = [
                'name' => getPostInput('name'),
            ];

            $action = $this->brand_model->insert($data, false);

            if ($action) {

                return jsonResponse('success', "New brand created successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Edit brand
     */
    public function edit($id)
    {
        $details = $this->brand_model->find($id);

        if (!empty($details)) {

            $data = [
                'title' => 'Update Brand',
                'details' => $details,
            ];

            return view('dashboard/brands/edit', $data);
        }

        return show404();
    }

    /**
     * Update brand
     */
    public function update($id)
    {
        /**
         * Validate form data
         */
        $this->validate(BrandRules::getRules());

        if ($this->validation->run()) {

            $data = [
                'name' => getPostInput('name'),
            ];

            $action = $this->brand_model->update($id, $data);

            if ($action) {

                return jsonResponse('success', "Brand updated successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Delete brands
     */
    public function delete()
    {
        $ids = getRawInput('ids');

        if (!empty($ids) && count($ids) > 0) {

            $result = $this->brand_model->whereIn('id', $ids)->delete();

            if ($result) {

                return jsonResponse("success", "Records deleted successfully", 200);
            }

            return jsonResponse("error", "Something went wrong!", 500);
        }

        return jsonResponse("error", "No data selected!", 400);
    }
}
