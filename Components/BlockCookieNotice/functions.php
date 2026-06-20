<?php

namespace Flynt\Components\BlockCookieNotice;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

add_action("wp_footer", function () {
    $context = Timber::get_context();
    Timber::render_string('{{ renderComponent("BlockCookieNotice") }}', $context);
});

Options::addGlobal("CookieNotice", [
    [
        "label" => "Component Status",
        "name" => "cookieNoticeIsEnabled",
        "type" => "true_false",
        "default_value" => 1,
        "ui" => 1,
        "ui_on_text" => "Activated",
        "ui_off_text" => "Deactivated",
    ],
]);

Options::addTranslatable("CookieNotice", [
    [
        "label" => "Title",
        "name" => "title",
        "type" => "text",
        "default_value" => "This website uses cookies.",
        "required" => 1,
    ],
    [
        "label" => "Content",
        "name" => "contentHtml",
        "type" => "wysiwyg",
        "tabs" => "visual,text",
        "default_value" =>
            "We inform you that this site uses own, technical and third parties cookies to make sure our web page is user-friendly and to guarantee a high functionality of the webpage. By continuing to browse this website, you declare to accept the use of cookies.",
        "media_upload" => 0,
        "delay" => 1,
        "required" => 1,
    ],
    [
        "label" => "Close Button Label",
        "name" => "closeButtonLabel",
        "type" => "text",
        "default_value" => "Ok",
        "required" => 1,
    ],
]);
