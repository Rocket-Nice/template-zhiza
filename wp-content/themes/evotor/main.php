<?php
/*
Template Name: Main
Файл шаблона главной страницы
*/
?>
<?php get_template_part( 'header' );
$canonicalPostName = $post->post_title;

// Выборка для meta-query, фильтрует все записи, где это мета поле либо не отмечено, либо вообще еще не существует.
$metaQueryArgs_dontShowAtMainPage = [
    [
        'key'     => 'dont_show_at_main_page',
        'value'   => '0',
        'compare' => '=',
    ],
];

?>

<?php
/**
 * @var array{text_h1: string, project_description: string}  $projectDescriptionGroup
 */
$projectDescriptionGroup = get_field('project_description_group');
$a = 0;
?>
<section id="n_top_block">
    <div class="project-description-on-main-page">
        <div class="wrapper project-description-wrapper">
            <h1><?= $projectDescriptionGroup['text_h1'] ?></h1>
            <p><?= $projectDescriptionGroup['project_description'] ?></p>
        </div>
    </div>

    <div class="wrapper">
        <div class="left">
            <?php
            $args = array(
                'post_type'        => 'post',
                'orderby'          => 'date',
                'order'            => 'DESC',
                'posts_per_page'   => 4,
                'meta_query'       => $metaQueryArgs_dontShowAtMainPage,
                'category__not_in' => [ ( get_category_by_slug( 'uncategorized' ) )->term_id ]
            );
            query_posts( $args );
            $i = 0;

            while ( have_posts() ):
                the_post(); $i++;
                $category = get_the_category();

                if ( $i === 1 ):
                    get_template_part( 'template_parts/main_page/preview_screen_big_image', null, [
                        'post' => $post,
                        'category' => $category,
                        'canonicalPostName' => $canonicalPostName,
                    ]);
                    continue;
                endif; ?>
                <?php
                if ($i === 2):
                    echo '<div class="bot_posts_block">';
                endif;
                get_template_part( 'template_parts/main_page/preview_small_posts', null, [
                    'post' => $post,
                    'category' => $category,
                    'canonicalPostName' => $canonicalPostName,
                ]);
            endwhile; ?>
        </div>

        <div class="clr"></div>
    </div>

    <div class="clr"></div>

</section>


<?php if ( get_field( 'main_b_view', 9290 ) === 'on' ) { ?>
    <section id="n_full_post">
        <div class="wrapper">
            <div class="box" style="background-image: url(<?php the_field( 'main_b_img', 9290 ); ?>);">
                <div class="info">
					<?php the_field( 'main_b_title', 9290 ); ?>
                </div>
                <a href="<?php the_field( 'main_b_link', 9290 ); ?>"
                   class="link"><?php the_field( 'main_b_btn', 9290 ); ?></a>
            </div>
        </div>
    </section>
<?php } ?>


<?php
/**
 * Вывод 5 последних постов. 2 экран на главной странице
 */
?>
<section id="n_post_list">
    <div class="wrapper">
        <?php
        $args = array(
            'post_type'      => 'post',
            'offset'         => 4,
            'posts_per_page' => 5,
            'meta_query' => $metaQueryArgs_dontShowAtMainPage,
            'category__not_in' => [ ( get_category_by_slug( 'uncategorized' ) )->term_id ]
        );
        query_posts( $args );
        $i = 0;
        while ( have_posts() ) : the_post();
            $i ++;
            $category = get_the_category(); ?>

            <div class="once<?= $i === 1 ? ' main' : '' ?> ">
                <div class="date">
                    <?php echo get_the_date( 'j F' ); ?>
                </div>
                <div class="info">
                    <a href="<?php echo get_category_link( $category[0]->term_id ); ?>" class="cat"
                       title="<?= $category[0]->cat_name ?>"
                       onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?php the_title(); ?>',});"
                    >
                        <?= $category[0]->cat_name ?>
                    </a>
                    <a href="<?= get_the_permalink( $post ) ?>" class="p_img"
                       title="<?= the_title() ?>"
                       onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?php the_title(); ?>',});"
                    >
                        <?php $circle = get_the_post_thumbnail_url($post, 'circle-post'); ?>
                        <img src="<?= $circle ?>" loading="lazy" alt="" width="46" height="46" decoding="async" />
                    </a>
                    <a href="<?= get_the_permalink( $post ) ?>" class="title"
                       title="<?= the_title() ?>"
                       onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?php the_title(); ?>',});"
                    >
                        <span>
                            <?php the_title(); ?>
                        </span>
                    </a>
                </div>
                <div class="date_m">
                    <?php echo get_the_date( 'j F' ); ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>


