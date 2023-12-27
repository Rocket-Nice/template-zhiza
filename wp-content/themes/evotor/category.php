<?php
get_template_part( 'header_redesign' );

/**
 * Является основой для 1 страницы шаблона категории.
 * Все остальные страницы подгружаются через AJAX.
 */
$category   = get_category( get_query_var( 'cat' ) );
$categoryId = $category->cat_ID;
$categoryDescription = $category->category_description;
$countPostsAtPage = 6;
$page = array_key_exists('page', $wp_query->query_vars) ? $wp_query->query_vars['page'] : 1;
//
$args = [
    'cat' => $categoryId,
    'posts_per_page' => $countPostsAtPage,
    'paged' => $page,
];
$posts = new WP_Query( $args );
?>

<div class="wrapper padding-top">
    <?php get_breadcrumb('page--style') ?>
</div>

<section id="category_page">
    <div class="wrapper">
        <h1 class="page_title">
            <?= $categoryDescription ?>
        </h1>
        <div class="all_cat_box">
            <div class="block category_<?= $countPostsAtPage ?>">
                <?php
                $n = 0;
                //query_posts( $args );
                while ( $posts->have_posts() ) :
                    $posts->the_post(); $n++;

                    get_template_part( 'template_parts/category/category-post-item', null, [ 'position' => $n ] );

                    if ($n === 10) {
                        echo '<div class="once_mask"></div>';
                    }
                    ?>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>
            </div>
        </div>
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

<section id="n_podbor_page">
    <div class="wrapper">
        <h2>Посмотрите другие подборки</h2>
        <div class="n_podbor_carousel_page owl-carousel">
            <?php $pdb_bot = get_field( 'podbr_other' ); ?>
            <?php
            $my_arr = array();
            $args   = array( 'post_type' => 'collections', 'posts_per_page' => - 1 );
            query_posts( $args );
            while ( have_posts() ) {
                the_post();
                $my_arr[] = get_the_ID();
            }

            $ii = 0;
            foreach ( $my_arr as $post ): $ii ++;
                setup_postdata( $post );
                $selectedPosts = get_field( 'select_posts' );
                $post_count = 0;
                if ($selectedPosts) {
                    $post_count = count( $selectedPosts);
                }
                //
                $postThumbUrl = get_the_post_thumbnail_url($post, 'main_post_small_preview');
                $postThumbMobileUrl = get_the_post_thumbnail_url( $post, 'main_post_small_preview_mobile_smallest' );
                ?>
                <div class="once">
                    <div class="img_block">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?= $postThumbUrl ?>"
                                 alt="<?= get_the_title() ?>"
                                 width="285" height="193"
                                 loading="lazy"
                                 decoding="async"
                                 srcset="<?= $postThumbUrl ?> 1920w,
                                         <?= $postThumbMobileUrl ?> 1199w" />
                        </a>
                    </div>
                    <div class="desc_block">
                        <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                        <div class="info"><?php the_content(); ?></div>
                        <div class="all_num_block">
                            <a href="<?php the_permalink(); ?>">
                                <div class="num"><?php echo $post_count; ?></div>
                                <div class="st"><span><?php echo post_count_text( $post_count ); ?></span></div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>

        </div>
    </div>
</section>

<style>
    footer {
        margin-top: 0;
    }
</style>


<?php get_template_part( 'footer' ); ?>
