<?php
$queryArg = array(
    'post_type'        => 'collections',
    'orderby'          => 'rand',
    'posts_per_page'   => 1,
    // Игнорирование фильтров и фильтрации по menu.order.
    'suppress_filters' => true,
    'ignore_custom_sort' => true,
);
$postObj  = new WP_Query( $queryArg );
$postImage = get_the_post_thumbnail_url($postObj->post, 'preview-newest-post');
//
$selectedPosts  = get_field( 'select_posts', $postObj->post );
$queryArg = array(
    'post_type'      => 'post',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'posts_per_page' => 3,
    'post__in'       => $selectedPosts,
);
$newestPostOfCollection = new WP_Query( $queryArg );
?>

<div class="random-collection" id="random-collection-block">
    <div class="preloader">
        <div class="text-wrapper">
            <div class="random-text">
            </div>
        </div>
    </div>

    <div class="img-wrapper">
        <img src="<?= $postImage ?>" width="948" height="548"
             alt="" decoding="async" loading="lazy" />
    </div>

    <div class="content-wrapper">
        <div class="text-container">
            <div class="sub-title">
                <p>например, такая подборка</p>
                <div class="dice" id="dice">
                    <img src="/wp-content/themes/evotor/assets/images/cube_gif.gif" width="32" height="32" loading="lazy"
                         decoding="async" alt="" />
                </div>
            </div>
            <div class="collection-title"><?= $postObj->post->post_title ?></div>
            <div class="info"><?= $postObj->post->post_content ?></div>

            <ul class="post-list">
                <?php foreach ($newestPostOfCollection->posts as $p): ?>
                    <li class="item">
                        <a href="<?= get_permalink($p) ?>" class="title" title="<?= $p->post_title ?>">
                            <?= $p->post_title ?>
                        </a>
                        <div class="post-meta">
                            <p class="date"><?php echo get_the_date( 'j F Y', $p ); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="btn-row">
            <div class="btn--wrapper">
                <a href="<?= get_permalink($postObj->post) ?>" class="btn btn-orange">Перейти к подборке</a>
            </div>
        </div>
    </div>
</div>
