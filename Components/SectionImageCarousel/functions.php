<?php

namespace Flynt\Components\SectionImageCarousel;

use Flynt\FieldVariables;

function getACFLayout()
{
    return [
        'label' => 'Section: Image Carousel',
        'name' => 'SectionImageCarousel',
        'sub_fields' => [
            FieldVariables\getTab('Content'),
            FieldVariables\getHeadingLoop(
                $instructions = '<strong>Defaults</strong><br/>tag: div, style: minimal-1<br/>tag: h2, style: display-2'
            ),
            FieldVariables\getTab('Media'),
            FieldVariables\getCarousel(),
            FieldVariables\getTab('Options'),
            [
                'label' => 'Background Color',
                'name' => 'backgroundColor',
                'type' => 'color_picker',
                'instructions' => 'Leave empty for no background.',
            ],
        ],
    ];
}
