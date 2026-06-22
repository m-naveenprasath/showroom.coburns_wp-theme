<?php

namespace Flynt\Components\LocationsWhyCoburns;

use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=LocationsWhyCoburns', function ($data) {
    if (empty($data['heading'])) {
        $data['heading'] = [
            [
                'tag'   => 'h2',
                'style' => '',
                'text'  => "Why Choose Coburn's?",
            ],
        ];
    }

    if (empty($data['features'])) {
        $location_name = isset($GLOBALS['post']) ? $GLOBALS['post']->post_title : 'our area';

        $data['features'] = [
            [
                'icon'        => 'location-Extensive',
                'title'       => 'Extensive Product Selection',
                'description' => 'Discover trusted plumbing fixtures in Harahan LA. Our showroom offers brands like Kohler, Moen, and Delta.',
            ],
            [
                'icon'        => 'location-Experience',
                'title'       => 'Experience it in Person',
                'description' => 'Our showroom lets you see, touch, and compare products before purchasing.',
            ],
            [
                'icon'        => 'location-Expert',
                'title'       => 'Expert Design Guidance',
                'description' => 'We work with homeowners, builders, and designers to choose products that meet goals and budgets.',
            ],
            [
                'icon'        => 'location-Trusted',
                'title'       => 'Trusted Louisiana Resource',
                'description' => "Customers in Southeast Louisiana rely on Coburn's for service.",
            ],
        ];
    }

    return $data;
});

function getACFLayout()
{
    return [
        "label"      => "Locations: Why Choose Coburn's",
        "name"       => "LocationsWhyCoburns",
        "sub_fields" => [
            FieldVariables\getHeadingLoop(),
            [
                "label"        => "Features",
                "name"         => "features",
                "type"         => "repeater",
                "layout"       => "table",
                "button_label" => "Add Feature",
                "sub_fields"   => [
                    [
                        "label"        => "Icon",
                        "name"         => "icon",
                        "type"         => "text",
                        "instructions" => "Icon filename without extension (e.g. location-shop, location-design)",
                    ],
                    [
                        "label" => "Title",
                        "name"  => "title",
                        "type"  => "text",
                    ],
                    [
                        "label" => "Description",
                        "name"  => "description",
                        "type"  => "textarea",
                    ],
                ],
            ],
        ],
    ];
}
