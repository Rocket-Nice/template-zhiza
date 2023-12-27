<?php
/**
 * Для блока берём только 4 самых свежих статьи, помеченных в админке, в поле "Блок Важное на главной странице".
 */
$metaQueryArgs_isImportantPost = [
    [
        'key'     => 'is_important_post',
        'value'   => '1',
        'compare' => '=',
    ],
];
$firstPost = $GLOBALS['firstPostId'];
$args = array(
    'post_type'        => 'post',
    'orderby'          => 'date',
    'order'            => 'DESC',
    'posts_per_page'   => 4,
    'meta_query'       => $metaQueryArgs_isImportantPost,
    'post__not_in' => [$firstPost]
);
query_posts( $args );

$importantPosts = [];
?>

<div class="important-posts no-overflow-x">
    <div class="new-wrapper content-padding">
        <h2 class="section-title">Важное</h2>

        <ul class="posts-list">
            <?php
            while ( have_posts() ):
                the_post();
                $importantPosts[] = get_the_ID();
                $category = get_the_category();
                $mainPostPreviewThumbnailUrl = get_the_post_thumbnail_url($post, 'collection-image');
                ?>

                <li class="post-card--wrapper post-card--wrapper__white" data-place>
                    <div class="post-card card-hoverable" data-place>
                        <div class="text-block">
                            <div class="post-meta orange">
                                <a href="/category/<?= $category[0]->slug ?>/" class="category">
                                    <?php echo $category[0]->cat_name; ?>
                                </a>
                                <p class="date">
                                    <?php echo get_the_date( 'j F Y' ); ?>
                                </p>
                            </div>
                            <a href="<?php echo get_permalink(); ?>" class="post-title" data-link
                               title="<?php the_title(); ?>"
                            >
                                <?php the_title(); ?>
                            </a>
                        </div>
                        <div class="img-wrapper">
                            <img src="<?= $mainPostPreviewThumbnailUrl ?>"
                                 alt="<?php the_title(); ?>" title="<?php the_title(); ?>"
                                 width="240" height="124" decoding="async" loading="lazy"
                            />
                        </div>
                    </div>
                </li>

            <?php endwhile; ?>
        </ul>
    </div>
</div>

<?php wp_reset_query(); ?>

<?php
$GLOBALS['importantPosts'] = $importantPosts;
?>
