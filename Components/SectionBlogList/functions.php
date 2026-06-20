<?php

namespace Flynt\Components\SectionBlogList;

use Flynt\FieldVariables;
use Flynt\Utils\Options;
use Timber\Timber;

const POST_TYPE = 'post';

add_filter('Flynt/addComponentData?name=SectionBlogList', function ($data) {
    $postType = POST_TYPE;

    $data['posts'] = Timber::get_posts([
        'post_status' => 'publish',
        'post_type' => $postType,
        'posts_per_page' => 3,
        'ignore_sticky_posts' => 1,
        'post__not_in' => array(get_the_ID())
    ]);

    $data['postTypeArchiveLink'] = get_post_type_archive_link($postType);

    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'SectionBlogList',
        'label' => 'Section: Blog Posts',
        'sub_fields' => [
			FieldVariables\getTab("Content"),
	        FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>An h2 is always required.<br/>one headline — tag: h2, size: h2, style: default<br/>two headlines — tag: h1, size: auto, style: minimal 1; tag: h2, size: h1, style: display 1'),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getSectionContent_2(),
			FieldVariables\getTab("Links"),
			FieldVariables\getButtonLoop($limit = 1),
            FieldVariables\getTab("Options"),
			FieldVariables\getSectionBackgroundSelect(),
            [
                'label' => 'Text Area',
                'name' => 'sectionTextArea',
                'type' => 'select',
				'required' => 1,
				'choices' => [
					'Larger Column' => 'Larger Column (two headlines present)',
					'Smaller Column' => 'Smaller Column (one headline present)',
				],
            ],
        ]
    ];
}

Options::addTranslatable('SectionBlogList', [
    [
        'label' => 'Labels',
        'name' => 'labelsTab',
        'type' => 'tab',
        'placement' => 'top',
        'endpoint' => false
    ],
    [
        'label' => '',
        'name' => 'labels',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'More Label',
                'name' => 'morePosts',
                'type' => 'text',
                'default_value' => 'More',
                'required' => 1,
            ],
            [
                'label' => 'Read More Label',
                'name' => 'readMore',
                'type' => 'text',
                'default_value' => 'Read More',
                'required' => 1,
            ],
        ],
    ]
], 'Blog');
