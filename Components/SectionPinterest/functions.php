<?php

namespace Flynt\Components\SectionPinterest;

use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=SectionPinterest', function ($data) {

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'SectionPinterest',
        'label' => 'Section: Pinterest',
        'sub_fields' => [
            FieldVariables\getMessage("This content is set globally at https://coburns.wpengine.com/wp-admin/admin.php?page=TranslatableOptions-Sections"),
        ]
    ];
}

Options::addGlobal('SectionPinterest', [
    FieldVariables\getSectionBackgroundSelect(),
], 'Sections');


Options::addTranslatable('SectionPinterest', [
    [
        'label' => 'Eyebrow',
        'name' => 'pinterestEyebrow',
        'type' => 'group',
        'layout' => 'table',
        'instructions' => '<strong>Defaults</strong>: tag: h2, style: minimal 2',
        'sub_fields' => [
            FieldVariables\getHeadingParts(),
        ]
    ],
    [
        'label' => 'Heading',
        'name' => 'pinterestHeading',
        'type' => 'group',
        'layout' => 'table',
        'instructions' => '<strong>Defaults</strong>: tag: div, style: display 2',
        'sub_fields' => [
            FieldVariables\getHeadingParts(),
        ]
    ],
    FieldVariables\getSectionContent_1(),
    FieldVariables\getButton(),
    FieldVariables\getImage(),
], 'Sections');
