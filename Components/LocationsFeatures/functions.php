<?php

namespace Flynt\Components\LocationsFeatures;

use ACFComposer\ACFComposer;
use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=LocationsFeatures', function ($data) {
    if (!isset($data['features']) || empty($data['features'])) {
        $data['features'] = [
            [
                'icon' => 'location-shop',
                'title' => '',
                'description' => 'Premium designer products from top manufacturers',
            ],
            [
                'icon' => 'location-display',
                'title' => '',
                'description' => 'Design consultants offer personalized project support',
            ],
            [
                'icon' => 'location-design',
                'title' => '',
                'description' => 'Showroom displays with today\'s top kitchen and bath',
            ],
            [
                'icon' => 'location-messages',
                'title' => '',
                'description' => 'Free consultations for homeowners and designers',
            ],
        ];
    }

    if ($options = Options::getTranslatable('LocationDefaults')) {
        if (isset($options['location_features_default'])) {
            $data = array_merge($data, ['location_features_default' => $options['location_features_default']]);
        }
    }

    return $data;
});

function getACFLayout()
{
    return [
        "label" => "Locations: Features",
        "name" => "LocationsFeatures",
        "sub_fields" => [
            FieldVariables\getHeadingLoop(),
            [
                "label" => "Features",
                "name" => "features",
                "type" => "repeater",
                "layout" => "block",
                "button_label" => "Add Feature",
                "sub_fields" => [
                    [
                        "label" => "Image",
                        "name" => "image",
                        "type" => "image",
                        "instructions" => "Upload an image to use instead of an icon. If both are set, image takes priority.",
                        "return_format" => "array",
                        "preview_size" => "thumbnail",
                    ],
                    [
                        "label" => "Icon",
                        "name" => "icon",
                        "type" => "text",
                        "instructions" => "Icon name (e.g., 'shopping-bag', 'check-mark'). Used only if no image is set.",
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
                ],
            ],
        ],
    ];
}
