<?php
/**
 * @var $args['position'] - номер поста в сетке.
 */

$listOfPCItems = [1, 5, 6, 7, 10]; // 691 х 322
$listOfMobileItems = [3, 4, 5, 6, 9, 10, 12, 13]; // 165 x 113
global $post;

$pcSize = in_array( $args['position'], $listOfPCItems, true )
    ? get_the_post_thumbnail_url($post, 'medium_large')
    : get_the_post_thumbnail_url($post, 'main_post_small_preview');

$mobileSize = in_array( $args['position'], $listOfMobileItems, true )
    ? get_the_post_thumbnail_url($post, 'main_post_small_preview_mobile')
    : get_the_post_thumbnail_url($post, 'main-post-preview-mobile');
?>

<div class="once">
    <div class="img_block">
        <a href="<?php the_permalink(); ?>">
            <img src="<?= $pcSize ?>"
                 alt="<?= the_title() ?>"
                 title="<?= the_title() ?>"
                 width="285" height="250"
                 <?= in_array( $args['position'], [ 1, 2 ], true ) ? '' : 'loading="lazy"' ?>
                 decoding="async"
                 srcset="<?= $pcSize ?> 1920w,
                         <?= $mobileSize ?> 1199w"
            />
        </a>
    </div>
    <div class="desc_block">
        <div class="date">
            <?= get_the_date( 'j F', get_post( get_the_ID() ) ) ?>
        </div>
        <a href="<?php the_permalink(); ?>" class="title" title="<?= the_title() ?>">
            <?= the_title() ?>
        </a>
        <div class="excerpt">
            <?= getPostExcerpt( get_the_ID() ) ?>
        </div>
    </div>
</div>
