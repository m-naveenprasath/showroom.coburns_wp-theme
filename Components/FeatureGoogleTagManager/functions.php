<?php

namespace Flynt\Components\FeatureGoogleTagManager;

use Flynt\Utils\Options;
use Timber\Timber;

add_filter("Flynt/addComponentData?name=FeatureGoogleTagManager", function ($data) {
    $GoogleTagManagerOptions = Options::getGlobal("GoogleTagManager");

    if ($GoogleTagManagerOptions) {
        $data["gtmId"] = $GoogleTagManagerOptions["gtmId"];
    }

    return $data;
});

add_action("Flynt/thirdPartyCookies/initializeOptions", function () {
    Options::addTranslatable("GoogleTagManager", [
        [
            "label" => "Accept Google Tag Manager label",
            "name" => "acceptGoogleTagManagerLabel",
            "type" => "text",
            "default_value" => "All Cookies",
            "required" => 1,
        ],
    ]);
});

add_action("wp_footer", function () {
    $context = Timber::get_context();
    Timber::render_string('{{ renderComponent("FeatureGoogleTagManager") }}', $context);
});

add_filter("Flynt/thirdPartyCookies", function ($features) {
    $GoogleTagManagerTranslatableOptions = Options::getTranslatable("GoogleTagManager");

    $features = array_merge($features, [
        [
            "id" => "GTM_accept",
            "name" => "GTM_accept",
            "label" => $GoogleTagManagerTranslatableOptions["acceptGoogleTagManagerLabel"],
        ],
    ]);
    return $features;
});

Options::addGlobal("GoogleTagManager", [
    [
        "name" => "gtmId",
        "label" => "Google Tag Manager ID",
        "type" => "text",
        "maxlength" => 20,
        "prepend" => "",
        "append" => "",
        "placeholder" => "GTM-XXXXXXX",
    ],
]);
