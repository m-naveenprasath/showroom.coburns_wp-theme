<?php

namespace Flynt\Components\SiteHeader;

use Timber;
use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_action('init', function () {
    register_nav_menus([
        'nav_header_primary' => __('Header Menu: Primary', 'flynt'),
        'nav_header_utility' => __('Header Menu: Utility', 'flynt'),
        'nav_header_mega' => __('Header Menu: Mega', 'flynt'),
        'nav_header_ecommerce' => __('Header Menu: Ecommerce', 'flynt'),
        'nav_header_mobile' => __('Header Menu: Mobile', 'flynt'),
    ]);
});

add_action('wp_enqueue_scripts', function () {
    $options = Options::getGlobal('SiteHeader');
    if ($options['EcommerceNav_show'] == false) {
        return false;
    }

    $componentNamespace = explode('\\', __NAMESPACE__);
    $componentName = array_pop($componentNamespace);

    $js_path = 'https://minicart.coburns.com/dist/wp/AcCart.umd.min.js';
    wp_register_script('minicart', $js_path, ['vue'], [], true);

    $js_path = '/Components/' . $componentName . '/script.js';
    wp_register_script(
        $componentName,
        get_stylesheet_directory_uri() . $js_path,
        ['minicart'],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );
});

add_filter(
    'Flynt/renderComponent',
    function ($output, $componentName) {
        wp_enqueue_script($componentName);

        return $output;
    },
    10,
    3
);

Options::addGlobal('SiteHeader', [
    [
        'label' => 'Ecommerce Utility Nav',
        'name' => 'EcommerceNav_show',
        'type' => 'true_false',
        'default_value' => true,
        'ui' => 1,
        'ui_on_text' => 'Show',
        'ui_off_text' => 'Hide',
    ],
    [
        'label' => 'Ecommerce Login Link',
        'name' => 'ecommerce_login_link',
        'type' => 'url',
    ],
    [
        'label' => 'Search Field',
        'name' => 'HeaderSearch_show',
        'type' => 'true_false',
        'default_value' => true,
        'ui' => 1,
        'ui_on_text' => 'Show',
        'ui_off_text' => 'Hide',
    ],
    [
        'label' => 'Mobile Header Icons',
        'name' => 'mobileHeaderLinks',
        'type' => 'repeater',
        'instructions' => 'Icon links shown in the blue bar under the logo on mobile. Leave empty to use Find Your Style, Find A Location, Coburns.com, About and Contact Us.',
        'max' => 6,
        'layout' => 'table',
        'button_label' => 'Add Icon',
        'sub_fields' => [
            [
                'label' => 'Icon',
                'name' => 'mobile_header_icon',
                'type' => 'select',
                'required' => 1,
                'choices' => [
                    'style' => 'Find Your Style',
                    'location' => 'Find A Location',
                    'shop' => 'Coburns.com',
                    'about' => 'About',
                    'contact' => 'Contact Us',
                    'upload' => 'Upload My Own',
                ],
            ],
            [
                'label' => 'Icon Upload',
                'name' => 'mobile_header_icon_upload',
                'type' => 'image',
                'preview_size' => 'thumbnail',
                'conditional_logic' => [
                    [
                        [
                            'fieldPath' => 'mobile_header_icon',
                            'operator' => '==',
                            'value' => 'upload',
                        ],
                    ],
                ],
            ],
            [
                'label' => 'Link',
                'name' => 'mobile_header_link',
                'type' => 'link',
                'required' => 1,
                'return_format' => 'array',
            ],
        ],
    ],
]);

