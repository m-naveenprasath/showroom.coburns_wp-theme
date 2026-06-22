<?php

namespace Flynt\Components\LocationsMap;

use ACFComposer\ACFComposer;
use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=LocationsMap', function ($data) {
    if (empty($data['heading'])) {
        $data['heading'] = [
            [
                'tag' => 'p',
                'style' => 'minimal-1',
                'text' => 'Coburn\'s Kitchen & Bath Showroom',
            ],
            [
                'tag' => 'h2',
                'style' => '',
                'text' => 'Location, Hours & Contact Information',
            ],
        ];
    }

    // Pull post-level ACF fields (registered in locations.php)
    $map_embed = get_field('map_embed');
    if (!empty($map_embed)) {
        $data['map_embed'] = $map_embed;
    }

    $address = get_field('map_address');
    if (!empty($address) && is_string($address)) {
        $data['address'] = $address;
    }

    $address_city = get_field('map_address_city');
    if (!empty($address_city) && is_string($address_city)) {
        $data['address_city'] = $address_city;
    }

    $directions_url = get_field('map_directions_url');
    if (!empty($directions_url)) {
        $data['directions_url'] = $directions_url;
    }

    $phone = get_field('map_phone');
    if (!empty($phone)) {
        $data['phone'] = $phone;
    }

    $hours = get_field('map_hours');
    if (!empty($hours)) {
        $data['hours'] = $hours;
    }

    $hours_note = get_field('map_hours_note');
    if (!empty($hours_note)) {
        $data['hours_note'] = $hours_note;
    }

    // Defaults if nothing set in admin
    if (empty($data['address'])) {
        $data['address'] = "139 Plantation Road\nHarahan, LA 70123";
        $data['address_city'] = 'Harahan, Louisiana';
    }

    if (empty($data['phone'])) {
        $data['phone'] = '(504) 733-6300';
    }

    if (empty($data['hours'])) {
        $data['hours'] = [
            ['days' => 'Monday – Friday:', 'time' => '8:00 AM – 5:00 PM'],
            ['days' => 'Saturday:', 'time' => 'By Appointment'],
            ['days' => 'Sunday:', 'time' => 'Closed'],
        ];
        $data['hours_note'] = 'Walk-ins are welcome, but scheduling a showroom consultation ensures dedicated time with one of our design specialists.';
    }

    return $data;
});

function getACFLayout()
{
    return [
        "label" => "Locations: Map & Contact",
        "name" => "LocationsMap",
        "sub_fields" => [
            FieldVariables\getHeadingLoop(),
            [
                "label" => "Map Embed",
                "name" => "map_embed",
                "type" => "textarea",
                "instructions" => "Paste the Google Maps iframe embed code",
            ],
            [
                "label" => "Address Label",
                "name" => "address_label",
                "type" => "text",
                "default_value" => "Address",
            ],
            [
                "label" => "Address City / Subtitle",
                "name" => "address_city",
                "type" => "text",
                "instructions" => "e.g. Harahan, Louisiana",
            ],
            [
                "label" => "Address",
                "name" => "address",
                "type" => "textarea",
                "instructions" => "Street address, city, state, zip (one line per line)",
            ],
            [
                "label" => "Directions URL",
                "name" => "directions_url",
                "type" => "url",
            ],
            [
                "label" => "Directions Button Label",
                "name" => "directions_label",
                "type" => "text",
                "default_value" => "GET DIRECTIONS",
            ],
            [
                "label" => "Phone Label",
                "name" => "phone_label",
                "type" => "text",
                "default_value" => "Phone",
            ],
            [
                "label" => "Phone Number",
                "name" => "phone",
                "type" => "text",
            ],
            [
                "label" => "Hours Label",
                "name" => "hours_label",
                "type" => "text",
                "default_value" => "Hours of Operation",
            ],
            [
                "label" => "Hours",
                "name" => "hours",
                "type" => "repeater",
                "layout" => "table",
                "button_label" => "Add Hours Row",
                "sub_fields" => [
                    [
                        "label" => "Days",
                        "name" => "days",
                        "type" => "text",
                    ],
                    [
                        "label" => "Time",
                        "name" => "time",
                        "type" => "text",
                    ],
                ],
            ],
            [
                "label" => "Hours Note",
                "name" => "hours_note",
                "type" => "textarea",
                "instructions" => "Optional note shown below the hours (e.g. walk-in info)",
            ],
        ],
    ];
}
