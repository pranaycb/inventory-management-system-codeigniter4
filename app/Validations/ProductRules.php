<?php

/**
 * Product Rules
 */

namespace App\Validations;

class ProductRules
{
    public static function getRules($hasImage = true)
    {
        $rules = [
            'category' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Product category is required",
                ]
            ],
            'brand' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Product brand is required",
                ]
            ],
            'attribute' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Product attribute is required",
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Product name is required",
                ]
            ],
            'description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Product description is required",
                ]
            ],
            'qty' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Product quantity is required",
                ]
            ],
            'price' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Unit price is required",
                ]
            ],
        ];

        if ($hasImage) {

            $rules['image'] = [
                'rules' => 'uploaded[image]|is_image[image]|mime_in[image, image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => "Product image is required",
                    'is_image' => 'Please select an image file to upload',
                    'mime_in' => 'Image must be in JPG or PNG format'
                ]
            ];
        }

        return $rules;
    }
}
