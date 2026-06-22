<?php

namespace Flynt\Components\LocationsProducts;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=LocationsProducts', function ($data) {
    if (empty($data['heading'])) {
        $data['heading'] = [
            [
                'tag'   => 'h2',
                'style' => '',
                'text'  => 'Popular Products for Local Remodeling Projects',
            ],
        ];
    }

    $post_products = get_field('products');
    if (!empty($post_products)) {
        $data['products'] = $post_products;
    }

    if (empty($data['products'])) {
        $data['products'] = [
            [
                'title'       => 'Matte Black Hardware',
                'description' => "One of today's most requested finishes, adding bold contrast and sophisticated style to kitchens and bathrooms.",
            ],
            [
                'title'       => 'Luxury Smart Toilets',
                'description' => 'Experience heated seating, bidets, automatic flushing, and features that enhance your bathroom.',
            ],
            [
                'title'       => 'Rainfall Shower Systems',
                'description' => 'Experience heated seating, bidets, automatic flushing, and features that enhance your bathroom.',
            ],
            [
                'title'       => 'Farmhouse & Apron-Front Sinks',
                'description' => 'A timeless favorite for both traditional and contemporary kitchens, offering generous workspace and striking visual appeal.',
            ],
            [
                'title'       => 'Water-Efficient Faucets',
                'description' => 'Modern fixtures that help conserve water while maintaining exceptional performance and elegant design.',
            ],
            [
                'title'       => 'Under-Counter Beverage Centers',
                'description' => 'Perfect for entertaining spaces, outdoor kitchens, home bars, and luxury renovations.',
            ],
        ];
    }

    return $data;
});

function getACFLayout()
{
    return [
        'label'      => 'Locations: Products',
        'name'       => 'LocationsProducts',
        'sub_fields' => [
            FieldVariables\getHeadingLoop(),
            [
                'label'        => 'Products',
                'name'         => 'products',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => 'Add Product',
                'sub_fields'   => [
                    [
                        'label'         => 'Image',
                        'name'          => 'image',
                        'type'          => 'image',
                        'return_format' => 'array',
                    ],
                    [
                        'label' => 'Title',
                        'name'  => 'title',
                        'type'  => 'text',
                    ],
                    [
                        'label' => 'Description',
                        'name'  => 'description',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                    [
                        'label' => 'Link',
                        'name'  => 'link',
                        'type'  => 'link',
                    ],
                ],
            ],
        ],
    ];
}