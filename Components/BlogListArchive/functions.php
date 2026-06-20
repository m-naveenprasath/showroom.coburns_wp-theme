<?php

namespace Flynt\Components\BlogListArchive;

use Flynt\FieldVariables;
use Flynt\Utils\Options;
use Timber\Timber;

const POST_TYPE = 'post';
const FILTER_BY_TAXONOMY = 'category';

add_filter('Flynt/addComponentData?name=BlogListArchive', function ($data) {
    $postType = POST_TYPE;
    $taxonomy = FILTER_BY_TAXONOMY;

    if (is_home()) {
        $data['isHome'] = true;
        $data['title'] = $queriedObject->post_title ?? get_bloginfo('name');
    } else {
        $data['title'] = get_the_archive_title();
        $data['description'] = get_the_archive_description();
    }
    if ($options = Options::getGlobal('BlogHome')) {
        $data = array_merge($data, $options);
    }
    if ($labels = Options::getTranslatable('BlogHome')) {
        $data = array_merge($data, $labels);
    }

    return $data;
});

Options::addTranslatable(
    'BlogHome',
    [
        [
            'label' => '',
            'name' => 'labels',
            'type' => 'group',
            'sub_fields' => [
                [
                    'label' => 'Continue Reading Feature Label',
                    'name' => 'readFeature',
                    'type' => 'text',
                    'default_value' => 'Continue Reading',
                    'required' => 1,
                ],
                [
                    'label' => 'Read More Label',
                    'name' => 'readMore',
                    'type' => 'text',
                    'default_value' => 'Read More',
                    'required' => 1,
                ],
                [
                    'label' => 'Show More Label',
                    'name' => 'loadMore',
                    'type' => 'text',
                    'default_value' => 'Show more',
                    'required' => 1,
                ],
                [
                    'label' => 'No Posts Found Text',
                    'name' => 'noPostsFound',
                    'type' => 'text',
                    'default_value' => 'No posts found.',
                    'required' => 1,
                ],
            ],
        ],
    ],
    'Blog'
);
