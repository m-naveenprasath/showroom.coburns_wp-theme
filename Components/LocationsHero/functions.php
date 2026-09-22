<?php

namespace Flynt\Components\LocationsHero;

use Timber\Post;
use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=LocationsHero', function ($data) {
    $post_id = get_the_ID();

    $data['hero_subtitle'] = get_field('hero_subtitle', $post_id);
    $data['location_hero_intro'] = get_field('location_hero_intro', $post_id);
    $data['buttons'] = get_field('buttons', $post_id);
    $data['image_2'] = get_field('image_2', $post_id);
    $data['image_3'] = get_field('image_3', $post_id);
    $data['featuredImage_show'] = get_field('featuredImage_show', $post_id);
    $data['virtual_tour_link'] = get_field('virtual_tour_link', $post_id);

    // Quick-glance info card fields (Address, Phone, Showroom Hours, Open Since,
    // Showroom Manager). Each is its own field so locations without Flamedrop data
    // can still be filled in individually. Fields are named with a hero_ prefix
    // to avoid colliding with postmeta left over from older, retired field groups
    // that used the bare names (e.g. a former google_map "address" field, which
    // stores an array and crashes ACF's plain text/textarea renderer if reused).
    $data['address'] = get_field('hero_address', $post_id);
    $data['phone'] = get_field('hero_phone', $post_id);
    $data['hours'] = get_field('hero_hours', $post_id);
    $data['year_opened'] = get_field('hero_year_opened', $post_id);
    $data['manager'] = get_field('hero_manager', $post_id);

    if ($options = Options::getTranslatable('LocationLabels')) {
        $data = array_merge($data, $options);
    }
    if ($options = Options::getTranslatable('LocationDefaults')) {
        $data = array_merge($data, $options);
    }

    // Flamedrop is metadata (a branch ID used to pull live data from an
    // external API), not a page section — it lives in its own always-on
    // field group regardless of where Hero's other fields live.
    $flamedrop_branch_id = get_field('flamedrop_branch_id', $post_id);
    $data['flamedrop_branch_id'] = $flamedrop_branch_id;
    $data['flamedrop_id'] = get_field('flamedrop_id', $post_id);

    if (!empty($flamedrop_branch_id)) {
        $flamedrop_data = flamedrop_fetch_api_data();
        if (!empty($flamedrop_data[$flamedrop_branch_id])) {
            // The info card (address, phone, hours, year_opened, manager) is
            // manual-only: it shows the hero_* ACF value if the editor set one,
            // and stays blank otherwise. Flamedrop's API happens to use the same
            // bare key names for some of these (e.g. "address", "phone",
            // "manager"), so it's explicitly excluded here rather than allowed
            // to fill in the blanks.
            $info_card_keys = ['address', 'phone', 'hours', 'year_opened', 'manager'];
            foreach ($flamedrop_data[$flamedrop_branch_id] as $key => $value) {
                if (!empty($value) && !in_array($key, $info_card_keys, true)) {
                    $data[$key] = $value;
                }
            }
        }
    }

    return $data;
});