<?php
/**
 * Блок 'С чего начать'. 3 экран на главной
 */
?>
<section id="n_tests">
    <div class="wrapper">
        <h2>
            <span>
                <?php the_field( 'main_select_title', 9290 ); ?>
            </span>
        </h2>
        <div class="tests_carousel owl-carousel">
            <?php $posts = get_field( 'main_select_post', 9290 );
            $i = 0;
            foreach ( $posts as $post ): $i ++;
                setup_postdata( $post );
                $category = get_the_category();
                $thumb = get_the_post_thumbnail( $post->ID, 'blog-full', array( 'alt' => $post->post_title ) );
                //
                $mainPostPreviewThumbnailUrl = get_the_post_thumbnail_url($post, 'main_post_small_preview');
                ?>

                <div class="once">
                    <div class="img_block">
                        <a href="<?= get_the_permalink( $post ) ?>"
                           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?php the_title(); ?>',});"
                        >
                            <img src="<?= $mainPostPreviewThumbnailUrl ?>"
                                 alt="<?= $post->post_title ?>"
                                 title="<?= $post->post_title ?>"
                                 width="285" height="193"
                                 loading="lazy"
                                 decoding="async"
                            />
                        </a>
                    </div>
                    <div class="desc_block">
                        <div class="cat_date_block">
                            <div class="category"><?php echo $category[0]->cat_name; ?></div>
                            <div class="date"><?php echo get_the_date( 'j F' ); ?></div>
                        </div>
                        <a href="<?= get_the_permalink( $post ) ?>" class="title"
                           title="<?= $post->post_title ?>"
                           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?php the_title(); ?>',});"
                        >
                            <?php if ( get_field( 'main_title_br', $post ) ) { ?>
                                <?php the_field( 'main_title_br', $post ) ?>
                            <?php } else { ?>
                                <?php the_title(); ?>
                            <?php } ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</section>


<?php
/**
 * Блок с формой подписки на рассылку
 */
?>
<section id="new_sub_main" class="modal new_sub new_sub--padding" data-form="new_sub_form_main_page" data-location="Форма подписки на главной странице">
    <div class="wrapper new_sub--white no-overflow important--short-form">
        <?php $dataLayerPlacement = 'блок подписки на главной'; ?>
        <?php get_template_part('template_parts/subscribe_form', null, [
            'dataLayerPlacement' => $dataLayerPlacement
        ]) ?>
    </div>
</section>


