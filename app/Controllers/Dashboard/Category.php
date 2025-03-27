<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

use Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter4;

use App\Validations\CategoryRules;

class Category extends BaseController
{

    protected $category_model;

    public function __construct()
    {
        /**
         * Category model
         */
        $this->category_model = model('App\Models\Category');
    }

    /**
     * Category page
     */
    public function index()
    {
        $data = [
            'title' => 'Categories',
        ];

        return view('dashboard/categories/all', $data);
    }

    /**
     * Fetch all categories
     */
    public function fetch()
    {

        $data = $this->category_model->builder()->orderBy('id', 'DESC');

        $datatables = new DataTablesCodeIgniter4($data);

        $datatables->addSequenceNumber('serial');

        $datatables->addColumn('select', function ($row) {

            return '<input type="checkbox" class="form-check-input input-check-selected" value="' . $row->id . '">';
        });

        $datatables->format('created', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->format('updated', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->addColumn('action', function ($row) {

            return '
            <a class="btn btn-primary btn-sm rounded" href="' . route_to("route.categories.edit", $row->id) . '">
                <i class="far fa-edit"></i> Edit
            </a>';
        });

        $datatables->except(['id']);

        $datatables->asObject();

        $datatables->generate();
    }

    /**
     * New category page
     */
    public function new()
    {
        $data = [
            'title' => 'New Category',
        ];

        return view('dashboard/categories/new', $data);
    }

    /**
     * Create new category
     */
    public function create()
    {

        $this->validate(CategoryRules::getRules());

        if ($this->validation->run()) {

            $data = [
                'name' => getPostInput('name'),
            ];

            $action = $this->category_model->insert($data, false);

            if ($action) {

                return jsonResponse('success', "New category created successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Edit category
     */
    public function edit($id)
    {
        $details = $this->category_model->find($id);

        if (!empty($details)) {

            $data = [
                'title' => 'Update Category',
                'details' => $details,
            ];

            return view('dashboard/categories/edit', $data);
        }

        return show404();
    }

    /**
     * Update category
     */
    public function update($id)
    {
        /**
         * Validate form data
         */
        $this->validate(CategoryRules::getRules());

        if ($this->validation->run()) {

            $data = [
                'name' => getPostInput('name'),
            ];

            $action = $this->category_model->update($id, $data);

            if ($action) {

                return jsonResponse('success', "Category updated successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Delete categories
     */
    public function delete()
    {
        $ids = getRawInput('ids');

        if (!empty($ids) && count($ids) > 0) {

            $result = $this->category_model->whereIn('id', $ids)->delete();

            if ($result) {

                return jsonResponse("success", "Records deleted successfully", 200);
            }

            return jsonResponse("error", "Something went wrong!", 500);
        }

        return jsonResponse("error", "No data selected!", 400);
    }
}
