<?php

namespace Flynt\Components\SectionAppointments;

use Flynt\Utils\Options;
use Timber\Timber;
use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=SectionAppointments', function ($data) {
    return $data;
});

function getACFLayout()
{
    return [
        'label' => 'Section: Appointments',
        'name' => 'SectionAppointments',
        'sub_fields' => [
            [
                'name' => 'form_shortcode',
                'label' => 'Form Shortcode',
                'type' => 'wysiwyg',
                'required' => true,
            ],
            FieldVariables\getMessage("Other content is set globally at https://coburns.wpengine.com/wp-admin/admin.php?page=GlobalOptions-Sections"),
        ]
    ];
}

Options::addGlobal('SectionAppointments', [
    FieldVariables\getSectionBackgroundSelect(),
], 'Sections');

Options::addTranslatable('SectionAppointments', [
	FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>tag: h2, style: minimal-1 <br/>tag: div, style: display-1'),
    FieldVariables\getSectionContent_1(),
], 'Sections');
