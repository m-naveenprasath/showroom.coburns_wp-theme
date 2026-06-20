<?php

namespace Flynt\Components\SectionFeatured;

use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=SectionFeatured', function ($data) {
    return $data;
});

function getACFLayout()
{
    return [
        'label' => 'Section: Featured Room',
        'name' => 'SectionFeatured',
        'sub_fields' => [
		    FieldVariables\getTab("Content"),
			FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>tag: h1, size: auto, style: minimal-1'),
            [
                'label' => 'Author',
                'name' => 'author',
                'type' => 'group',
                'layout' => 'group',
                'sub_fields' => [
                    [
                        'name' => 'name',
                        'label' => 'Author Name',
                        'type' => 'text',
                    ],
                    [
                        'name' => 'image',
                        'label' => 'Author Image',
                        'type' => 'image',
                    ],
                    [
                        'name' => 'quote',
                        'label' => 'Author Quote',
                        'type' => 'text',
                    ],
                ],
            ],
		    FieldVariables\getButtonLoop($limit = 1),
			FieldVariables\getTab("Media"),
            FieldVariables\getCarousel(),
            FieldVariables\getTab("Options"),
            FieldVariables\getSectionBackgroundSelect(),
        ]
    ];
}
