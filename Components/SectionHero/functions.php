<?php

namespace Flynt\Components\SectionHero;

use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_filter("Flynt/addComponentData?name=SectionHero", function ($data) {
    if ($options = Options::getGlobal("CorporateSocialMediaAccounts")) {
        $data = array_merge($data, $options);
    }

    return $data;
});

function getACFLayout()
{
    return [
        "label" => "Section: Hero",
        "name" => "SectionHero",
        "sub_fields" => [
            FieldVariables\getTab("Content"),
            FieldVariables\getHeadingLoop(
                $instructions =
                    "<strong>Defaults</strong><br/>tag: h1, style: minimal-1<br/>tag: p/div, style: display 1"
            ),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getSectionContent_2(),
            FieldVariables\getButtonLoop($limit = 2),
            FieldVariables\getSectionContent_3(),
            FieldVariables\getTab("Carousel"),
            FieldVariables\getCarouselToggle($default = false),
            [
                "label" => "Carousel Heading",
                "name" => "carouselHeading",
                "type" => "group",
                "layout" => "table",
                "instructions" => "<strong>Defaults</strong>: tag: h2",
                "sub_fields" => [FieldVariables\getHeadingParts($required = false, $included_fields = ["tag", "text"])],
            ],
            FieldVariables\getCarousel($default_visibility = false),
            FieldVariables\getTab("Sharing"),
            FieldVariables\getShareWithToggle($default_visibility = false),
            FieldVariables\getShareWithAccounts($default_visibility = true),
            // FieldVariables\getShareWithTwitter(),
            FieldVariables\getTab("Options"),
            FieldVariables\getFeaturedImageToggle(),
            // FieldVariables\getBreadcrumbToggle(),
            FieldVariables\getVideoType(),
            [
                "label" => "Style Finder Stamp",
                "name" => "styleFinderStamp_show",
                "type" => "true_false",
                "default_value" => false,
                "ui" => 1,
                "ui_on_text" => "Show",
                "ui_off_text" => "Hide",
            ],
            [
                "label" => "Social Links",
                "name" => "socialLinks_show",
                "type" => "true_false",
                "default_value" => false,
                "ui" => 1,
                "ui_on_text" => "Show",
                "ui_off_text" => "Hide",
            ],
        ],
    ];
}
