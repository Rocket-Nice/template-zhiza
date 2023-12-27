<?php
$thumbnail_id          = get_post_thumbnail_id();
$alt                   = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
$thumbSrc              = wp_get_attachment_image_src( $thumbnail_id, 'preview-newest-post' );
$main_thumb_url_mobile = wp_get_attachment_image_src( $thumbnail_id, 'main_post_small_preview' );

$pcImage = null;
$width   = 0;
$height  = 0;
if ( $thumbSrc ) {
    [ $pcImage, $width, $height ] = $thumbSrc;
}
?>

<div class="post__image-wrapper">
    <img src="<?= $pcImage ?>"
         alt="<?= $alt ?>"
         title="<?= $alt ?>"
         width="<?= $width ?>"
         height="<?= $height ?>"
         class="post__image-preview"
    />
</div>

<div class="text-info__wrapper">
    <div class="post-meta orange text-info__meta">
        <a href="/category/theory/" class="category">
            <?php foreach ( get_the_category( get_the_ID() ) as $category ) {
                echo $category->cat_name;
            } ?>
        </a>
        <p class="date">
            <?= get_the_date( 'j F Y' ) ?>
        </p>
    </div>

    <h1 class="text-info__h1">
        <?= get_the_title() ?>
    </h1>

    <?php if ( get_field( 'subheadline' ) ) { ?>
        <div class="text-info__short-description">
            <?php the_field( 'subheadline' ) ?>
        </div>
    <?php } ?>

    <?php get_template_part('template_parts/single/blockTypes/simpleBlock/postAuthors') ?>
</div>
