<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected $product_model, $brand_model, $category_model, $sale_model;

    public function __construct()
    {
        /**
         * Sale model
         */
        $this->sale_model = model('App\Models\Sale');
    }

    public function index()
    {
        $data = [
            'title' => 'User Dashboard',
            'sales' => $this->sale_model
                ->select('sales.*, products.name as product, SUM(sales.qty) as sold')
                ->join('products', 'products.id = sales.product_id', 'LEFT')
                ->where('sales.user_id', getSession('user_id'))
                ->groupBy('sales.id')
                ->orderBy('sales.id', 'desc')
                ->findAll(),

            'chart' => $this->generateChartData(),
        ];

        return view('user/dashboard', $data);
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
            ->where('user_id', getSession('user_id'))
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
