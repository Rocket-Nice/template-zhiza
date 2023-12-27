<?php
global $post;
$thumbNoImage = '/wp-content/themes/evotor/assets/images/post_placeholder.jpg';
$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'collection-image');
$image = !empty($thumbnail) ? $thumbnail[0] : $thumbNoImage;
$title = $post->post_highlighted_title;
//
$category = get_the_category(get_the_ID())[0];
?>
<div class="search-result-item">
    <a href="<?php the_permalink(get_the_ID()); ?>" class="img" title="<?= $title ?>">
        <img src="<?= $image ?>" alt="<?= $title ?>" loading="lazy" decoding="async"
             width="239" height="140" title="<?= $title ?>"
         />
    </a>
    <div class="text">
        <a href="<?php the_permalink(get_the_ID()); ?>" class="post-title" title="<?= $title ?>">
            <?= $title ?>
        </a>
        <div class="excerpt">
            <?php relevanssi_the_excerpt(); ?>
        </div>
        <div class="info">
            <a href="<?= "/category/{$category->slug}/" ?>" class="category"><?= $category->name ?></a>
            <div class="square"></div>
            <span class="date"><?= get_the_date('j F Y') ?></span>
        </div>
    </div>
</div>
