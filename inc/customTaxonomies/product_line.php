<?php

/**
 * This is an example file showcasing how you can add custom taxonomies to your Flynt theme.
 *
 * For a full list of parameters see https://developer.wordpress.org/reference/functions/register_taxonomy/ or use https://generatewp.com/taxonomy/ to generate the code for you.
 */

namespace Flynt\CustomTaxonomies;
function registerProductLine()
{
    $labels = [
        'name'                       => _x('Product Lines', 'Taxonomy General Name', 'flynt'),
        'singular_name'              => _x('Product Line', 'Taxonomy Singular Name', 'flynt'),
        'menu_name'                  => __('Product Lines', 'flynt'),
        'all_items'                  => __('All Product Lines', 'flynt'),
        'parent_item'                => __('Parent Product Line', 'flynt'),
        'parent_item_colon'          => __('Parent Product Line:', 'flynt'),
        'new_item_name'              => __('New Product Line Name', 'flynt'),
        'add_new_item'               => __('Add New Product Line', 'flynt'),
        'edit_item'                  => __('Edit Product Line', 'flynt'),
        'update_item'                => __('Update Product Line', 'flynt'),
        'view_item'                  => __('View Product Line', 'flynt'),
        'separate_items_with_commas' => __('Separate product lines with commas', 'flynt'),
        'add_or_remove_items'        => __('Add or remove product lines', 'flynt'),
        'choose_from_most_used'      => __('Choose from the most used product lines', 'flynt'),
        'popular_items'              => __('Popular Product Lines', 'flynt'),
        'search_items'               => __('Search Product Lines', 'flynt'),
        'not_found'                  => __('Not Found', 'flynt'),
        'no_terms'                   => __('No items', 'flynt'),
        'items_list'                 => __('Items list', 'flynt'),
        'items_list_navigation'      => __('Items list navigation', 'flynt'),
    ];
    $args = [
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    ];

    register_taxonomy('product_line', ['brands'], $args);
}

add_action('init', 'Flynt\\CustomTaxonomies\\registerProductLine');

