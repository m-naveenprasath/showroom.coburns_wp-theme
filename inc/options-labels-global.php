<?
namespace Flynt\Acf;

use Flynt\Utils\Options;


Options::addTranslatable('BlogCards', [
    [
        'label' => __('Card Labels', 'flynt'),
        'name' => 'cardLabels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => '"Posts" Post Type Eyebrow',
                'name' => 'postTypePostsEyebrow',
                'type' => 'text',
                'default_value' => 'Blog',
                'required' => 1,
                'instructions' => 'Used on blog posts inside search results.',
            ],
        ],
    ],
], 'Blog');
