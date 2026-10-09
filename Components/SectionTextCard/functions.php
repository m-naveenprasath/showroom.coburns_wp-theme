<?php

namespace Flynt\Components\SectionTextCard;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'label' => 'Section: Text Card',
        'name' => 'SectionTextCard',
        'sub_fields' => [
            FieldVariables\getTab('Content'),
            FieldVariables\getHeadingLoop(
                $instructions = '<strong>Defaults</strong><br/>tag: h2, style: display-2'
            ),
            [
                'label' => 'Lead Text',
                'name' => 'leadText',
                'type' => 'textarea',
                'rows' => 3,
                'new_lines' => 'br',
                'instructions' => 'Large intro paragraph shown above the divider.',
            ],
            FieldVariables\getSectionContent_1(),
            FieldVariables\getTab('Options'),
            [
                'label' => 'Background Color',
                'name' => 'backgroundColor',
                'type' => 'color_picker',
                'instructions' => 'Leave empty for the default card background.',
            ],
        ],
    ];
}
