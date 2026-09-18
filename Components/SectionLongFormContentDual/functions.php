<?php

namespace Flynt\Components\SectionLongFormContentDual;

use Flynt\FieldVariables;

add_action('wp_enqueue_scripts', function () {
    $componentNamespace = explode('\\', __NAMESPACE__);
    $componentName = array_pop($componentNamespace);

    $js_path = '/Components/' . $componentName . '/script.js';
    wp_register_script(
        $componentName,
        get_stylesheet_directory_uri() . $js_path,
        ['jquery'],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );
});

add_filter(
    'Flynt/renderComponent',
    function ($output, $componentName) {
        if ($componentName == 'SectionLongFormContentDual') {
            wp_enqueue_script($componentName);
        }

        return $output;
    },
    10,
    3
);

add_filter('Flynt/addComponentData?name=SectionLongFormContentDual', function ($data) {
    if (empty($data['headings_1'])) {
        $data['headings_1'] = [
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

    if (empty($data['headings_2'])) {
        $data['headings_2'] = [
            [
                'tag'   => 'h2',
                'style' => 'display-2',
                'text'  => "We've Got Answers for Your Kitchen & Bath Project",
            ],
        ];
    }

    if (empty($data['sectionHtml_2'])) {
        $data['sectionHtml_2'] = '<p>Experience the ultimate destination for your kitchen and bath remodeling journey. Our showroom offers a curated selection of premium products, paired with expert design consultation and professional installation services to bring your vision to life.</p>';
    }

    return $data;
});

function getACFLayout()
{
    return [
        'label' => 'Section: Long Form Content (Dual)',
        'name' => 'SectionLongFormContentDual',
        'sub_fields' => [
            FieldVariables\getTab('Content 1'),
            FieldVariables\getHeadingLoop(
                $instructions = '<strong>Defaults</strong><br/>tag: span, style: minimal-1 (eyebrow)<br/>tag: h2, style: display-2 (heading)',
                $name = 'headings_1',
                $label = 'Headings 1'
            ),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getTab('Content 2'),
            FieldVariables\getHeadingLoop(
                $instructions = '<strong>Defaults</strong><br/>tag: span, style: minimal-1 (eyebrow)<br/>tag: h2, style: display-2 (heading)',
                $name = 'headings_2',
                $label = 'Headings 2'
            ),
            FieldVariables\getSectionContent_2(),
            FieldVariables\getTab('Options'),
            FieldVariables\getSectionTextAlignSelect($default = 'center'),
        ],
    ];
}
