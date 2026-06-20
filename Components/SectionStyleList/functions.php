<?php

namespace Flynt\Components\SectionStyleList;

use Flynt\FieldVariables;
use Flynt\Utils\Options;
use Timber\Timber;

const POST_TYPE = 'style';

add_filter('Flynt/addComponentData?name=SectionStyleList', function ($data) {
    $postType = POST_TYPE;

    $data['styles'] = Timber::get_posts([
        'post_status' => 'publish',
        'post_type' => $postType,
        'posts_per_page' => -1,
        'ignore_sticky_posts' => 1
    ]);


    return $data;
});

function getACFLayout()
{
    return [
        'name' => 'SectionStyleList',
        'label' => 'Section: Styles',

    ];
}