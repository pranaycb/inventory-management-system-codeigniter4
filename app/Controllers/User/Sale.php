<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

use Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter4;

class Sale extends BaseController
{

    protected $sale_model, $product_model;

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
    }

    /**
     * Sale page
     */
    public function index()
    {
        $data = [
            'title' => 'Sales',
        ];

        return view('user/sales/all', $data);
    }

    /**
     * Fetch all sales
     */
    public function fetch()
    {

        $data = $this->sale_model->builder()
            ->where('user_id', getSession('user_id'))
            ->orderBy('id', 'DESC');

        $datatables = new DataTablesCodeIgniter4($data);

        $datatables->addSequenceNumber('serial');

        $datatables->addColumn('select', function ($row) {

            return '<input type="checkbox" class="form-check-input input-check-selected" value="' . $row->id . '">';
        });

        $datatables->format('sales_date', fn ($value) => date('d.m.Y', strtotime($value)));

        $datatables->addColumn('product', function ($row) {

            return $this->product_model->where(['id' => $row->product_id])->findColumn('name') ?? '--';
        });

        $datatables->addColumn('qty', fn ($row) => ($row->qty . ' ' . ucwords($row->sold_as)));

        $datatables->format('created', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->format('updated', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->except(['id']);

        $datatables->asObject();

        $datatables->generate();
    }
}
