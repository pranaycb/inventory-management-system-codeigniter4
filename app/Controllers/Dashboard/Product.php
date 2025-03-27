<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

use Ngekoding\CodeIgniterDataTables\DataTablesCodeIgniter4;

use App\Validations\ProductRules;

class Product extends BaseController
{

    protected $product_model, $attr_model, $brand_model, $category_model, $sale_model;

    public function __construct()
    {
        /**
         * Product model
         */
        $this->product_model = model('App\Models\Product');

        /**
         * Attribute model
         */
        $this->attr_model = model('App\Models\Attribute');

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

    /**
     * Product page
     */
    public function index()
    {
        $data = [
            'title' => 'Products',
        ];

        return view('dashboard/products/all', $data);
    }

    /**
     * Fetch all products
     */
    public function fetch()
    {

        $data = $this->product_model->builder()->orderBy('id', 'DESC');

        $datatables = new DataTablesCodeIgniter4($data);

        $datatables->addSequenceNumber('serial');

        $datatables->addColumn('select', function ($row) {

            return '<input type="checkbox" class="form-check-input input-check-selected" value="' . $row->id . '">';
        });

        $datatables->format('image', function ($value) {

            return '<img src="' . base_url('assets/img/products/' . $value) . '" class="img-thumbnail"/>';
        });

        $datatables->addColumn('category', function ($row) {

            return $this->category_model->where(['id' => $row->category_id])->findColumn('name') ?? '--';
        });

        $datatables->addColumn('brand', function ($row) {

            return $this->brand_model->where(['id' => $row->brand_id])->findColumn('name') ?? '--';
        });

        $datatables->addColumn('sold', function ($row) {

            return $this->sale_model->selectSum('qty')->where(['product_id' => $row->id])->first()->qty ?? 0;
        });

        $datatables->format('attributes', fn ($values) => implode(' . ', explode(',', $values)));

        $datatables->format('price', function ($value) {

            return number_format($value) . '৳';
        });

        $datatables->addColumn('status', function ($row) {

            $sold = (int) $this->sale_model->selectSum('qty')->where(['product_id' => $row->id])->first()->qty ?? 0;

            if ((int)$row->qty <= $sold) {

                return '<span class="badge bg-danger">Out of Stock</span>';
            }

            return '<span class="badge bg-success">In Stock</span>';
        });

        $datatables->format('created', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->format('updated', fn ($value) => date('d.m.Y h:i A', strtotime($value)));

        $datatables->addColumn('action', function ($row) {

            return '
            <a class="btn btn-primary btn-sm rounded" href="' . route_to("route.products.edit", $row->id) . '">
                <i class="far fa-edit"></i> Edit
            </a>';
        });

        $datatables->except(['id']);

        $datatables->asObject();

        $datatables->generate();
    }

    /**
     * New product page
     */
    public function new()
    {
        $data = [
            'title' => 'New Product',
            'categories' => $this->category_model->findAll(),
            'brands' => $this->brand_model->findAll(),
            'attributes' => $this->attr_model->findAll(),
        ];

        return view('dashboard/products/new', $data);
    }

    /**
     * Create new product
     */
    public function create()
    {

        $this->validate(ProductRules::getRules());

        if ($this->validation->run()) {

            $image = getFileInput('image');

            $productImage = $image->getRandomName();

            $image = \Config\Services::image()
                ->withFile($image)
                ->save('assets/img/products/' . $productImage);

            if ($image) {

                $data = [
                    'category_id' => getPostInput('category'),
                    'brand_id' => getPostInput('brand'),
                    'attributes' => implode(",", getPostInput('attribute')),
                    'name' => getPostInput('name'),
                    'description' => getPostInput('description'),
                    'qty' => getPostInput('qty'),
                    'price' => getPostInput('price'),
                    'image' => $productImage,
                ];

                $action = $this->product_model->insert($data, false);

                if ($action) {

                    return jsonResponse('success', "New product created successfully", 200);
                }

                return jsonResponse('error', "Something went wrong! Please try again", 500);
            }

            return jsonResponse('error', 'Having trouble uploading the image. Please try again', 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Edit products
     */
    public function edit($id)
    {
        $details = $this->product_model->find($id);

        if (!empty($details)) {

            $data = [
                'title' => 'Update Product',
                'details' => $details,
                'categories' => $this->category_model->findAll(),
                'brands' => $this->brand_model->findAll(),
                'attributes' => $this->attr_model->findAll(),
            ];

            return view('dashboard/products/edit', $data);
        }

        return show404();
    }

    /**
     * Update product
     */
    public function update($id)
    {
        /**
         * Check if image is selected
         */
        $hasImage = !empty(getFileInput('image')->getName());

        $this->validate(ProductRules::getRules($hasImage));

        if ($this->validation->run()) {

            $details = $this->product_model->find($id);

            $productImage = $details->image;

            /**
             * Upload image if selected
             */
            if (!empty($hasImage)) {

                $image = getFileInput('image');

                $productImage = $image->getRandomName();

                $image = \Config\Services::image()
                    ->withFile($image)
                    ->save('assets/img/products/' . $productImage);

                if (!$image) {

                    return jsonResponse('error', 'Having trouble uploading the image. Please try again', 500);
                }

                /**
                 * remove previously uploaded image
                 */
                if (!empty($details->photo)) {

                    $currentImage = 'assets/img/products/' . $details->photo;

                    if (file_exists($currentImage)) {

                        unlink($currentImage);
                    }
                }
            }

            $data = [
                'category_id' => getPostInput('category'),
                'brand_id' => getPostInput('brand'),
                'attributes' => implode(",", getPostInput('attribute')),
                'name' => getPostInput('name'),
                'description' => getPostInput('description'),
                'qty' => getPostInput('qty'),
                'price' => getPostInput('price'),
                'image' => $productImage,
            ];

            $action = $this->product_model->update($id, $data);

            if ($action) {

                return jsonResponse('success', "Product updated successfully", 200);
            }

            return jsonResponse('error', "Something went wrong! Please try again", 500);
        }

        return jsonResponse('validation-error', $this->validation->getErrors(), 400);
    }

    /**
     * Delete products
     */
    public function delete()
    {
        $ids = getRawInput('ids');

        if (!empty($ids) && count($ids) > 0) {

            for ($i = 0; $i < count($ids); $i++) {

                $client = $this->product_model->find($ids[$i]);

                /**
                 * delete the image if exist
                 */
                if (!empty($client)) {

                    if (file_exists("assets/img/products/" . $client->image)) {

                        unlink("assets/img/products/" . $client->image);
                    }
                }
            }

            $result = $this->product_model->whereIn('id', $ids)->delete();

            if ($result) {

                return jsonResponse("success", "Selected records deleted successfully", 200);
            }

            return jsonResponse("error", "Something went wrong!", 500);
        }

        return jsonResponse("error", "No data selected!", 400);
    }
}
