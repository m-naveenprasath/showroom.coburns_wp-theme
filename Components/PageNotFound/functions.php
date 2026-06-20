<?php

namespace Flynt\Components\PageNotFound;

use Flynt\Utils\Options;

add_filter("Flynt/addComponentData?name=PageNotFound", function ($data) {
    if ($options = Options::getTranslatable("PageNotFound")) {
        $data = array_merge($data, $options);
    }

    return $data;
});

Options::addTranslatable("PageNotFound", [
    [
        "name" => "title",
        "label" => "Title",
        "instructions" => "Title to be displayed on the 404 Not Found Page",
        "type" => "text",
        "default_value" => "Page Not Found",
        "required" => 1,
    ],
    [
        "name" => "contentHtml",
        "label" => "Content",
        "instructions" => "Content to be displayed on the 404 Not Found Page",
        "type" => "wysiwyg",
        "media_upload" => 0,
        "default_value" => "The page you are looking for does not exist.",
        "required" => 1,
        "delay" => 1,
    ],
    [
        "name" => "backLinkLabel",
        "label" => "Back to Home Page Label",
        "instructions" => "Leave empty to remove back to home link below the content area.",
        "type" => "text",
        "default_value" => "Back to Home Page",
    ],
]);
