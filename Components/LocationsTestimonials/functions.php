<?php

namespace Flynt\Components\LocationsTestimonials;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=LocationsTestimonials', function ($data) {
    if (empty($data['heading'])) {
        $data['heading'] = [
            [
                'tag'   => 'h2',
                'style' => '',
                'text'  => 'What Customers Say',
            ],
        ];
    }

    $post_view_all = get_field('view_all_link');
    if (!empty($post_view_all)) {
        $data['view_all_link'] = $post_view_all;
    }

    $post_testimonials = get_field('testimonials');
    if (!empty($post_testimonials)) {
        $data['testimonials'] = $post_testimonials;
    }

    if (empty($data['testimonials'])) {
        $data['testimonials'] = [
            [
                'name'   => 'Sarah M., Metairie',
                'role'   => 'Satisfied Customer',
                'rating' => 5,
                'review' => "We remodeled our primary bathroom and found everything we needed at Coburn's. The consultant helped us coordinate fixtures and finishes that matched our design vision perfectly.",
            ],
            [
                'name'   => 'Jennifer T.',
                'role'   => 'Satisfied Customer',
                'rating' => 5,
                'review' => 'Outstanding service from start to finish. The team helped us select kitchen and bath products that fit our budget without sacrificing quality or style.',
            ],
            [
                'name'   => 'David R., Harahan',
                'role'   => 'Satisfied Customer',
                'rating' => 5,
                'review' => 'The showroom displays made selection much easier. We found faucets, a soaking tub, and everything we needed for our entire renovation project.',
            ],
            [
                'name'   => 'Michael K., Kenner',
                'role'   => 'Homeowner',
                'rating' => 5,
                'review' => 'Exceptional products and knowledgeable staff. They helped me find the perfect fixtures for my kitchen remodel within budget.',
            ],
            [
                'name'   => 'Lisa B., River Ridge',
                'role'   => 'Homeowner',
                'rating' => 5,
                'review' => "Coburn's has an incredible selection and the staff really knows their products. My new kitchen looks stunning thanks to their guidance.",
            ],
        ];
    }

    return $data;
});

function getACFLayout()
{
    return [
        'label'      => 'Locations: Testimonials',
        'name'       => 'LocationsTestimonials',
        'sub_fields' => [
            FieldVariables\getHeadingLoop(),
            [
                'label' => 'View All Link',
                'name'  => 'view_all_link',
                'type'  => 'link',
            ],
            [
                'label'        => 'Testimonials',
                'name'         => 'testimonials',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => 'Add Testimonial',
                'sub_fields'   => [
                    [
                        'label'         => 'Photo',
                        'name'          => 'photo',
                        'type'          => 'image',
                        'return_format' => 'array',
                    ],
                    [
                        'label' => 'Name',
                        'name'  => 'name',
                        'type'  => 'text',
                    ],
                    [
                        'label' => 'Role / Title',
                        'name'  => 'role',
                        'type'  => 'text',
                    ],
                    [
                        'label'         => 'Rating (1–5)',
                        'name'          => 'rating',
                        'type'          => 'number',
                        'min'           => 1,
                        'max'           => 5,
                        'default_value' => 5,
                    ],
                    [
                        'label' => 'Review',
                        'name'  => 'review',
                        'type'  => 'textarea',
                        'rows'  => 3,
                    ],
                ],
            ],
        ],
    ];
}