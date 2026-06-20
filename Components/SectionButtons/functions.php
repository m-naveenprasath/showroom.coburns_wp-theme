<?php

namespace Flynt\Components\SectionButtons;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;


add_filter('Flynt/addComponentData?name=SectionButtons', function ($data) {
    return $data;
});

function getACFLayout() {
    return [
        'label' => 'Section: Buttons',
        'name' => 'SectionButtons',
        'sub_fields' => [
            FieldVariables\getTab("Links"),
            FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>tag: h2 or h3, size: h4, style: body'),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getButtonLoop(),
            FieldVariables\getTab("Options"),
            FieldVariables\getSectionBackgroundSelect()
        ]
    ];
}

Options::addGlobal('SectionButtons', [
    FieldVariables\getSectionBackgroundSelect(),
], 'Sections');
