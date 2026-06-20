<?php

namespace Flynt\Components\SectionFullWidth;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=SectionFullWidth', function ($data) {
    return $data;
});

function getACFLayout()
{
    return [
        'label' => 'Section: Full Width',
        'name' => 'SectionFullWidth',
        'sub_fields' => [
            FieldVariables\getTab("Content"),
            FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>tag: h2, size: auto, style: minimal 1<br/>tag: p, size: auto, style: display 1'),
            FieldVariables\getSectionContent_1(),
            [
                'label' => 'Embed URL',
                'name' => 'embed_url',
                'type' => 'url',
                'instructions' => 'Currently renders only 16x9.'
            ],
            [
                'label' => 'Shortcode',
                'name' => 'shortcode',
                'type' => 'text',
            ],
            FieldVariables\getButtonLoop($limit = 2),
            FieldVariables\getTab("Options"),
            FieldVariables\getSectionIDField(),
            FieldVariables\getSectionBackgroundSelect(),
            FieldVariables\getSectionPaddingSelect(),
            FieldVariables\getSectionTextAlignSelect($default = 'center'),
        ]
    ];
}
