<?php

namespace Flynt\Components\LocationsWhyCoburns;

use Flynt\FieldVariables;
use Flynt\Utils\Options;

const DEFAULT_ICONS = [
    'location-Extensive',
    'location-Experience',
    'location-Expert',
    'location-Trusted',
];

const ICON_FIELD_CLASS = 'locations-why-coburns-icon';

// Prefill the icon input by row position (1st-4th) when it is empty; editors can still change it.
add_filter('acf/prepare_field', function ($field) {
    if (empty($field['wrapper']['class']) || strpos($field['wrapper']['class'], ICON_FIELD_CLASS) === false) {
        return $field;
    }

    if (empty($field['value']) && preg_match_all('/\[row-(\d+)\]/', $field['name'], $matches)) {
        $index = (int) end($matches[1]);
        if (isset(DEFAULT_ICONS[$index])) {
            $field['value'] = DEFAULT_ICONS[$index];
        }
    }

    return $field;
});

add_filter('Flynt/addComponentData?name=LocationsWhyCoburns', function ($data) {
    // Fall back to the default icon for rows saved without one.
    if (!empty($data['features']) && is_array($data['features'])) {
        foreach ($data['features'] as $index => &$feature) {
            if (empty($feature['icon']) && isset(DEFAULT_ICONS[$index])) {
                $feature['icon'] = DEFAULT_ICONS[$index];
            }
        }
        unset($feature);
    }

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
                "min"          => 4,
                "sub_fields"   => [
                    [
                        "label"        => "Icon",
                        "name"         => "icon",
                        "type"         => "text",
                        "instructions" => "Prefilled for the first four rows (Extensive, Experience, Expert, Trusted). Change only if needed. Icon filename without extension.",
                        "wrapper"      => ["class" => ICON_FIELD_CLASS],
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
