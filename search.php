<?php

use Timber\Timber;
use Timber\PostQuery;

$context = Timber::get_context();
$context['searchQuery'] = get_search_query();

Timber::render('templates/search.twig', $context);
