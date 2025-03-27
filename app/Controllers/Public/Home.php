<?php

namespace App\Controllers\Public;

use App\Controllers\BaseController;

class Home extends BaseController
{
    protected $product_model, $brand_model, $category_model, $sale_model;

    public function __construct()
    {
        /**
         * Product model
         */
        $this->product_model = model('App\Models\Product');

        /**
         * Brand model
         */
        $this->brand_model = model('App\Models\Brand');

        /**
         * Category model
         */
        $this->category_model = model('App\Models\Category');

        /**
         * Sale model
         */
        $this->sale_model = model('App\Models\Sale');
    }

    public function index()
    {
        $data = [
            'title' => 'Admiun Dashboard',
            'products' => $this->product_model
                ->select('products.*, brands.name as brand, categories.name as category, SUM(sales.qty) as sold')
                ->join('brands', 'brands.id = products.brand_id', 'LEFT')
                ->join('categories', 'categories.id = products.category_id', 'LEFT')
                ->join('sales', 'sales.product_id = products.id', 'LEFT')
                ->groupBy('products.id')
                ->orderBy('products.id', 'desc')
                ->findAll(),
        ];

        return view('public/home', $data);
    }

    /**
     * Generate chart data
     */
    private function generateChartData()
    {
        $data = [
            'xdata' => [],
            'ydata' => [],
        ];

        $totalDays = cal_days_in_month(0, date('m'), date('Y'));

        for ($i = 1; $i <= $totalDays; $i++) {

            $data['xdata'][] .= $i . date('M');

            $data['ydata'][] .= 0;
        }

        $sales = $this->sale_model
            ->select('sales_date, tax_rate, (price * qty) as total_products')
            ->where("MONTH(sales_date) = MONTH(CURDATE())")
            ->where("YEAR(sales_date) = YEAR(CURDATE())")
            ->findAll();

        foreach ($sales as $sale) {

            $d = (int) date('d', strtotime($sale->sales_date));

            if (array_key_exists($d, $data['xdata'])) {

                $sp = $sale->total_products + $sale->total_products * ($sale->tax_rate / 100);

                $data['ydata'][$d] += $sp;
            }
        }


        return [
            'xdata' => json_encode($data['xdata']),
            'ydata' => json_encode($data['ydata']),
        ];
    }
}
