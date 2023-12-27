<?php

/**
 * Для блока берём самую свежую статью, но с учётом того, что статья не выключена для показа на главной.
 */
$metaQueryArgs_dontShowAtMainPage = [
    [
        'key'     => 'dont_show_at_main_page',
        'value'   => '0',
        'compare' => '=',
    ],
];
$args = array(
    'post_type'        => 'post',
    'orderby'          => 'date',
    'order'            => 'DESC',
    'posts_per_page'   => 1,
    'meta_query'       => $metaQueryArgs_dontShowAtMainPage,
    'category__not_in' => [
        ( get_category_by_slug( 'uncategorized' ) )->term_id
    ],
);
$queryPost = new WP_Query($args);
$post_ = $queryPost->post;
$category = (get_the_category($post_))[0];
// Изображения статьи
$mainPostImage = get_field('main_thumb_img', $post_);
//
$mainPostPreviewThumbnailUrl = $mainPostImage ?
    wp_get_attachment_image_src($mainPostImage, 'preview-newest-post')[0]
    : get_the_post_thumbnail_url($post, 'preview-newest-post');
//
$mainPostPreviewThumbnailUrl__mobile = $mainPostImage ?
    wp_get_attachment_image_src($mainPostImage, 'preview-newest-post-mobile')[0]
    : get_the_post_thumbnail_url($post, 'preview-newest-post-mobile');

// Храним ID первого поста. Пока самая новая статья отображается на 1 экране,
// она не должна появляться в других блоках.
$GLOBALS['firstPostId'] = $post_->ID;
?>

<div class="project-preview">
    <div class="images-container">
        <div class="post-preview" data-place>
            <img src="<?= $mainPostPreviewThumbnailUrl ?>"
                 alt="<?= $post_->post_title ?>"
                 title="<?= $post_->post_title ?>"
                 width="1212" height="456" decoding="async"
                 srcset="<?= $mainPostPreviewThumbnailUrl ?> 1920w,
                         <?= $mainPostPreviewThumbnailUrl__mobile ?> 1032w"
            />
            <div class="post-text text-adaptive">
                <div class="post-meta">
                    <a href="/category/<?= $category->slug ?>/" class="category" title="<?= $category->name ?>">
                        <?= $category->name ?>
                    </a>
                    <p class="date"><?php echo get_the_date( 'j F Y', $post_ ); ?></p>
                </div>
                <a href="<?= get_permalink($post_) ?>" class="title" data-link
                   title="<?= $post_->post_title ?>"
                >
                    <?= $post_->post_title ?>
                </a>
            </div>
        </div>
        <div class="about-project">
            <div class="letter"></div>
            <div class="about-project-text">
                <h1 class="title">Жиза</h1>
                <p class="description">
                    Журнал для предпринимателей России, медиа-проект Эвотора.
                    Пишем обо всём, что может быть полезно малому бизнесу.
                </p>

                <div class="btn--wrapper btn--wrapper--white">
                    <a href="/o-proekte/" class="btn btn-white h-40" title="О проекте">О проекте</a>
                </div>
            </div>
        </div>
    </div>

    <div class="new-wrapper text-container" data-place>
        <div class="post-text">
            <div class="post-meta">
                <a href="/category/<?= $category->slug ?>/" class="category" title="<?= $category->name ?>">
                    <?= $category->name ?>
                </a>
                <p class="date"><?php echo get_the_date( 'j F Y', $post_ ); ?></p>
            </div>
            <a href="<?= get_permalink($post_) ?>" class="title" data-link
               title="<?= $post_->post_title ?>"
            >
                <?= $post_->post_title ?>
            </a>
        </div>
    </div>
</div>

<?php wp_reset_query(); ?>
