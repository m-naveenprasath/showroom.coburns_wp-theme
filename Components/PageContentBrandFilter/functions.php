<?php

namespace Flynt\Components\PageContentBrandFilter;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

add_filter("Flynt/addComponentData?name=PageContentBrandFilter", function ($data) {
    $data["brands"] = Timber::get_posts([
        "orderby" => "menu_order",
        "order" => "ASC",
        "post_status" => "publish",
        "post_type" => "brands",
        "posts_per_page" => -1,
        "category_name" => "Featured",
    ]);
    return $data;
});

function getACFLayout()
{
    return [
        "label" => "Section: Brand Filter",
        "name" => "PageContentBrandFilter",
        "sub_fields" => [
            FieldVariables\getMessage(
                "This section pulls in a fancy tabs type thing filled with brands from the brands post type."
            ),
        ],
    ];
}
