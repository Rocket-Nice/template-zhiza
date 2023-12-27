<?php
get_template_part( 'header_redesign' );
//
$collectionsGroups = [];
$countPostsAtPage  = 6;
$page              = array_key_exists( 'page', $wp_query->query_vars ) ? $wp_query->query_vars['page'] : 1;
$args              = [
    'post_type'      => 'benefits',
    'posts_per_page' => $countPostsAtPage,
    'paged'          => $page,
];
query_posts( $args );
//
while ( have_posts() ) {
    the_post();
    $collectionsGroups[] = get_the_ID();
}
$collectionsGroups = array_chunk( $collectionsGroups, 6 );
//
$posts = new WP_Query( $args );
?>

<div class="wrapper padding-top">
    <?php get_breadcrumb( 'page--style' ) ?>
</div>

<section id="selections_all_page">
    <div class="wrapper">
        <h1 class="page_title">
            Польза
        </h1>
        <?php
        //
        foreach ( $collectionsGroups as $group ) {
            $countCollectionsAtChunk = count( $group ); ?>
            <div class="block all_collections_<?= $countCollectionsAtChunk ?>">
                <?php
                $listCirclePC     = [ 2, 3, 4, 5, 6, 10, 11, 12 ];
                $listCircleMobile = [ 3, 4, 5, 6, 9, 10, 11, 12 ];
                //
                $index = 0;
                //
                foreach ( $group as $post ) {
                    $index ++;
                    setup_postdata( $post );
                    $selectedPosts = get_field( 'select_posts' );
                    $post_count    = 0;
                    if ( ! empty( $selectedPosts ) ) {
                        $post_count = count( $selectedPosts );
                    }
                    //
                    [
                        'thumbnail'       => $thumbnail,
                        'thumbnailCircle' => $thumbnailCircle
                    ] = getActualCollectionImage( $post, $index, false );
                    [
                        'thumbnail'       => $thumbnailMobile,
                        'thumbnailCircle' => $thumbnailCircleMobile
                    ] = getActualCollectionImage( $post, $index, true );
                    ?>
                    <div class="once">
                        <div class="img_block">
                            <a href="<?php the_permalink(); ?>">
                                <img src="<?= $thumbnailCircle ?>"
                                     alt="<?= get_the_title( $post ) ?>"
                                     title="<?= get_the_title( $post ) ?>"
                                     class="sircle"
                                    <?= in_array( $index, [ 1, 2, 3, 4, 5, 6 ], true ) ? '' : "loading='lazy'" ?>
                                     width="164"
                                     height="164"
                                     decoding="async"
                                     srcset="<?= $thumbnailCircle ?> 1920w,
                                             <?= $thumbnailCircleMobile ?: $thumbnailMobile ?> 1199w"
                                />
                                <img src="<?= $thumbnail ?>"
                                     alt="<?= get_the_title( $post ) ?>"
                                     title="<?= get_the_title( $post ) ?>"
                                     width="590"
                                     height="300"
                                     class="square"
                                    <?= in_array( $index, [ 1, 2, 3, 4, 5, 6 ], true ) ? '' : "loading='lazy'" ?>
                                     decoding="async"
                                    <?php if ( $index === 2 ): ?>
                                        srcset="<?= $thumbnailMobile ?> 1920w,
                                                 <?= $thumbnail ?> 1199w"
                                    <?php elseif ( $index === 9 ): ?>
                                        srcset="<?= $thumbnail ?> 1920w,
                                                 <?= $thumbnailMobile ?> 1199w"
                                    <?php else: ?>
                                        srcset="<?= $thumbnail ?> 1920w,
                                                 <?= $thumbnailMobile ?> 1199w"
                                    <?php endif; ?>
                                />
                            </a>
                        </div>
                        <div class="desc_block">
                            <a href="<?php the_permalink(); ?>" class="title" title="<?= the_title() ?>">
                                <?php the_title(); ?>
                            </a>
                            <div class="info"><?php the_content(); ?></div>
                            <div class="all_num_block">
                                <a href="<?php the_permalink(); ?>">
                                    <div class="num">
                                        <?= $post_count ?>
                                    </div>
                                    <div class="st">
                                        <span>
                                            <?= post_count_text( $post_count ) ?>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php if ( $countCollectionsAtChunk === 4 ) { ?>
                        <?php if ( $index === 3 ) { ?>
                            <div class="once_mask"></div><?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
        <?php wp_reset_query(); ?>
    </div>

    <div class="wrapper">
        <div class="paginator <?php if ($posts->max_num_pages < 7) { echo 'centered'; } ?>"
             data-max_pages="<?= $posts->max_num_pages ?>" data-current="<?= $page ?>">
            <?php
            $paginatorArgs = [
                'format'    => '?page=%#%',
                'type'      => 'plain',
                'show_all'  => false,
                'end_size'  => 1,
                'mid_size'  => 1,
                'current'   => $page,
                'total'     => $posts->max_num_pages,
                'prev_text' => "<div class='back-arrow'></div>",
                'next_text' => "<div class='next-arrow'></div>",
            ];
            $paginate      = paginate_links( $paginatorArgs );
            echo $paginate; ?>
        </div>
    </div>
</section>
<?php get_template_part( 'footer' ); ?>
