<?php

namespace Flynt\Components\LocationsFAQ;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=LocationsFAQ', function ($data) {
    $post_eyebrow = get_field('eyebrow');
    if (!empty($post_eyebrow)) {
        $data['eyebrow'] = $post_eyebrow;
    }
    if (empty($data['eyebrow'])) {
        $data['eyebrow'] = 'Got Questions?';
    }

    if (empty($data['heading'])) {
        $data['heading'] = [
            [
                'tag'   => 'h2',
                'style' => '',
                'text'  => "We've Got Answers for Your Kitchen & Bath Project",
            ],
        ];
    }

    $post_faqs = get_field('faqs');
    if (!empty($post_faqs)) {
        $data['faqs'] = $post_faqs;
    }

    if (empty($data['faqs'])) {
        $data['faqs'] = [
            [
                'question' => 'Do I Need an Appointment to Visit the Showroom?',
                'answer'   => 'No, walk-ins are always welcome during our regular showroom hours, but appointments are recommended for personalized design assistance and product selection guidance.',
            ],
            [
                'question' => 'Can Homeowners Purchase Directly From the Showroom?',
                'answer'   => 'Yes. We serve homeowners, builders, remodelers, and designers, helping customers find products that fit their project and budget.',
            ],
            [
                'question' => 'Can You Help With Remodeling Product Selections?',
                'answer'   => 'Absolutely. Our design consultants are experienced in helping you select coordinated products across your entire remodeling project — from faucets and fixtures to sinks and tubs.',
            ],
            [
                'question' => 'Do You Carry Major Brands?',
                'answer'   => 'Yes, our showroom carries a wide selection of top kitchen and bath brands. Visit us to explore our current in-store displays and product catalog.',
            ],
            [
                'question' => 'What Are Your Showroom Hours?',
                'answer'   => 'Showroom hours vary by location. Please visit our location page or call ahead to confirm current hours for the showroom nearest you.',
            ],
        ];
    }

    return $data;
});

function getACFLayout()
{
    return [
        'label'      => 'Locations: FAQ',
        'name'       => 'LocationsFAQ',
        'sub_fields' => [
            [
                'label' => 'Eyebrow Text',
                'name'  => 'eyebrow',
                'type'  => 'text',
            ],
            FieldVariables\getHeadingLoop(),
            [
                'label'        => 'FAQ Items',
                'name'         => 'faqs',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => 'Add FAQ Item',
                'sub_fields'   => [
                    [
                        'label' => 'Question',
                        'name'  => 'question',
                        'type'  => 'text',
                    ],
                    [
                        'label' => 'Answer',
                        'name'  => 'answer',
                        'type'  => 'textarea',
                        'rows'  => 4,
                    ],
                ],
            ],
        ],
    ];
}