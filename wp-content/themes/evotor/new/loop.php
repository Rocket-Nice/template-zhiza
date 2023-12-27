<?php
/**
 * Используется для вывода на кастомной странице подборок в админке.
 */
?>

<article class="card" data-post-id="<?= $post->ID ?>">
    <?php if ( has_post_thumbnail( $post ) ): ?>
        <?php if ( get_field( 'main_thumb_img', $post ) ) { ?>
            <?php $top_bg_url = wp_get_attachment_image_src( get_field( 'main_thumb_img', $post ), 'blog-full', true ); ?>
            <div class="card__media" style="background-image: url(<?php echo $top_bg_url[0] ?>">
                <img src="<?php echo $top_bg_url[0] ?>" alt="" style="max-height: 450px;" loading='lazy'>
            </div>
        <?php } else { ?>
            <div class="card__media"
                 style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID ); ?>">
                <?php $thumb = get_the_post_thumbnail( $post->ID, 'blog-full', array( 'alt' => $post->post_title ) );
                $thumb       = apply_filters( 'bj_lazy_load_html', $thumb, 10 ); ?>
                <?php echo $thumb; ?>
            </div>
        <?php } ?>


    <?php elseif ( get_post_meta( $post->ID, 'show_video', true ) ): ?>
        <div class="card__media card__media-video">
            <div class="youtube" data-embed="<?= parse_youtube( get_post_meta( $post->ID, 'video_link', true ) ) ?>">
                <div class="play-button"></div>
            </div>
        </div>
    <?php else: ?>
        <div class="card__featured"></div>
    <?php endif; ?>

    <div class="card__info">
        <div class="card__title">
            <a href="<?= get_the_permalink( $post ) ?>">
                <?= $post->post_title ?>
            </a>
        </div>

        <p><?php echo getPostExcerpt( $post->ID ); ?></p>
    </div>
</article>
