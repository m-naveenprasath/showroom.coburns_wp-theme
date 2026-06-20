<?php

namespace Flynt\CustomPostTypes;

use ACFComposer\ACFComposer;
use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_action('init', '\\Flynt\\CustomPostTypes\\registerStylesPostType');

function registerStylesPostType()
{
    $slug = 'style';
    $post_type = $slug;

    $name_singular = 'Style';
    $name_plural = $name_singular . 's';
    $description = '';

    $icon = 'dashicons-admin-multisite';
    $menu_position = 3;

    $taxonomies = '';

    $labels = [
        'add_new_item' => __('Add New ' . $name_singular, 'sb'),
        'add_new' => __('Add New', 'sb'),
        'all_items' => __('All ' . $name_plural, 'sb'),
        'archives' => __($name_singular . ' archives', 'sb'),
        'attributes' => __($name_plural . ' attributes', 'sb'),
        'edit_item' => __('Edit ' . $name_singular, 'sb'),
        'featured_image' => __('Featured image for this ' . $name_singular, 'sb'),
        'filter_items_list' => __('Filter ' . $name_plural . ' list', 'sb'),
        'insert_into_item' => __('Insert into ' . $name_singular, 'sb'),
        'item_published_privately' => __($name_singular . ' published privately.', 'sb'),
        'item_published' => __($name_singular . ' published', 'sb'),
        'item_reverted_to_draft' => __($name_singular . ' reverted to draft.', 'sb'),
        'item_scheduled' => __($name_singular . ' scheduled', 'sb'),
        'item_updated' => __($name_singular . ' updated.', 'sb'),
        'items_list_navigation' => __($name_plural . ' list navigation', 'sb'),
        'items_list' => __($name_plural . ' list', 'sb'),
        'menu_name' => __($name_plural, 'sb'),
        'name' => __($name_plural, 'sb'),
        'name_admin_bar' => __($name_singular, 'sb'),
        'new_item' => __('New ' . $name_singular, 'sb'),
        'not_found_in_trash' => __('No ' . $name_plural . ' found in Trash.', 'sb'),
        'not_found' => __('No ' . $name_plural . ' found.', 'sb'),
        'parent_item_colon' => __('Parent ' . $name_singular . ':', 'sb'),
        'remove_featured_image' => __('Remove featured image for this ' . $name_singular, 'sb'),
        'search_items' => __('Search ' . $name_plural, 'sb'),
        'set_featured_image' => __('Set featured image for this ' . $name_singular, 'sb'),
        'singular_name' => __($name_singular, 'sb'),
        'uploaded_to_this_item' => __('Upload to this ' . $name_singular, 'sb'),
        'use_featured_image' => __('Use as featured image for this ' . $name_singular, 'sb'),
        'view_item' => __('View ' . $name_singular, 'sb'),
        'view_items' => __('View ' . $name_plural, 'sb'),
    ];

    $args = [
        'label' => __($name_plural, 'sb'),
        'labels' => $labels,
        'description' => __($description, 'sb'),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'delete_with_user' => false,
        'show_in_rest' => true,
        'rest_base' => $post_type,
        'has_archive' => true,
        'rewrite' => ['slug' => $slug, 'with_front' => false],
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'exclude_from_search' => false,
        'capability_type' => 'page',
        'map_meta_cap' => true,
        'hierarchical' => false,
        'query_var' => true,
        'menu_icon' => $icon,
        'menu_position' => 21,
        'supports' => ['title', 'thumbnail', 'revisions', 'custom-fields', 'excerpt'],
    ];

    register_post_type($post_type, $args);
}

add_action('acf/init', '\\Flynt\\CustomPostTypes\\registerStylesCustomFields');

function registerStylesCustomFields()
{
    $slug = 'style';
    $post_type = $slug;

    Options::addTranslatable(
        'StyleLabels',
        [
            FieldVariables\getTab('Hero'),
            [
                'label' => 'Eyebrow',
                'name' => 'eyebrow_label',
                'type' => 'text',
                'default_value' => 'Style Overview',
            ],
            [
                'label' => 'Share Label',
                'name' => 'social_media_share_label',
                'type' => 'text',
                'default_value' => 'Share',
            ],
            [
                'label' => 'Carousel Heading',
                'name' => 'carouselHeading_default',
                'type' => 'text',
                'default_value' => 'Rooms to Inspire',
            ],
            FieldVariables\getTab('Section Headings'),
            [
                'name' => 'featured_products_label',
                'label' => 'Featured Products Label',
                'type' => 'text',
                'default_value' => 'Featured Products',
            ],
            [
                'name' => 'featured_brands_label',
                'label' => 'Featured Brands Label',
                'type' => 'text',
                'default_value' => 'Featured Brands',
            ],
            [
                'name' => 'other_styles_label',
                'label' => 'Other Styles Label',
                'type' => 'text',
                'default_value' => 'Other Styles',
            ],
        ],
        'Styles'
    );

    ACFComposer::registerFieldGroup([
        'name' => 'style_hero_group',
        'title' => 'Style Hero',
        'fields' => [
            [
                'label' => '',
                'name' => 'hero',
                'type' => 'group',
                'sub_fields' => [
                    FieldVariables\getTab('Content'),
                    FieldVariables\getHeadingLoop(
                        $instructions =
                            '<strong>Defaults</strong><br/>tag: h1, style: minimal 1<br/>tag: div, style: display 1'
                    ),
                    FieldVariables\getSectionContent_1(),
                    FieldVariables\getButtonLoop($limit = 1),
                    FieldVariables\getTab('Carousel'),
                    [
                        'label' => 'Carousel Heading',
                        'name' => 'carouselHeading',
                        'type' => 'group',
                        'layout' => 'table',
                        'instructions' => '<strong>Defaults</strong>: tag: h2',
                        'sub_fields' => [
                            FieldVariables\getHeadingParts($required = false, $included_fields = ['tag', 'text']),
                        ],
                    ],
                    FieldVariables\getCarousel(),
                    FieldVariables\getTab('Sharing'),
                    FieldVariables\getShareWithToggle($default_visibility = true),
                    FieldVariables\getShareWithAccounts($default_visibility = true),
                    // FieldVariables\getShareWithTwitter(),
                    FieldVariables\getTab('Options'),
                    FieldVariables\getSectionBackgroundSelect(),
                    FieldVariables\getFeaturedImageToggle(),
                    // FieldVariables\getBreadcrumbToggle(),
                ],
            ],
        ],
        'menu_order' => 9,
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => $post_type,
                ],
            ],
        ],
    ]);

    ACFComposer::registerFieldGroup([
        'name' => 'style_brand_group',
        'title' => 'Style Brands',
        'fields' => [
            [
                'label' => 'Brands',
                'name' => 'brands',
                'post_type' => ['brands'],
                'type' => 'relationship',
                'filters' => ['search'],
                'return_format' => 'id',
            ],
        ],
        'menu_order' => 9999,
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => $post_type,
                ],
            ],
        ],
    ]);
}
