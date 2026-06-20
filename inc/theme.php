<?php

add_action('after_setup_theme', function () {
    add_theme_support( 'html5', array(
        'search-form',
        'gallery',
        'caption',
        'script',
        'style'
    ) );

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');

    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-font-sizes');
    add_theme_support('disable-custom-gradients');

    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    // add_theme_support( 'align-full' );

    // add_theme_support( 'editor-font-sizes', array(
    //     array(
    //         'name' => 'small',
    //         'shortName' => 'S',
    //         'size' => 14,
    //         'slug' => 'small'
    //     ),
    //     array(
    //         'name' => 'large',
    //         'shortName' => 'L',
    //         'size' => 18,
    //         'slug' => 'large'
    //     ),
    // ));

    remove_theme_support('core-block-patterns');

    // add_theme_support( 'editor-styles' );
    // add_editor_style( '/css/dist/min/wordpress-editor.css' );

    // Remove the admin-bar inline-CSS as it isn't compatible with the sticky footer CSS.
    // This prevents unintended scrolling on pages with few content, when logged in.
    add_theme_support('admin-bar', ['callback' => '__return_false']);
});

add_filter('big_image_size_threshold', '__return_false');
