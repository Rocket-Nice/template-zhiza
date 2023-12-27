<?php
/**
 * @var $args
 * @var $args['i']
 */
global $wp_query;
global $post;
//
$postWithImage = [6, 9, 15, 20];
$i = $args['i'];
//
$category = get_the_category(get_the_ID())[0];
$shortTitle = get_field( 'short_title' );
$title = !empty($shortTitle) ? $shortTitle : get_the_title();
?>

<div class="grid-item collection-card">
    <div class="relative-position">
        <?php if ( in_array( $i, $postWithImage, true ) ):
            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'collection-image');?>
            <div class="img-container">
                <img src="<?= $thumbnail[0] ?>"
                     width="240" height="146"
                     decoding="async" loading="lazy"
                     alt="<?= $title ?>" />
            </div>
        <?php endif; ?>
        <div class="card-body">
            <a class="title" href="<?php the_permalink(get_the_ID()); ?>" data-link>
                <?= $title ?>
            </a>
            <div class="post-info">
                <a href="<?= get_category_link($category->term_id) ?>" class="post-category"><?= $category->name ?></a>
                <span class="post-publish"><?= get_the_date('j F Y') ?></span>
            </div>
        </div>
    </div>
</div>
