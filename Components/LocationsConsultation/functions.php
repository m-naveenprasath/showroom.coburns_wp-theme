<?php

namespace Flynt\Components\LocationsConsultation;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=LocationsConsultation', function ($data) {
    $location_name = isset($GLOBALS['post']) ? $GLOBALS['post']->post_title : 'your area';

    $post_heading = get_field('heading');
    if (!empty($post_heading)) {
        $data['heading'] = $post_heading;
    }
    if (empty($data['heading'])) {
        $data['heading'] = 'Schedule Your Free Design Consultation';
    }

    $post_desc1 = get_field('description_1');
    if (!empty($post_desc1)) {
        $data['description_1'] = $post_desc1;
    }
    if (empty($data['description_1'])) {
        $data['description_1'] = 'Planning a kitchen or bathroom renovation? Meet our consultants for expert guidance on fixtures, finishes, and layouts tailored to your vision.';
    }

    $post_desc2 = get_field('description_2');
    if (!empty($post_desc2)) {
        $data['description_2'] = $post_desc2;
    }
    if (empty($data['description_2'])) {
        $data['description_2'] = "Get started at Coburn's Kitchen & Bath Showroom in {$location_name}. Homeowners trust us for premium products and design expertise. Schedule your free consultation today!";
    }

    $post_primary = get_field('primary_button');
    if (!empty($post_primary)) {
        $data['primary_button'] = $post_primary;
    }
    if (empty($data['primary_button'])) {
        $data['primary_button'] = [
            'title'  => 'Schedule Free Consultation',
            'url'    => '#',
            'target' => '',
        ];
    }

    $post_secondary = get_field('secondary_button');
    if (!empty($post_secondary)) {
        $data['secondary_button'] = $post_secondary;
    }
    if (empty($data['secondary_button'])) {
        $data['secondary_button'] = [
            'title'  => 'Call Showroom Now',
            'url'    => '#',
            'target' => '',
        ];
    }

    $post_image = get_field('consultation_image');
    if (!empty($post_image)) {
        $data['consultation_image'] = $post_image;
    }

    return $data;
});

function getACFLayout()
{
    return [
        'label'      => 'Locations: Consultation CTA',
        'name'       => 'LocationsConsultation',
        'sub_fields' => [
            [
                'label' => 'Heading',
                'name'  => 'heading',
                'type'  => 'text',
            ],
            [
                'label' => 'Description (first paragraph)',
                'name'  => 'description_1',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'label' => 'Description (second paragraph)',
                'name'  => 'description_2',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'label' => 'Primary Button',
                'name'  => 'primary_button',
                'type'  => 'link',
            ],
            [
                'label' => 'Secondary Button',
                'name'  => 'secondary_button',
                'type'  => 'link',
            ],
            [
                'label'         => 'Image',
                'name'          => 'consultation_image',
                'type'          => 'image',
                'return_format' => 'array',
            ],
        ],
    ];
}