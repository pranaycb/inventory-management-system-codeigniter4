<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

use Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter4;

use App\Validations\AttributeRules;

class Attribute extends BaseController
{

    protected $attr_model;

    public function __construct()
    {
        /**
         * Attribute model
         */
        $this->attr_model = model('App\Models\Attribute');
    }

    /**
     * Attribute page
     */
    public function index()
    {
        $data = [
            'title' => 'Attributes',
        ];

        return view('dashboard/attributes/all', $data);
    }

    /**
     * Fetch all attributes
     */
    public function fetch()
    {

        $data = $this->attr_model->builder()->orderBy('id', 'DESC');

        $datatables = new DataTablesCodeIgniter4($data);

        $datatables->addSequenceNumber('serial');

        $datatables->addColumn('select', function ($row) {

            return '<input type="checkbox" class="form-check-input input-check-selected" value="' . $row->id . '">';
        });

        $datatables->format('values', fn ($values) => implode(' . ', explode(',', $values)));

        $datatables->format('created', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->format('updated', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->addColumn('action', function ($row) {

            return '
            <a class="btn btn-primary btn-sm rounded" href="' . route_to("route.attributes.edit", $row->id) . '">
                <i class="far fa-edit"></i> Edit
            </a>';
        });

        $datatables->except(['id']);

        $datatables->asObject();

        $datatables->generate();
    }

    /**
     * New attribute page
     */
    public function new()
    {
        $data = [
            'title' => 'New Attribute',
        ];

        return view('dashboard/attributes/new', $data);
    }

    /**
     * Create new attribute
     */
    public function create()
    {

        $this->validate(AttributeRules::getRules());

        if ($this->validation->run()) {

            $data = [
                'name' => getPostInput('name'),
                'values' => getPostInput('values'),
            ];

            $action = $this->attr_model->insert($data, false);

            if ($action) {

                return jsonResponse('success', "New attribute created successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Edit attribute
     */
    public function edit($id)
    {
        $details = $this->attr_model->find($id);

        if (!empty($details)) {

            $data = [
                'title' => 'Update Attribute',
                'details' => $details,
            ];

            return view('dashboard/attributes/edit', $data);
        }

        return show404();
    }

    /**
     * Update attribute
     */
    public function update($id)
    {
        /**
         * Validate form data
         */
        $this->validate(AttributeRules::getRules());

        if ($this->validation->run()) {

            $data = [
                'name' => getPostInput('name'),
                'values' => getPostInput('values'),
            ];

            $action = $this->attr_model->update($id, $data);

            if ($action) {

                return jsonResponse('success', "Attribute updated successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Delete attributes
     */
    public function delete()
    {
        $ids = getRawInput('ids');

        if (!empty($ids) && count($ids) > 0) {

            $result = $this->attr_model->whereIn('id', $ids)->delete();

            if ($result) {

                return jsonResponse("success", "Records deleted successfully", 200);
            }

            return jsonResponse("error", "Something went wrong!", 500);
        }

        return jsonResponse("error", "No data selected!", 400);
    }
}
