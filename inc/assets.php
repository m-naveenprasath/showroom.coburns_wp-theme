<?php

use Flynt\Utils\Asset;
use Flynt\Utils\Options;
use Flynt\Utils\ScriptLoader;

call_user_func(function () {
    $loader = new ScriptLoader();
    add_filter("script_loader_tag", [$loader, "filterScriptLoaderTag"], 10, 2);
});

// Register Core JS Libraries

add_action("wp_enqueue_scripts", function () {
    $js_path = "/node_modules/vue/dist/vue.min.js";
    wp_register_script(
        "vue",
        get_stylesheet_directory_uri() . $js_path,
        [],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );

    $js_path = "/node_modules/bootstrap/dist/js/bootstrap.min.js";
    wp_register_script(
        "bootstrap",
        get_stylesheet_directory_uri() . $js_path,
        ["jquery"],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );
});

// Register Carousel JS

add_action("wp_enqueue_scripts", function () {
    $js_path = "/node_modules/keen-slider/keen-slider.js";
    wp_register_script(
        "keen-slider",
        get_stylesheet_directory_uri() . $js_path,
        [],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );

    $js_path = "/js/src/carousel.js";
    wp_register_script(
        "carousel",
        get_stylesheet_directory_uri() . $js_path,
        ["keen-slider"],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );
});

// Register Map JS

add_action("wp_enqueue_scripts", function () {
    $apiKey = Options::getGlobal("Google Maps", "googleMapsApiKey");
    wp_register_script(
        "google-maps-api",
        "https://maps.googleapis.com/maps/api/js?key=" . $apiKey . "&libraries=geometry",
        null,
        null,
        true
    );

    $js_path = "/js/src/map.js";
    wp_register_script(
        "google-map",
        get_stylesheet_directory_uri() . $js_path,
        ["google-maps-api", "jquery"],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );
});

// Register Table Sorting JS

add_action("wp_enqueue_scripts", function () {
    $js_path = "/node_modules/tablesort/dist/tablesort.min.js";
    wp_register_script(
        "tablesort",
        get_stylesheet_directory_uri() . $js_path,
        [],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );

    $js_path = "/node_modules/tablesort/dist/sorts/tablesort.number.min.js";
    wp_register_script(
        "tablesort-number",
        get_stylesheet_directory_uri() . $js_path,
        ["tablesort"],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );

    $js_path = "/js/src/location-sort.js";
    wp_enqueue_script(
        "location-sort",
        get_stylesheet_directory_uri() . $js_path,
        ["tablesort-number"],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );
});

// Enqueue core CSS/JS

add_action("wp_enqueue_scripts", function () {
    // CSS
    $css_path = "https://use.typekit.net/ute8tox.css#preload&display=swap";
    wp_enqueue_style("typekit", $css_path, [], "all");

    $css_path = "/css/dist/min/style-showroom.css";
    wp_enqueue_style(
        "showroom",
        get_stylesheet_directory_uri() . $css_path,
        [],
        filemtime(get_stylesheet_directory() . $css_path),
        "screen"
    );

    if (is_user_logged_in()) {
        $css_path = "/css/dist/min/utility.css";
        wp_enqueue_style(
            "utility",
            get_stylesheet_directory_uri() . $css_path,
            [],
            filemtime(get_stylesheet_directory() . $css_path),
            "screen"
        );
    }

    //JS
    $js_path = "/js/src/scripts.js";
    wp_enqueue_script(
        "coburns",
        get_stylesheet_directory_uri() . $js_path,
        ["jquery", "bootstrap"],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );

    if (
        (is_user_logged_in() ||
            wp_get_environment_type() != "production" ||
            strpos(get_site_url(), "wpengine.com") > 0) &&
        !is_admin()
    ) {
        $js_path = "https://www.bugherd.com/sidebarv2.js?apikey=gl4j5scdxgwxq6btxxriqq";
        wp_enqueue_script("bugherd", $js_path, [], $js_path, false);
    }
});

//I don't know if these are still important so I've left them here
add_action("wp_enqueue_scripts", function () {
    $data = [
        "templateDirectoryUri" => get_template_directory_uri(),
    ];
    wp_localize_script("Springboard/assets", "FlyntData", $data);
});
add_action("admin_enqueue_scripts", function () {
    $data = [
        "templateDirectoryUri" => get_template_directory_uri(),
    ];
    wp_localize_script("Flynt/assets/admin", "FlyntData", $data);
});
