<?php

namespace Flynt\Components\LocationsCommunities;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=LocationsCommunities', function ($data) {
    if (empty($data['heading'])) {
        $data['heading'] = [
            [
                'tag' => 'h2',
                'style' => '',
                'text' => 'Serving Harahan, Metairie & Nearby Communities',
            ],
        ];
    }

    if (empty($data['intro'])) {
        $data['intro'] = 'Our showroom proudly serves customers throughout:';
    }

    // Pull communities from the post-level ACF field (registered in locations.php)
    $post_communities = get_field('communities');
    if (!empty($post_communities)) {
        $data['communities'] = $post_communities;
    }

    if (empty($data['communities'])) {
        $data['communities'] = [
            ['name' => 'Harahan'],
            ['name' => 'Metairie'],
            ['name' => 'River Ridge'],
            ['name' => 'Elmwood'],
            ['name' => 'Jefferson'],
            ['name' => 'New Orleans'],
            ['name' => 'Kenner'],
        ];
    }

    return $data;
});

function getACFLayout()
{
    return [
        "label" => "Locations: Communities",
        "name" => "LocationsCommunities",
        "sub_fields" => [
            FieldVariables\getHeadingLoop(),
            [
                "label" => "Intro Text",
                "name" => "intro",
                "type" => "text",
            ],
            [
                "label" => "Communities",
                "name" => "communities",
                "type" => "repeater",
                "layout" => "table",
                "button_label" => "Add Community",
                "sub_fields" => [
                    [
                        "label" => "Name",
                        "name" => "name",
                        "type" => "text",
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
