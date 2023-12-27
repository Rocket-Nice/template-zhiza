<?php
global $wp_query;
//
get_template_part( 'header_redesign' );
//
$p = get_field( 'select_posts' );
$selectedPosts = $p ? $p : [0];
$bannerImageObj = get_field( 'collection_page_banner' );
//
$perPage       = 20;
//
$defaultPcBannerPath     = '/wp-content/themes/evotor/assets/images/collection-banner.jpg';
$defaultMobileBannerPath = '/wp-content/themes/evotor/assets/images/collection-banner-mobile.jpg';
$uploadedImage = null;
if ($bannerImageObj) {
    $uploadedImage = $bannerImageObj['sizes'];
}
//
$page_ = 1;
if ( isset( $_GET['pg'] ) ) {
    $page_ = (int) $_GET['pg'] ?: 1;
}
//
$queryArg = array(
    'post_type'      => 'post',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'posts_per_page' => $perPage,
    'post__in'       => $selectedPosts,
    'paged'          => $page_
); ?>

<main class="page-content page-collection" data-post_id="<?= get_the_ID() ?>" data-post_type="<?= get_post_type() ?>">
    <section class="new-wrapper">
        <div class="collection-image-banner">
            <div class="image-container">
                <picture>
                    <source srcset="<?= $uploadedImage ? $uploadedImage['collection-page-banner-mobile'] : $defaultMobileBannerPath ?>" media="(max-width: 576px)">
                    <source srcset="<?= $uploadedImage ? $uploadedImage['collection-page-banner'] : $defaultPcBannerPath ?>" media="(min-width: 575px)">
                    <img src="<?= $uploadedImage ? $uploadedImage['collection-page-banner'] : $defaultPcBannerPath ?>"
                         width="1032"
                         height="248"
                         alt="<?= the_title() ?>"
                         decoding="async" />
                </picture>
            </div>
            <div class="banner-content">
                <?php get_breadcrumb() ?>

                <div class="collection-info">
                    <span class="type">
                        Подборка
                    </span>

                    <h1 class="collection-title">
                        <?= the_title() ?>
                    </h1>

                    <h2 class="short-description">
                        <?php the_content(); ?>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <section class="new-wrapper content-padding">
        <div class="collection-grid">
            <?php $i = 0;
            $postObj = new WP_Query( $queryArg );
            while ( $postObj->have_posts() ) {
                $postObj->the_post();
                $i ++;
                get_template_part( 'template_parts/collections/redesign-collection-post-item', null, [
                    'i' => $i,
                ] );
            }
            wp_reset_query(); ?>
        </div>
    </section>

    <?php if ( $selectedPosts && (count( $selectedPosts ) > $perPage) ) : ?>
        <section class="new-wrapper">
            <div class="paginator" data-max_pages="<?= $postObj->max_num_pages ?>" data-current="<?= $page_ ?>">
                <?php
                $paginatorArgs = [
                    'format'    => '?pg=%#%',
                    'type'      => 'plain',
                    'show_all'  => true,
                    'current'   => $page_,
                    'total'     => $postObj->max_num_pages,
                    'prev_text' => null,
                    'next_text' => null,
                ];
                $paginate      = paginate_links( $paginatorArgs );
                echo $paginate; ?>
            </div>
        </section>
    <?php endif; ?>

    <div class="new-wrapper content-padding">
        <section id="new_sub_main" class="new_sub new_sub__short" data-form="new_sub_form_main_page" data-location="Форма подписки на странице коллекций">
            <div class="wrapper new_sub--white">
                <?php $dataLayerPlacement = 'блок подписки на странице коллекций'; ?>
                <?php get_template_part('template_parts/subscribe_form', null, ['dataLayerPlacement' => $dataLayerPlacement]) ?>
            </div>
        </section>
    </div>

    <div class="slider_block">
        <div class="new-wrapper">
            <div class="wrapper">
                <h2>Посмотрите другие подборки</h2>

                <div class="slider owl-slider owl-carousel new-slider-nav">
                    <?php
                    $other = get_field( 'podbr_other', false, false );
                    $otherCollections = $other ? array_map('intval', $other) : [];
                    //
                    $idOfOtherCollections = [];
                    query_posts([
                        'post_type'      => 'collections',
                        'posts_per_page' => - 1,
                        'post__not_in'   => array_merge($otherCollections, [get_the_ID()]),
                    ]);
                    while ( have_posts() ) {
                        the_post();
                        $idOfOtherCollections[] = get_the_ID();
                    }
                    $result = array_merge( $otherCollections, $idOfOtherCollections );
                    //
                    foreach ( $result as $post ) {
                        setup_postdata( $post );
                        $p = get_field( 'select_posts' );
                        $post_count = $p ? count( $p ) : 0;
                        //
                        get_template_part('template_parts/sliders/collections_slider_item', null, [
                            'postCount' => $post_count
                        ]);
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_template_part( 'footer_redesign' ); ?>