add_filter('Flynt/addComponentData?name=SiteHeader', function ($data) {
    if (has_nav_menu('nav_header_primary')) {
        $data['nav_primary'] = new Timber\Menu('nav_header_primary');
        $data['mega_panels'] = getMegaPanels($data['nav_primary']);
    }
    if (has_nav_menu('nav_header_utility')) {
        $data['nav_utility'] = new Timber\Menu('nav_header_utility');
    }
    if (has_nav_menu('nav_header_mega')) {
        $data['nav_mega'] = new Timber\Menu('nav_header_mega');
    }
    if (has_nav_menu('nav_header_ecommerce')) {
        $data['nav_ecommerce'] = new Timber\Menu('nav_header_ecommerce');
    }
    if (has_nav_menu('nav_header_mobile')) {
        $data['nav_mobile'] = new Timber\Menu('nav_header_mobile');
    }

    //
    if ($options = Options::getGlobal('SiteHeader')) {
        $data = array_merge($data, $options);
    }
    if ($labels = Options::getTranslatable('SiteHeader')) {
        $data = array_merge($data, $labels);
    }
    if ($labels = Options::getTranslatable('SiteSearchField')) {
        $data = array_merge($data, $labels);
    }
    if ($labels = Options::getTranslatable('MobileNav')) {
        $data = array_merge($data, $labels);
    }

    $data['mobile_header_links'] = getMobileHeaderLinks($data['mobileHeaderLinks'] ?? []);
    $data['mobile_drawer'] = getMobileDrawerItems($data['mega_panels'] ?? []);

    return $data;
});

const MOBILE_HEADER_ICONS = [
    'style' => 'ankle-style',
    'location' => 'mobile-location',
    'shop' => 'external',
    'about' => 'mobile-about',
    'contact' => 'ankle-email',
];

/**
 * Icon links for the mobile header bar. Falls back to the default set when none are configured.
 */
function getMobileHeaderLinks($rows)
{
    if (empty($rows)) {
        return [
            ['icon' => 'ankle-style', 'title' => 'Find Your Style', 'url' => getPageUrl('style-finder')],
            ['icon' => 'mobile-location', 'title' => 'Find A Location', 'url' => getPageUrl('locations')],
            ['icon' => 'external', 'title' => 'Coburns.com', 'url' => 'https://www.coburns.com/', 'target' => '_blank'],
            ['icon' => 'mobile-about', 'title' => 'About', 'url' => getPageUrl('about')],
            ['icon' => 'ankle-email', 'title' => 'Contact Us', 'url' => getPageUrl('contact')],
        ];
    }

    $links = [];
    foreach ($rows as $row) {
        $link = $row['mobile_header_link'] ?? null;
        if (empty($link['url'])) {
            continue;
        }

        $key = $row['mobile_header_icon'] ?? '';
        $links[] = [
            'icon' => MOBILE_HEADER_ICONS[$key] ?? null,
            'icon_id' => $key === 'upload' ? getImageId($row['mobile_header_icon_upload'] ?? null) : null,
            'title' => $link['title'] ?? '',
            'url' => $link['url'],
            'target' => $link['target'] ?? '',
        ];
    }

    return $links;
}

/**
 * Items for the mobile hamburger drawer. "Find Your Style" reuses the desktop mega menu tabs,
 * giving three clickable layers: Find Your Style > By Style / By Brand / By Space > each entry.
 */
function getMobileDrawerItems($megaPanels)
{
    $styleChildren = [];
    foreach (reset($megaPanels) ?: [] as $tab) {
        $styleChildren[] = [
            'title' => $tab['title'],
            'url' => $tab['link'],
            'children' => array_map(function ($entry) {
                return ['title' => $entry['title'], 'url' => $entry['link']];
            }, $tab['items']),
        ];
    }

    return [
        ['icon' => 'ankle-style', 'title' => 'Find Your Style', 'url' => getPageUrl('style-finder'), 'children' => $styleChildren],
        ['icon' => 'mobile-location', 'title' => 'Find Your Location', 'url' => getPageUrl('locations')],
        ['icon' => 'mobile-brands', 'title' => 'Our Brands', 'url' => getPageUrl('our-brands')],
        ['icon' => 'mobile-about', 'title' => 'About', 'url' => getPageUrl('about')],
        ['icon' => 'ankle-email', 'title' => 'Contact Us', 'url' => getPageUrl('contact')],
        ['icon' => 'external', 'title' => 'Coburns.com', 'url' => 'https://coburns.com', 'target' => '_blank'],
        ['icon' => 'mobile-blog', 'title' => 'Blogs', 'url' => getPageUrl('blog')],
    ];
}

