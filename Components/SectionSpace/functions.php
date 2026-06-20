<?php

namespace Flynt\Components\SectionSpace;

use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=SectionSpace', function ($data) {
    return $data;
});

function getACFLayout()
{
    return [
        'label' => 'Section: Space',
        'name' => 'SectionSpace',
        'sub_fields' => [
		    FieldVariables\getTab("Content"),
			FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>tag: h2, style: default'),
            FieldVariables\getSectionContent_1(),
		    FieldVariables\getButtonLoop($limit = 1),
			FieldVariables\getTab("Media"),
            [
                'label' => 'Image 1',
                'name' => 'image_1',
                'type' => 'image',
            ],
            [
                'label' => 'Image 2',
                'name' => 'image_2',
                'type' => 'image',
            ],
            [
                'label' => 'Image 3',
                'name' => 'image_3',
                'type' => 'image',
            ],
            FieldVariables\getTab("Options"),
            FieldVariables\getSectionBackgroundSelect(),
        ]
    ];
}
