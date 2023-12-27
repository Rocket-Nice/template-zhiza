<?php
/**
 * @var $post
 * @var $wp_query
 * @var $args['postCount']
 */
global $post;
global $wp_query;
//
$postCount = $args['postCount'];
$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'other-collections-image');
?>

<div class="slider-item">
    <a href="<?php the_permalink(); ?>" class="img-wrapper" title="Подборка: <?= the_title() ?>">
        <img src="<?= $thumbnail[0] ?>"
             alt="" decoding="async"
             width="328" height="192"
             title="Подборка: <?= the_title() ?>"
             loading="lazy"
        />
    </a>
    <div class="slider-content">
        <a href="<?php the_permalink(); ?>" class="title">
            <?= the_title() ?>
        </a>
        <div class="description">
            <p>
                <?php the_content(); ?>
            </p>
            <a href="<?php the_permalink(); ?>" title="Подборка: <?= the_title() ?>">
                <span><?php echo $postCount . ' ' . post_count_text( $postCount ) ?></span>
                <img src="/wp-content/themes/evotor/assets/images/orange_right_arrow.svg"
                     alt="Подборка: <?= the_title() ?>"
                     width="40" height="5"
                     title="Подборка: <?= the_title() ?>"
                     loading="lazy" decoding="async"
                />
            </a>
        </div>
    </div>
</div>
