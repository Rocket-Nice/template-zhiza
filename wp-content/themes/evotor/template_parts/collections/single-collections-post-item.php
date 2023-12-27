<?php
/**
 * @var $args['position'] - номер поста в сетке.
 * @var $args['number'] - порядковый номер чанка. Если не первый и последующий чанки, то проставляем им ленивую загрузку.
 */

$listOfPCItems = [1, 4];
$listOfMobileItems = [4, 5, 6, 7];
//
$pcSize = in_array($args['position'], $listOfPCItems, true)
    ? get_the_post_thumbnail_url($post, 'medium_large')
    : get_the_post_thumbnail_url($post, 'main_post_small_preview');

$mobileSize = in_array( $args['position'], $listOfMobileItems, true )
    ? get_the_post_thumbnail_url($post, 'main_post_small_preview_mobile')
    : get_the_post_thumbnail_url($post, 'main-post-preview-mobile');
//
$category = get_the_category( $post );
?>

<div class="once">
    <div class="img_block">
        <a href="<?= get_the_permalink( $post ) ?>">
            <img src="<?= $pcSize ?>"
                 alt="<?= get_the_title( $post ) ?>"
                 title="<?= get_the_title( $post ) ?>"
                 <?php if (in_array($args['position'], $listOfPCItems, true)): ?>
                     width="691" height="358"
                 <?php else: ?>
                     width="285" height="230"
                 <?php endif; ?>
                 <?= ($args['number'] === 0 && $args['position'] < 4 ) ? '' : 'loading="lazy"' ?>
                 decoding="async"
                 srcset="<?= $pcSize ?> 1920w,
                         <?= $mobileSize ?> 1199w"
            />
        </a>
    </div>
    <div class="desc_block">
        <div class="cat_date_block">
            <div class="category">
                <?= $category[0]->cat_name ?>
            </div>
            <div class="date">
                <?= get_the_date( 'j F', $post ) ?>
            </div>
        </div>
        <div class="vis_block">
            <div class="box">
                <a href="<?= get_the_permalink( $post ) ?>" class="title" title="<?= get_the_title( $post ) ?>">
                    <?= get_the_title( $post ) ?>
                </a>
                <div class="excerpt">
                    <?= getPostExcerpt( $post ); ?>
                </div>
                <div class="bot_info">
                    <?= $category[0]->cat_name . '·' . get_the_date( 'j F', $post ) ?>
                </div>
            </div>
        </div>
    </div>
</div>
