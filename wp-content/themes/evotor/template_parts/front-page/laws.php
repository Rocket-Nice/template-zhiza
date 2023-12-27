<?php
/**
 * Выводим 5 самых свежих статей из категории Законы.
 * Исключаем из выбранных статьи, которые не нужно выводить на главной.
 */
$metaQueryArgs_dontShowAtMainPage = [
    [
        'key'     => 'dont_show_at_main_page',
        'value'   => '0',
        'compare' => '=',
    ],
];
$firstPost = [$GLOBALS['firstPostId']];
$importantPosts = $GLOBALS['importantPosts'];
$args = array(
    'post_type'        => 'post',
    'orderby'          => 'date',
    'order'            => 'DESC',
    'posts_per_page'   => 5,
    'meta_query'       => $metaQueryArgs_dontShowAtMainPage,
    'category__in' => [ ( get_category_by_slug( 'theory' ) )->term_id ],
    'post__not_in' => array_merge($firstPost, $importantPosts)
);
query_posts( $args );
?>

<div class="laws-posts">
    <div class="new-wrapper content-padding">
        <h2 class="section-title">
            Законы
        </h2>

        <div class="laws">
            <?php
            $i = 0;
            while ( have_posts() ):
            the_post();
            $category = get_the_category();
            $mainPostPreviewThumbnailUrl = get_the_post_thumbnail_url($post, 'collection-image');
            ?>
                <div class="<?php if ($i < 2): echo 'post-card--wrapper post-card--wrapper__white'; endif; ?> laws-card">
                    <div class="post-card <?php if ($i < 2): echo 'card-hoverable'; endif; ?>" data-place>
                        <?php if ($i < 2): ?>
                            <div class="img-wrapper">
                                <img src="<?= $mainPostPreviewThumbnailUrl ?>"
                                     alt="<?php the_title(); ?>" title="<?php the_title(); ?>"
                                     width="340" height="216" decoding="async" loading="lazy"
                                />
                            </div>
                        <?php endif; ?>
                        <div class="text-block">
                            <a href="<?php echo get_permalink(); ?>" class="post-title"
                               title="<?php the_title(); ?>" data-link
                            >
                                <?php the_title(); ?>
                            </a>
                            <div class="post-meta orange">
                                <p class="date"><?php echo get_the_date( 'j F Y' ); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $i++; endwhile; ?>
        </div>
    </div>
</div>

<?php wp_reset_query(); ?>