function getPageUrl($path)
{
    $page = get_page_by_path($path);
    return $page ? get_permalink($page) : home_url('/' . $path . '/');
}

/**
 * Build the "Find Your Style" mega menu panels, keyed by menu item ID.
 * Each child link of a flagged menu item becomes a tab (By Style / By Brand / By Space).
 */
function getMegaPanels($menu)
{
    $panels = [];

    foreach ($menu->get_items() as $item) {
        $mode = (string) $item->meta('mega_menu');
        if ($mode === 'none' || empty($item->children)) {
            continue;
        }

        $tabs = [];
        foreach ($item->children as $child) {
            $objectId = (int) get_post_meta($child->ID, '_menu_item_object_id', true);
            $slug = get_post_meta($child->ID, '_menu_item_object', true) === 'page' ? get_post_field('post_name', $objectId) : '';
            $haystack = strtolower($slug . ' ' . $child->title());

            if (strpos($haystack, 'style') !== false) {
                $tab = ['type' => 'style', 'items' => getMegaStyles()];
            } elseif (strpos($haystack, 'brand') !== false) {
                $tab = ['type' => 'brand', 'items' => getMegaBrands()];
            } elseif (strpos($haystack, 'space') !== false) {
                $tab = ['type' => 'space', 'items' => getMegaSpaces($objectId)];
            } else {
                continue;
            }

            $tabs[] = $tab + [
                'id' => $child->ID,
                'title' => $child->title(),
                'link' => $child->link(),
            ];
        }

        // Auto mode needs at least two matching child links so ordinary dropdowns stay untouched
        if ($tabs && ($mode === 'find_your_style' || count($tabs) >= 2)) {
            $panels[$item->ID] = $tabs;
        }
    }

    return $panels;
}

function getMegaStyles()
{
    $posts = get_posts([
        'post_type' => 'style',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC'],
    ]);

    return array_map(function ($post) {
        $images = [];
        $hero = get_field('hero', $post->ID);
        foreach ($hero['carousel'] ?? [] as $slide) {
            if ($id = getImageId($slide['image'] ?? null)) {
                $images[] = $id;
            }
        }
        if (count($images) < 3 && has_post_thumbnail($post)) {
            array_unshift($images, get_post_thumbnail_id($post));
        }

        return [
            'title' => get_the_title($post),
            'link' => get_permalink($post),
            'text' => get_the_excerpt($post),
            'images' => array_slice(array_unique($images), 0, 3),
        ];
    }, $posts);
}

function getMegaBrands()
{
    $posts = get_posts([
        'post_type' => 'brands',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'category_name' => 'Featured',
        'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC'],
    ]);

    return array_map(function ($post) {
        $images = array_values(array_filter([
            getImageId(get_field('image1', $post->ID)) ?: get_post_thumbnail_id($post),
            getImageId(get_field('image2', $post->ID)),
            getImageId(get_field('image3', $post->ID)),
        ]));

        return [
            'title' => get_the_title($post),
            'link' => get_permalink($post),
            'text' => wp_trim_words(wp_strip_all_tags((string) get_field('sectionHtml_1', $post->ID)), 22),
            'logo' => getImageId(get_field('logo', $post->ID)),
            'images' => $images,
        ];
    }, $posts);
}

function getMegaSpaces($parentId)
{
    if (!$parentId) {
        return [];
    }

    $posts = get_posts([
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_parent' => $parentId,
        'posts_per_page' => -1,
        'orderby' => ['menu_order' => 'ASC', 'date' => 'ASC'],
    ]);

    return array_map(function ($post) {
        return [
            'title' => get_the_title($post),
            'link' => get_permalink($post),
            'image' => get_post_thumbnail_id($post),
        ];
    }, $posts);
}

// ACF image fields may come back as an ID, an array or a Timber\Image depending on filters
function getImageId($image)
{
    if (is_object($image)) {
        return (int) $image->ID;
    }
    if (is_array($image)) {
        return (int) ($image['ID'] ?? $image['id'] ?? 0);
    }
    return (int) $image;
}
