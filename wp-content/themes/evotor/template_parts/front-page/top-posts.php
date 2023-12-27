<?php
$top_posts = pvc_get_most_viewed_posts( [
    'posts_per_page' => 12,
] );
?>

<div class="top-posts">
    <div class="new-wrapper banners content-padding">
        <h2 class="section-title">
            Топ статей
        </h2>

        <div class="posts-list owl-carousel" id="top-posts-owl-carousel">
            <?php
                foreach ($top_posts as $key => $p):
                setup_postdata($p);
                $image = get_the_post_thumbnail_url($p, 'main_post_small_preview');
                $category = (get_the_category($p))[0];
            ?>
                    <div class="post-card slide" data-slide-index=<?= $key ?> data-place>
                        <div class="img-wrapper">
                            <img src="<?= $image ?>"
                                 decoding="async" loading="lazy"
                                 width="152" height="108"
                                 alt="<?= $p->post_title ?>"
                                 title="<?= $p->post_title ?>"
                            />
                        </div>
                        <div class="text-block">
                            <a href="<?= get_permalink($p) ?>" class="post-title" title="<?= $p->post_title ?>"
                                data-link
                            >
                                <?= $p->post_title ?>
                            </a>
                            <div class="post-meta orange">
                                <a href="/category/<?= $category->slug ?>/" class="category" title="<?= $category->name ?>">
                                    <?= $category->name ?>
                                </a>
                                <p class="date"><?php echo get_the_date( 'j F Y', $p ); ?></p>
                                <p class="count-views">
                                    <img src="/wp-content/themes/evotor/images/front-page/Eye.svg"
                                         width="16" height="16" alt="Количество просмотров"
                                         loading="lazy" decoding="async"
                                    /> <?= pvc_get_post_views( $p->ID) ?>
                                </p>
                            </div>
                        </div>
                    </div>
            <?php
                wp_reset_postdata();
                endforeach;
            ?>
        </div>
    </div>
</div>

<?php wp_reset_query(); ?>
