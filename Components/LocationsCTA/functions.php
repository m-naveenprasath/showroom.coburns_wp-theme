<?php

namespace Flynt\Components\LocationsCTA;

use ACFComposer\ACFComposer;
use Flynt\FieldVariables;
use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=LocationsCTA', function ($data) {
    // Pull fields from post-level ACF fields (registered in locations.php)
    $cta_image = get_field('cta_image');
    if (!empty($cta_image)) {
        $data['image'] = $cta_image;
    }

    $cta_description = get_field('cta_description');
    if (!empty($cta_description)) {
        $data['description'] = $cta_description;
    }

    $cta_heading = get_field('cta_heading');
    if (!empty($cta_heading)) {
        $data['heading'] = str_replace(
            '{location_name}',
            isset($GLOBALS['post']) ? $GLOBALS['post']->post_title : '',
            $cta_heading
        );
    }

    if (empty($data['heading'])) {
        $heading = 'Find luxury kitchen and bath fixtures near {location_name}.';
        if ($options = Options::getTranslatable('LocationDefaults')) {
            if (!empty($options['location_cta_default']['heading'])) {
                $heading = $options['location_cta_default']['heading'];
            }
        }
        if (isset($GLOBALS['post'])) {
            $heading = str_replace('{location_name}', $GLOBALS['post']->post_title, $heading);
        }
        $data['heading'] = $heading;
    }

    if (empty($data['description'])) {
        $location_name = isset($GLOBALS['post']) ? $GLOBALS['post']->post_title : 'your area';
        $data['description'] = '<p>Seeking design inspiration and premium fixtures for your renovation? Coburn\'s showroom near ' . esc_html($location_name) . ' features designer faucets, luxury shower systems, and custom bath solutions. Visit our showroom to compare styles and receive personalized guidance from our design specialists.</p>';
    }

    $directions_url = get_field('cta_directions_url') ?: '#';

    if (empty($data['buttons'])) {
        $data['buttons'] = [
            [
                'text'  => 'Get Directions',
                'link'  => [
                    'url'    => $directions_url,
                    'target' => '_blank',
                    'title'  => 'Get Directions',
                ],
                'color' => 'primary',
                'style' => '',
            ],
        ];
    }

    return $data;
});

function getACFLayout()
{
    return [
        "label" => "Locations: Call-To-Action",
        "name" => "LocationsCTA",
        "sub_fields" => [
            [
                "label" => "Image",
                "name" => "image",
                "type" => "image",
                "return_format" => "array",
            ],
            [
                "label" => "Heading",
                "name" => "heading",
                "type" => "text",
            ],
            [
                "label" => "Description",
                "name" => "description",
                "type" => "wysiwyg",
                "toolbar" => "basic",
            ],
            FieldVariables\getButtonLoop(),
        ],
    ];
}
