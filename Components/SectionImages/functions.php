<?php

namespace Flynt\Components\SectionImages;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;


add_filter('Flynt/addComponentData?name=SectionImages', function ($data) {

    // "View All" link beside the heading: the ACF link wins, otherwise fall back to the Brands page
    if (empty($data['moreLink']['url'])) {
        $brandsPage = get_page_by_path('by-brand');
        $data['moreLink'] = $brandsPage ? [
            'url' => get_permalink($brandsPage),
            'title' => '',
            'target' => '',
        ] : null;
    }

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
          [
            'label' => 'View All Link',
            'name' => 'moreLink',
            'type' => 'link',
            'instructions' => 'Small link shown beside the heading. Leave empty to link to the Brands page. "Link Text" defaults to "View All Brands".',
          ],
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
