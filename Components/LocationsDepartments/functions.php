<?php

namespace Flynt\Components\LocationsDepartments;

use ACFComposer\ACFComposer;
use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=LocationsDepartments', function ($data) {
    if (empty($data['heading'])) {
        $data['heading'] = [
            [
                'tag' => 'h2',
                'style' => '',
                'text' => 'Explore Our Showroom Departments',
            ],
        ];
    }

    // Card background colours, applied in order to the first four departments
    // whenever a colour isn't picked manually (so manual rows need no colour).
    $defaultColors = ['#C07947', '#593E2A', '#4D592A', '#3E342B'];

    // $data already contains this flex row's own `departments` sub-field value.

    if (empty($data['departments'])) {
        $data['departments'] = [
            [
                'title' => 'Kitchen & Laundry',
                'description' => 'Create a kitchen that blends style and performance with workstation sinks, professional-grade faucets, pot fillers, filtration systems, and the latest kitchen fixtures Metairie, LA homeowners are choosing for new builds and renovations. You\'ll also find smart laundry solutions designed for everyday convenience.',
                'background_color' => '#C07947',
            ],
            [
                'title' => 'Bathroom',
                'description' => 'Turn your bathroom into a relaxing retreat with luxury vanities, soaking tubs, frameless showers, smart toilets, and premium bathroom fixtures Metairie, LA homeowners trust for comfort and style. Our consultants are here to help simplify every selection.',
                'background_color' => '#593E2A',
            ],
            [
                'title' => 'Home Details',
                'description' => 'Complete your design with decorative cabinet hardware, mirrors, specialty lighting, and finishing accents that create a cohesive look throughout your home.',
                'background_color' => '#4D592A',
            ],
            [
                'title' => 'Outdoor Living',
                'description' => 'Extend your living space outdoors with premium grills, outdoor kitchens, refrigeration units, and entertaining solutions designed to withstand Louisiana\'s climate.',
                'background_color' => '#3E342B',
            ],
        ];
    }

    foreach ($data['departments'] as $index => $department) {
        if (empty($department['background_color']) && isset($defaultColors[$index])) {
            $data['departments'][$index]['background_color'] = $defaultColors[$index];
        }
    }

    return $data;
});

function getACFLayout()
{
    return [
        "label" => "Locations: Departments",
        "name" => "LocationsDepartments",
        "sub_fields" => [
            FieldVariables\getHeadingLoop(),
            [
                "label" => "Departments",
                "name" => "departments",
                "type" => "repeater",
                "layout" => "block",
                "button_label" => "Add Department",
                "sub_fields" => [
                    [
                        "label" => "Image",
                        "name" => "image",
                        "type" => "image",
                        "return_format" => "array",
                    ],
                    [
                        "label" => "Title",
                        "name" => "title",
                        "type" => "text",
                    ],
                    [
                        "label" => "Description",
                        "name" => "description",
                        "type" => "textarea",
                    ],
                    [
                        "label" => "Background Color",
                        "name" => "background_color",
                        "type" => "color_picker",
                    ],
                    [
                        "label" => "Link",
                        "name" => "link",
                        "type" => "link",
                    ],
                ],
            ],
        ],
    ];
}
