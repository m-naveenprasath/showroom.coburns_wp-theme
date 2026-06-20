<?php

use Timber\Timber;
use Timber\Post;
use Flynt\Utils\Options;

$context = Timber::get_context();
$context['post'] = new Post();

Timber::render( array(
    'templates/single-' . $post->post_type . '.twig',
    'templates/single.twig'
), $context );

