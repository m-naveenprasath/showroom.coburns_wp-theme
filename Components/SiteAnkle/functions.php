<?php

namespace Flynt\Components\SiteAnkle;

use Timber;
use ACFComposer\ACFComposer;
use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_filter("Flynt/addComponentData?name=SiteAnkle", function ($data) {
    $data["ankle"] = [];
    if ($options = Options::getGlobal("SiteAnkle")) {
        $data["ankle"] = array_merge($data["ankle"], $options);
    }
    if ($labels = Options::getTranslatable("SiteAnkle")) {
        $data["ankle"] = array_merge($data["ankle"], $labels);
    }

    return $data;
});

Options::addGlobal("SiteAnkle", [
    [
        "label" => "Show Global Ankle",
        "name" => "SiteAnkle_show",
        "type" => "true_false",
        "default_value" => true,
        "ui" => 1,
        "ui_on_text" => "Show",
        "ui_off_text" => "Hide",
    ],
]);

Options::addTranslatable("SiteAnkle", [
    [
        "label" => "Ankle Content",
        "name" => "ankle_content",
        "type" => "repeater",
        "min" => 2,
        "max" => 4,
        "layout" => "block",
        "button_label" => "Add Item",
        "sub_fields" => [
            [
                "label" => "Ankle Icon",
                "name" => "ankle_icon",
                "type" => "select",
                "required" => 1,
                "choices" => [
                    "Account" => "Account",
                    "Location" => "Location",
                    "Shop" => "Shop",
                    "Wishlist" => "Wishlist",
                    "Upload My Own" => "Upload My Own",
                ],
            ],
            [
                "label" => "Ankle Icon Upload",
                "name" => "ankle_icon_upload",
                "type" => "image",
                "conditional_logic" => [
                    [
                        [
                            "name" => "ankle_icon",
                            "operator" => "==",
                            "value" => "Upload My Own",
                        ],
                    ],
                ],
                "preview_size" => "thumbnail",
            ],
            [
                "label" => "Ankle Text",
                "name" => "ankle_text",
                "type" => "textarea",
            ],
            [
                "label" => "Ankle Link",
                "name" => "ankle_link",
                "type" => "link",
                "required" => 1,
                "return_format" => "array",
            ],
        ],
    ],
]);
