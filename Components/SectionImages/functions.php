<?php

namespace Flynt\Components\SectionImages;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;


add_filter('Flynt/addComponentData?name=SectionImages', function ($data) {

    return $data;
});


function getACFLayout() {
    return [
        'label' => 'Section: Image Gallery',
        'name' => 'SectionImages',
        'sub_fields' => [
          FieldVariables\getTab("Content"),
          FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>tag: h2, size: auto, style: subhead'),
          FieldVariables\getSectionContent_1(),
          FieldVariables\getTab("Images"),
          [
            'label' => 'Images',
            'name' => 'imagesLinks',
            'type' => 'repeater',
            'collapsed' => 'text',
            'layout' => 'table',
            'button_label' => 'Add Image',
            'sub_fields' => [
              [
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'required' => 1,
              ],
              [
                'label' => 'Brand Name',
                'name' => 'label',
                'type' => 'text',
                'instructions' => 'Shown under the logo. Falls back to the image alt text / title.',
                'wrapper' => ['width' => '20'],
              ],
              [
                'label' => 'Link',
                'name' => 'link',
                'type' => 'link',
                'wrapper' => ['width' => '30'],
                'required' => 1,
                'instructions' => '"Link Text" is optional and used for a more detailed accessible label.',
              ],
            ],
          ],
          FieldVariables\getTab("Options"),
          FieldVariables\getSectionBackgroundSelect(),
           
        ]
    ];
}
