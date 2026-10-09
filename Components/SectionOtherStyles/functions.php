<?php

namespace Flynt\Components\SectionOtherStyles;

use Flynt\FieldVariables;
use Timber\Timber;

add_filter("Flynt/addComponentData?name=SectionOtherStyles", function ($data) {
    if (array_key_exists("current_style", $data)) {
        $data["posts"] = Timber::get_posts([
            "post_type" => "style",
            "post_status" => "publish",
            "posts_per_page" => -1,
            "orderby" => "menu_order",
            "order" => "ASC",
            "post__not_in" => [$data["current_style"]],
        ]);

        // Card text: the style's excerpt, falling back to its hero text.
        foreach ($data["posts"] as $post) {
            $excerpt = $post->post_excerpt ?: get_post_meta($post->ID, "hero_sectionHtml_1", true);
            $post->card_excerpt = wp_trim_words(wp_strip_all_tags((string) $excerpt), 30, "…");
        }
    }

    $data["archive_link"] = get_post_type_archive_link("style");

    return $data;
});

function getACFLayout()
{
    return [
        "name" => "SectionOtherStyles",
        "label" => "Style: Other Styles",
        "sub_fields" => [
            FieldVariables\getMessage("<strong>This section pulls in all other styles as a carousel.</strong>"),
            [
                "label" => "Heading",
                "name" => "heading",
                "type" => "text",
                "default_value" => "Explore Other Styles",
            ],
            [
                "label" => "Current Style",
                "name" => "current_style",
                "type" => "post_object",
                "required" => 1,
                "instructions" => "Select the current style so it isn't included. (This is a very hacky workaround.)",
                "post_type" => [
                    0 => "style",
                ],
                "taxonomy" => "",
                "allow_null" => 0,
                "multiple" => 0,
                "return_format" => "id",
                "ui" => 1,
                "default_value" => get_the_ID(),
            ],
        ],
    ];
}
