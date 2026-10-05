<?php

namespace Flynt\Components\SectionImageText;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'label' => 'Section: Image & Text',
        'name' => 'SectionImageText',
        'sub_fields' => [
            FieldVariables\getTab('Content'),
            FieldVariables\getHeadingLoop(
                $instructions = '<strong>Defaults</strong><br/>tag: h2, style: display-2'
            ),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getButtonLoop($limit = 2, $required = false, $accent_line = false),
            FieldVariables\getImage(),
            FieldVariables\getTab('Options'),
            [
                'label' => 'Image Position',
                'name' => 'imagePosition',
                'type' => 'select',
                'choices' => [
                    'right' => 'Right',
                    'left' => 'Left',
                ],
                'default_value' => 'right',
            ],
            [
                'label' => 'Background Color',
                'name' => 'backgroundColor',
                'type' => 'color_picker',
                'instructions' => 'Leave empty for no background.',
            ],
        ],
    ];
}
