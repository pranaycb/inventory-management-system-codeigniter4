<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

use Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter4;

use App\Validations\SaleRules;

class Sale extends BaseController
{

    protected $sale_model, $product_model, $user_model;

    public function __construct()
    {
        /**
         * Sale model
         */
        $this->sale_model = model('App\Models\Sale');

        /**
         * Product model
         */
        $this->product_model = model('App\Models\Product');

        /**
         * Uer model
         */
        $this->user_model = model('App\Models\User');
    }

    /**
     * Sale page
     */
    public function index()
    {
        $data = [
            'title' => 'Sales',
        ];

        return view('dashboard/sales/all', $data);
    }

    /**
     * Fetch all sales
     */
    public function fetch()
    {

        $data = $this->sale_model->builder()->orderBy('id', 'DESC');

        $datatables = new DataTablesCodeIgniter4($data);

        $datatables->addSequenceNumber('serial');

        $datatables->addColumn('select', function ($row) {

            return '<input type="checkbox" class="form-check-input input-check-selected" value="' . $row->id . '">';
        });

        $datatables->format('sales_date', fn ($value) => date('d.m.Y', strtotime($value)));

        $datatables->addColumn('product', function ($row) {

            return $this->product_model->where(['id' => $row->product_id])->findColumn('name') ?? '--';
        });

        $datatables->addColumn('user', function ($row) {

            return $this->user_model->where(['id' => $row->user_id])->findColumn('name') ?? '--';
        });

        $datatables->addColumn('qty', fn ($row) => ($row->qty . ' ' . ucwords($row->sold_as)));

        $datatables->format('created', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->format('updated', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->addColumn('action', function ($row) {

            return '
            <a class="btn btn-primary btn-sm rounded" href="' . route_to("route.sales.edit", $row->id) . '">
                <i class="far fa-edit"></i> Edit
            </a>';
        });

        $datatables->except(['id']);

        $datatables->asObject();

        $datatables->generate();
    }

    /**
     * New sale page
     */
    public function new()
    {
        $data = [
            'title' => 'New Sale',
            'products' => $this->product_model->findAll(),
            'users' => $this->user_model->findAll(),
        ];

        return view('dashboard/sales/new', $data);
    }

    /**
     * Create new sale
     */
    public function create()
    {

        $this->validate(SaleRules::getRules());

        if ($this->validation->run()) {

            $data = [
                'user_id'       => getPostInput('user'),
                'product_id'    => getPostInput('product'),
                'qty'           => getPostInput('qty'),
                'sold_as'       => getPostInput('sold_as'),
                'tax_rate'      => getPostInput('tax_rate'),
                'order_id'      => random_string('num', 10),
                'sales_date'    => date('Y.m.d', strtotime(getPostInput('sales_date'))),
            ];

            $product = $this->product_model->find($data['product_id']);

            $data['price'] = !empty(getPostInput('price')) ?  getPostInput('price') : $product->price;

            $sold = (int) $this->sale_model->selectSum('qty')
                ->where(['product_id' => $data['product_id']])
                ->first()->qty ?? 0;

            $remain = $product->qty ?? 0 - $sold;

            if ($data['qty'] > $remain) {

                return jsonResponse('error', "Not enough item in stock", 400);
            }

            $total = $data['price'] * $data['qty'];

            $data['total'] = $total + $total * ($data['tax_rate'] / 100);

            $action = $this->sale_model->insert($data, false);

            if ($action) {

                return jsonResponse('success', "New sale record created successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Edit sale
     */
    public function edit($id)
    {
        $details = $this->sale_model->find($id);

        if (!empty($details)) {

            $data = [
                'title' => 'Update Sale',
                'details' => $details,
                'products' => $this->product_model->findAll(),
                'users' => $this->user_model->findAll(),
            ];

            return view('dashboard/sales/edit', $data);
        }

        return show404();
    }

    /**
     * Update sale
     */
    public function update($id)
    {
        $this->validate(SaleRules::getRules());

        if ($this->validation->run()) {

            $data = [
                'user_id'       => getPostInput('user'),
                'product_id'    => getPostInput('product'),
                'qty'           => getPostInput('qty'),
                'sold_as'       => getPostInput('sold_as'),
                'tax_rate'      => getPostInput('tax_rate'),
                'order_id'      => random_string('num', 10),
                'sales_date'    => date('Y.m.d', strtotime(getPostInput('sales_date'))),
            ];

            $product = $this->product_model->find($data['product_id']);

            $data['price'] = !empty(getPostInput('price')) ?  getPostInput('price') : $product->price;

            $sold = (int) $this->sale_model->selectSum('qty')
                ->where(['id != ' => $id, 'product_id' => $data['product_id']])
                ->first()->qty ?? 0;

            $remain = $product->qty - $sold;

            if ($data['qty'] > $remain) {

                return jsonResponse('error', "Not enough item in stock", 400);
            }

            $total = $data['price'] * $data['qty'];

            $data['total'] = $total + $total * ($data['tax_rate'] / 100);

            $action = $this->sale_model->update($id, $data);

            if ($action) {

                return jsonResponse('success', "Sale record updated successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Delete sales
     */
    public function delete()
    {
        $ids = getRawInput('ids');

        if (!empty($ids) && count($ids) > 0) {

            $result = $this->sale_model->whereIn('id', $ids)->delete();

            if ($result) {

                return jsonResponse("success", "Records deleted successfully", 200);
            }

            return jsonResponse("error", "Something went wrong!", 500);
        }

        return jsonResponse("error", "No data selected!", 400);
    }
}
