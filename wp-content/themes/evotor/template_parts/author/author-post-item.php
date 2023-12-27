<?php
/**
 * @var $args
 */
global $post;
$thumbNoImage = '/wp-content/themes/evotor/assets/images/post_placeholder.jpg';
$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'collection-image');
$image = !empty($thumbnail) ? $thumbnail[0] : $thumbNoImage;
//
$title = $post->post_title;
//
$category = get_the_category(get_the_ID())[0];
?>

<li class="post--list__item">
    <a href="<?php the_permalink(get_the_ID()); ?>" class="img" title="<?= $title ?>">
        <img src="<?= $image ?>" alt="<?= $title ?>" loading="lazy"
             decoding="async" width="239" height="146" title="<?= $title ?>"
        />
    </a>
    <div class="text">
        <a href="<?php the_permalink(get_the_ID()); ?>" class="title" title="<?= $title ?>">
            <?= $title ?>
        </a>
        <div class="info">
            <span class="category"><?= $category->name ?></span>
            <div class="square"></div>
            <span class="date"><?= get_the_date('j F Y') ?></span>
        </div>
    </div>
</li>
