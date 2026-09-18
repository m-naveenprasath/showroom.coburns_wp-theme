<?php

namespace Flynt\Components\SectionLongFormContent;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=SectionLongFormContent', function ($data) {
    if (empty($data['headings'])) {
        $data['headings'] = [
            [
                'tag'   => 'span',
                'style' => 'minimal-1',
                'text'  => '',
            ],
            [
                'tag'   => 'h2',
                'style' => 'display-2',
                'text'  => "We've Got Answers for Your Kitchen & Bath Project",
            ],
        ];
    }

    if (empty($data['sectionHtml_1'])) {
        $data['sectionHtml_1'] = '<p>Experience the ultimate destination for your kitchen and bath remodeling journey. Our showroom offers a curated selection of premium products, paired with expert design consultation and professional installation services to bring your vision to life.</p>';
    }

    return $data;
});

function getACFLayout()
{
    return [
        'label' => 'Section: Long Form Content',
        'name' => 'SectionLongFormContent',
        'sub_fields' => [
            FieldVariables\getTab('Content'),
            FieldVariables\getHeadingLoop(
                $instructions = '<strong>Defaults</strong><br/>tag: span, style: minimal-1 (eyebrow)<br/>tag: h2, style: display-2 (heading)'
            ),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getTab('Options'),
            FieldVariables\getSectionTextAlignSelect($default = 'center'),
        ],
    ];
}
