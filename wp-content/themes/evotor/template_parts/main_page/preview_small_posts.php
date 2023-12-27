<?php
/**
 * @var $post
 * @var $args
 */
$category = $args['category'];
$canonicalPostName = $args['canonicalPostName'];
//
$mainPostPreviewThumbnailUrl = get_the_post_thumbnail_url($post, 'main_post_small_preview');
$mainPostPreviewThumbnailUrl__mobile = get_the_post_thumbnail_url($post, 'main_post_small_preview_mobile');
?>

<div class="once">
    <div class="img_block">
        <a href="<?= get_the_permalink( $post ) ?>"
           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>', 'eventLabel': '<?php the_title(); ?>',});"
        >
            <img src="<?= $mainPostPreviewThumbnailUrl ?>"
                 alt="<?= $post->post_title ?>"
                 title="<?= $post->post_title ?>"
                 width="323" height="230"
                 decoding="async"
                 srcset="<?= $mainPostPreviewThumbnailUrl ?> 1920w,
                         <?= $mainPostPreviewThumbnailUrl__mobile ?> 1199w"
            />
        </a>
    </div>

    <div class="desc_block">
        <div class="cat_date_block">
            <div class="category">
                <?php echo $category[0]->cat_name; ?>
            </div>
            <div class="date">
                <?php echo get_the_date( 'j F' ); ?>
            </div>
        </div>
        <div class="vis_block">
            <div class="box">
                <a href="<?= get_the_permalink( $post ) ?>" class="title"
                   onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>', 'eventLabel': '<?php the_title(); ?>',});"
                >
                    <?php the_title(); ?>
                </a>
                <div class="m_cat_date">
                    <?php echo $category[0]->cat_name; ?>· <?php echo get_the_date( 'j F' ); ?> </div>
                <div class="excerpt"><?php echo getPostExcerpt( $post->ID ); ?></div>
                <div class="more_posts">
                    <div class="name">
                        <span>
                            <?php the_field( 'cat_text', 'category_' . $category[0]->term_id . '' ); ?>
                        </span>
                    </div>
                    <ul>
                        <?php
                        $my_more_posts = get_field( 'main_posts_more', $post );
                        if ( $my_more_posts ) {
                            foreach ( $my_more_posts as $post ): ?>
                                <li>
                                    <a href="<?php the_permalink(); ?>"
                                       title="<?= esc_html(the_title()) ?>"
                                       onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>', 'eventLabel': '<?php the_title(); ?>',});"
                                    >
                                        <span>
                                            <?php the_title(); ?>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach;
                            wp_reset_postdata(); ?>
                        <?php } else { ?>
                            <?php
                            $my_posts = new WP_Query;
                            $myposts  = $my_posts->query( array(
                                'post_type'      => 'post',
                                'posts_per_page' => 3,
                                'offset'         => 1,
                                'cat'            => $category[0]->term_id,
                            ) );
                            foreach ( $myposts as $pst ) { ?>
                                <li>
                                    <a href="<?= get_the_permalink( $pst ) ?>"
                                       title="<?= esc_html(the_title()) ?>"
                                       onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>', 'eventLabel': '<?php echo esc_html( $pst->post_title ); ?>',});"
                                    >
                                        <span>
                                            <?php echo esc_html( $pst->post_title ); ?>
                                        </span>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="vis_more">
            <span>Дальше</span>
        </div>
    </div>
</div>
