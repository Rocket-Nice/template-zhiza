<?php
/**
 * @var $args
 */
$queryArg = array(
    'post_type'      => 'post',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'posts_per_page' => 30,
    'post__not_in'   => [get_the_ID()],
);

query_posts( $queryArg );

$nextPagePosts = [];

while ( have_posts() ) {
    the_post();

    $nextPagePosts[] = [
        'image' => wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' )[0],
        'title' => get_the_title(),
        'url'   => get_permalink() . '?amp',
    ];
}
wp_reset_query();

try {
    echo json_encode( $nextPagePosts, JSON_THROW_ON_ERROR );
} catch ( JsonException $e ) {
    error_log('Trouble encode AmpNextPage post array.');
}