<section id="n_fond">
    <div class="wrapper">
        <h2>
            Золотой фонд. О чем пишем
        </h2>
        <div class="tab_li">
            <ul>
                <?php $pdb_top = get_field( 'podbr_main_top', 9290 ); ?>
                <?php $i = 0; ?>
                <?php foreach ( $pdb_top as $post ): $i ++; ?>
                    <?php setup_postdata( $post ); ?>
                    <li data-tab="tab<?php echo $i; ?>" <?php if ( $i === 1 ) { ?> class="active" <?php } ?>>
                        <span>
                            <?php the_title(); ?>
                        </span>
                    </li>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </ul>
            <div class="clr"></div>
        </div>

        <div class="tab_content">
            <?php $pdb_top = get_field( 'podbr_main_top', 9290 );
            $i = 0;
            foreach ( $pdb_top as $post ): $i ++;
                setup_postdata( $post ); ?>
                <div id="tab<?= $i ?>" class="tab_box <?= $i === 1 ? 'active visible' : '' ?> ">
                    <div class="fond_carousel owl-carousel">
                        <?php
                        $pdb_top_once = get_field( 'select_posts', get_the_id() );
                        foreach ( $pdb_top_once as $p ):
                            $dontShow = get_post_meta($p, 'dont_show_at_main_page');
                            if (!empty($dontShow)) { // Если выбрана опция - не выводить на главной, пропустим статью.
                                if ($dontShow[0] === '1') {
                                    continue;
                                }
                            }

                            $category = get_the_category( get_post( $p ) ); ?>
                            <div class="once">
                                <div class="img_block">
                                    <a href="<?= get_the_permalink( get_post( $p ) ) ?>"
                                       onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?= get_post( $p )->post_title ?>',});"
                                    >
                                        <?php $goldFondPostImage = get_the_post_thumbnail_url($p, 'gold_fond_image'); ?>
                                        <img src="<?= $goldFondPostImage ?>"
                                             alt="<?= get_the_title($p) ?>"
                                             title="<?= get_the_title($p) ?>"
                                             width="373" height="195"
                                             loading="lazy"
                                             decoding="async"
                                        />
                                    </a>
                                </div>
                                <div class="desc_block">
                                    <div class="cat_date_block">
                                        <div class="category">
                                            <?= $category[0]->cat_name ?>
                                        </div>
                                        <div class="date">
                                            <?= get_the_date( 'j F', get_post( $p ) ) ?>
                                        </div>
                                    </div>
                                    <div class="vis_block">
                                        <div class="box">
                                            <a href="<?= get_the_permalink( get_post( $p ) ) ?>" class="title"
                                               title="<?= get_post( $p )->post_title ?>"
                                               onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?= get_post( $p )->post_title ?>',});"
                                            >
                                                <?= get_post( $p )->post_title ?>
                                            </a>
                                            <div class="m_cat_date">
                                                <?= $category[0]->cat_name ?> · <?= get_the_date( 'j F', get_post( $p ) ) ?>
                                            </div>
                                            <div class="excerpt">
                                                <?= getPostExcerpt( get_post( $p ) ) ?>
                                            </div>
                                            <div class="more_posts">
                                                <div class="name">
                                                    <span>
                                                        <?php the_field( 'cat_text', 'category_' . $category[0]->term_id . '' ); ?>
                                                    </span>
                                                </div>
                                                <ul>
                                                    <?php $my_more_posts = get_field( 'main_posts_more', $post ); ?>
                                                    <?php if ( $my_more_posts ) { ?>
                                                        <?php foreach ( $my_more_posts as $post ): ?>
                                                            <li>
                                                                <a href="<?php the_permalink(); ?>"
                                                                   title="<?= the_title() ?>"
                                                                   onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?php the_title(); ?>',});"
                                                                >
                                                                    <span>
                                                                        <?php the_title(); ?>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                        <?php wp_reset_postdata(); ?>
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
                                                                   title="<?= esc_html( $pst->post_title ) ?>"
                                                                   onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?php echo esc_html( $pst->post_title ); ?>',});"
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
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
    </div>
</section>

<?php
/**
 * Блок с блока Youtube фреймами
 */
?>
<section id="n_video">
    <div class="wrapper">
        <h3>
            <?php the_field( 'main_video_box_title', 9290 ); ?>
        </h3>
        <div class="n_video_carousel owl-carousel">
            <?php
            $fi = 0;
            while ( have_rows( 'main_video_box', 9290 ) ) : the_row();
                $fi ++; ?>
                <div class="once">
                    <?php /* TODO удалить iframetrack со всего сайта */ ?>
                    <div class="box">
                        <div class="video-wrapper youtube-placeholder youtube-placeholder__play-button"
                             data-youtube_video_id="<?php the_sub_field( 'main_video_once_frame' ); ?>"
                             data-youtube_frame
                             data-name="<?php the_sub_field( 'main_video_once_name' ); ?>" id="vd_<?= $fi ?>"
                        >
                            <img src="https://img.youtube.com/vi/<?php the_sub_field( 'main_video_once_frame' ); ?>/sddefault.jpg"
                                 alt="" loading="lazy" width="900" decoding="async" height="674" />
                        </div>
                        <div class="video_bg">
                            <a data-fancybox href="https://www.youtube.com/watch?v=<?php the_sub_field( 'main_video_once_frame' ); ?>&amp;autoplay=1">
                                <img src="https://img.youtube.com/vi/<?php the_sub_field( 'main_video_once_frame' ); ?>/hqdefault.jpg"
                                     alt="" loading='lazy' decoding="async" width="335" height="251" />
                            </a>
                        </div>
                        <div class="info"><?php the_sub_field( 'main_video_once_desc' ); ?></div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<section id="bot_posts">
    <div class="wrapper">
        <div class="bot_carousel owl-carousel">
            <?php
            $posts = get_field( 'main_random', 9290 );
            $i = 0;
            foreach ( $posts as $post ): $i ++;
                setup_postdata( $post );
                $category = get_the_category();
                //
                $mainPostPreviewThumbnailUrl = get_the_post_thumbnail_url($post, 'main-post-preview-mobile');
                //
                $dontShow = get_post_meta($post, 'dont_show_at_main_page');
                if (!empty($dontShow)) { // Если выбрана опция - не выводить на главной, пропустим статью.
                    if ($dontShow[0] === '1') {
                        continue;
                    }
                } ?>

                <div class="once">
                    <div class="img_block">
                        <a href="<?= get_the_permalink( $post ) ?>"
                           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?php the_title(); ?>',});"
                        >
                            <img src="<?= $mainPostPreviewThumbnailUrl ?>"
                                 alt="<?= get_the_title() ?>"
                                 title="<?= get_the_title() ?>"
                                 width="285" height="193"
                                 decoding="async"
                                 loading="lazy"
                            />
                        </a>
                    </div>
                    <div class="desc_block">
                        <div class="cat_date_block">
                            <div class="category">
                                <?= $category[0]->cat_name ?>
                            </div>
                            <div class="date">
                                <?= get_the_date( 'j F' ) ?>
                            </div>
                        </div>
                        <div class="vis_block">
                            <div class="box">
                                <a href="<?= get_the_permalink( $post ) ?>" class="title"
                                   title="<?= the_title() ?>"
                                   onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?php the_title(); ?>',});"
                                >
                                    <?php the_title(); ?>
                                </a>
                                <div class="m_cat_date">
                                    <?= $category[0]->cat_name ?> · <?= get_the_date( 'j F' ); ?>
                                </div>
                                <div class="excerpt">
                                    <?= getPostExcerpt( get_the_ID() ) ?>
                                </div>
                                <div class="more_posts">
                                    <div class="name">
                                        <span>
                                            <?php the_field( 'cat_text', 'category_' . $category[0]->term_id ); ?>
                                        </span>
                                    </div>
                                    <ul>
                                        <?php
                                        $my_more_posts = get_field( 'main_posts_more', $post );
                                        if ( $my_more_posts ) :
                                            ?>
                                            <?php foreach ( $my_more_posts as $post_ ): ?>
                                            <li>
                                                <a href="<?php the_permalink(); ?>"
                                                   title="<?= the_title() ?>"
                                                   onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?php the_title(); ?>',});"
                                                >
                                                    <span>
                                                        <?php the_title(); ?>
                                                    </span>
                                                </a>
                                            </li>
                                        <?php endforeach;
                                            wp_reset_postdata();
                                        else:
                                            $my_posts = new WP_Query;
                                            $myposts  = $my_posts->query( array(
                                                'post_type'      => 'post',
                                                'posts_per_page' => 3,
                                                'offset'         => 1,
                                                'cat'            => $category[0]->term_id,
                                            ) );
                                            foreach ( $myposts as $pst ) : ?>
                                                <li>
                                                    <a href="<?= get_the_permalink( $pst ) ?>"
                                                       title="<?= esc_html( $pst->post_title ) ?>"
                                                       onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostName ?>','eventLabel': '<?= esc_html( $pst->post_title ) ?>',});"
                                                    >
                                                        <span>
                                                            <?= esc_html( $pst->post_title ) ?>
                                                        </span>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="vis_more">
                            <span>Дальше</span>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<section id="n_podbor">
    <div class="wrapper">
        <h3>
            <a href="/collections/"
               onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction':'подборки','eventLabel': '<?php the_title(); ?>',});"
               title="Подборки"
            >
                Подборки
            </a>
        </h3>
        <div class="n_podbor_carousel owl-carousel">
            <?php $pdb_bot = get_field( 'podbr_main_bot', 9290 );

            foreach ( $pdb_bot as $post ):
                setup_postdata( $post );
                $post_count = count( get_field( 'select_posts' ) );
                //
                $mainPostPreviewThumbnailUrl = get_the_post_thumbnail_url($post, 'main-post-preview-mobile');
                $mainPostPreviewThumbnailUrl__mobile = get_the_post_thumbnail_url($post, 'main_post_small_preview_mobile_smallest');
                ?>
                <div class="once">
                    <div class="img_block">
                        <a href="<?php the_permalink(); ?>"
                           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction':'подборки','eventLabel': '<?php the_title(); ?>',});"
                        >
                            <img src="<?= $mainPostPreviewThumbnailUrl ?>"
                                 alt="<?= get_the_title() ?>"
                                 title="<?= get_the_title() ?>"
                                 width="285" height="193"
                                 decoding="async"
                                 loading="lazy"
                                 srcset="<?= $mainPostPreviewThumbnailUrl ?> 1920w,
                                         <?= $mainPostPreviewThumbnailUrl__mobile ?> 1199w"
                            />
                        </a>
                    </div>
                    <div class="desc_block">
                        <a href="<?php the_permalink(); ?>" class="title"
                           title="<?= the_title() ?>"
                           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction':'подборки','eventLabel': '<?php the_title(); ?>',});"
                        >
                            <?php the_title(); ?>
                        </a>
                        <div class="info">
                            <?php the_content(); ?>
                        </div>
                        <div class="all_num_block">
                            <a href="<?php the_permalink(); ?>"
                               onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction':'подборки','eventLabel': '<?php the_title(); ?>',});"
                            >
                                <div class="num"><?php echo $post_count; ?></div>
                                <div class="st">
                                    <span>
                                        <?php echo post_count_text( $post_count ); ?>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php wp_reset_postdata(); ?>

        </div>
    </div>
</section>

<?php get_template_part( 'footer' ); ?>
