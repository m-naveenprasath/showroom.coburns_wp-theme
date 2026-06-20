<?php

namespace Flynt\Components\SiteSearch;

use Flynt\Utils\Options;

add_filter('Flynt/addComponentData?name=SiteSearch', function ($data) {
    if ($options = Options::getGlobal('SiteSearch')) {
        $data = array_merge($data, $options);
    }
    if ($labels = Options::getTranslatable('SiteSearchField')) {
        $data = array_merge($data, $labels);
    }
    if ($labels = Options::getTranslatable('SiteSearchResults')) {
        $data = array_merge($data, $labels);
    }
    if ($labels = Options::getTranslatable('BlogCards')) {
        $data = array_merge($data, $labels);
    }

    // ==========================================================
    // This should really be implemented by extending Timber/Post
    // to avoid this same logic being duplicated in multiple locations
    // https://timber.github.io/docs/guides/extending-timber/
    // ==========================================================
    $flamedrop_data = flamedrop_fetch_api_data();

    foreach ($data['posts'] as $location) {
        if (isset($location->{'flamedrop_branch_id'})) {
            $id = $location->flamedrop_branch_id;
            foreach ($flamedrop_data[$id] as $key => $value) {
                if (!empty($value)) {
                    $location->import([$key => $value], true); // 'true' overwrites WP data with Flamedrop data
                }
            }
        }
    }

    return $data;
});

Options::addGlobal(
    'Search',
    [
        [
            'label' => 'Ecommerce Prompt',
            'name' => 'searchEcommercePrompt_enabled',
            'type' => 'true_false',
            'default_value' => 0,
            'ui' => 1,
            'ui_on_text' => 'Enabled',
            'ui_off_text' => 'Disabled',
        ],
    ],
    'Search'
);

Options::addTranslatable(
    'SiteSearchField',
    [
        [
            'label' => 'Search Field',
            'name' => 'searchField',
            'type' => 'group',
            'layout' => 'table',
            'sub_fields' => [
                [
                    'label' => 'Label',
                    'name' => 'label',
                    'type' => 'text',
                    'default_value' => 'Search',
                    'required' => 1,
                    'instructions' => 'The text for the form field label. Used by screen readers.',
                ],
                [
                    'label' => 'Placeholder',
                    'name' => 'placeholder',
                    'type' => 'text',
                    'required' => 1,
                    'default_value' => 'Enter Search',
                    'instructions' => 'The text for the input field.',
                ],
                [
                    'label' => 'Button',
                    'name' => 'button',
                    'type' => 'text',
                    'default_value' => 'Search',
                    'required' => 1,
                    'instructions' => 'The text for the submit button.',
                ],
            ],
        ],
    ],
    'Search'
);

Options::addTranslatable(
    'SiteSearchResults',
    [
        [
            'label' => 'Result Page Title',
            'name' => 'searchResultsTitle',
            'type' => 'text',
            'required' => 1,
            'default_value' => 'Search',
        ],
        [
            'label' => 'Result Count',
            'name' => 'searchResultCount',
            'type' => 'group',
            'layout' => 'table',
            'sub_fields' => [
                [
                    'label' => 'Term (singular)',
                    'name' => 'termSingular',
                    'type' => 'text',
                    'required' => 1,
                    'default_value' => 'result',
                    'instructions' => 'Used for stuff like "1 <strong>thing</strong> found"',
                ],
                [
                    'label' => 'Term (plural)',
                    'name' => 'termPlural',
                    'type' => 'text',
                    'required' => 1,
                    'default_value' => 'results',
                    'instructions' => 'Used for stuff like "2 <strong>thing</strong> found"',
                ],
                [
                    'label' => 'No Results',
                    'name' => 'noResults',
                    'type' => 'text',
                    'default_value' => 'No results found.',
                    'required' => 1,
                ],
            ],
        ],
        [
            'label' => 'Ecommerce Search Prompt',
            'name' => 'searchEcommercePrompt',
            'type' => 'group',
            'layout' => 'table',
            'sub_fields' => [
                [
                    'label' => 'Sentence Start',
                    'name' => 'sentenceStart',
                    'type' => 'text',
                    'default_value' => 'Looking for products? Try a ',
                    'required' => 1,
                ],
                [
                    'label' => 'Ecommerce Prompt - Link Start',
                    'name' => 'linkStart',
                    'type' => 'text',
                    'default_value' => 'search for "',
                    'required' => 1,
                ],
                [
                    'label' => 'Search Query',
                    'name' => 'message',
                    'type' => 'message',
                    'message' => '<em>The user\'s query will appear here, <strong>bolded</strong>.</em>',
                    'required' => 1,
                ],
                [
                    'label' => 'Ecommerce Prompt - Link End',
                    'name' => 'linkEnd',
                    'type' => 'text',
                    'default_value' => '" on our online store',
                    'required' => 1,
                ],
                [
                    'label' => 'Sentence End',
                    'name' => 'sentenceEnd',
                    'type' => 'text',
                    'default_value' => '!',
                    'required' => 1,
                ],
            ],
        ],
        // [
        //     'label' => 'Pagination',
        //     'name' => 'searchPagination',
        //     'type' => 'group',
        //     'layout' => 'table',
        //     'sub_fields' => [
        //         [
        //             'label' => 'Previous Page',
        //             'name' => 'previous',
        //             'type' => 'text',
        //             'default_value' => 'Back',
        //             'required' => 1,
        //         ],
        //         [
        //             'label' => 'Next Page',
        //             'name' => 'next',
        //             'type' => 'text',
        //             'default_value' => 'Next',
        //             'required' => 1,
        //         ],
        //     ],
        // ],
    ],
    'Search'
);
