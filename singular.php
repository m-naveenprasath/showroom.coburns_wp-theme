<?php

use Timber\Timber;
use Timber\Post;
use Timber\PostQuery;
use Flynt\Utils\Options;

$context = Timber::get_context();
$context['post'] = new Post();
$context['archive_link'] = get_post_type_archive_link($post->post_type);

$parents = array();
switch ($post->post_type) {
    case 'post':
        $parents[] = get_option( 'page_for_posts' );
        break;
    case 'brands':
        $brandsOptions = Options::getGlobal('BrandsOptions');
        if (isset($brandsOptions['brands_page_for_posts'])) {
            $parents[] =  (int) url_to_postid( $brandsOptions['brands_page_for_posts'] );
        }
        break;
    case 'locations':
    case 'style':
        if ( $post_type_archive_link = get_post_type_archive_link($post->post_type) ){
            $parents[] = (int) url_to_postid( $post_type_archive_link );
        }
        break;
    default:
        $parents = array_merge( $parents, array_reverse(get_post_ancestors($post->id)) );
}
if ( !empty($parents) ) {
    // Only add "home" to breadcrumb object if there is going to be more than just "home"
    array_unshift( $parents, (int) get_option( 'page_on_front' ) );

    $context['parent_posts'] = new PostQuery( $parents );
}

Timber::render( array(
    'templates/single-' . $post->post_type . '.twig',
    'templates/single.twig'
), $context );

