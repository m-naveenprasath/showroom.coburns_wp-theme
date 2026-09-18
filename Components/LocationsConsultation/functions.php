<?php

namespace Flynt\Components\LocationsConsultation;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=LocationsConsultation', function ($data) {
    // $data already contains this flex row's own sub-fields.
    $location_name = isset($GLOBALS['post']) ? $GLOBALS['post']->post_title : 'your area';

    if (empty($data['heading'])) {
        $data['heading'] = 'Schedule Your Free Design Consultation';
    }

    if (empty($data['description_1'])) {
        $data['description_1'] = 'Planning a kitchen or bathroom renovation? Meet our consultants for expert guidance on fixtures, finishes, and layouts tailored to your vision.';
    }

    if (empty($data['description_2'])) {
        $data['description_2'] = "Get started at Coburn's Kitchen & Bath Showroom in {$location_name}. Homeowners trust us for premium products and design expertise. Schedule your free consultation today!";
    }

    if (empty($data['primary_button'])) {
        $data['primary_button'] = [
            'title'  => 'Schedule Free Consultation',
            'url'    => '#',
            'target' => '',
        ];
    }

    if (empty($data['secondary_button'])) {
        $data['secondary_button'] = [
            'title'  => 'Call Showroom Now',
            'url'    => '#',
            'target' => '',
        ];
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