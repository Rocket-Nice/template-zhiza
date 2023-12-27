<div class="menu_wrapper">
    <div class="m_nav">
        <?php wp_nav_menu( array(
            'theme_location'  => 'top-pages-menu',
            'container_class' => '',
            'menu_class'      => '',
            'container'       => '',
        ) );
        ?>
    </div>

    <div class="s_select">
        <p class="name">Подборки</p>
        <?php
        $args = array(
            'post_type'      => 'collections',
            'posts_per_page' => 3,
        );
        query_posts( $args );
        while ( have_posts() ) {
            the_post(); ?>
            <?php
            $post_count = count( get_field( 'select_posts' ) );
            //
            $mainPostPreviewThumbnailUrl = get_the_post_thumbnail_url($post, 'circle-post');
            ?>
            <div class="once">
                <div class="img_block">
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?= $mainPostPreviewThumbnailUrl ?>"
                             alt="<?= get_the_title() ?>"
                             width="30" height="30"
                             loading="lazy"
                        />
                    </a>
                </div>
                <div class="desc_blcok">
                    <a href="<?php the_permalink(); ?>">
                        <div class="title"><?php the_title(); ?></div>
                        <div class="info">
                            <?php echo $post_count; ?> <?php echo post_count_text($post_count); ?>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
        <?php wp_reset_postdata(); ?>
        <?php wp_reset_query(); ?>
        <?php $all_coll_coutn = wp_count_posts('collections')->publish; ?>
        <a href="/collections/"
           class="m_all_pd">Все <?php echo $all_coll_coutn; ?> <?php echo collections_count_text($all_coll_coutn); ?></a>
    </div>

    <div class="n_sub">
        <div class="m_sub_soc">
            <ul>
                <li>
                    <a href="https://t.me/Zhizzzzza" target="_blanc"
                       rel="noopener nofollow"
                    >
                        <img src="<?php echo bloginfo( 'template_url' ); ?>/images/main_page/tel_icon_color.svg"
                             alt="" loading='lazy' width="38" height="38">
                    </a>
                </li>
                <li>
                    <a href="https://vk.com/zhizzzzza" target="_blanc"
                       rel="noopener nofollow"
                    >
                        <img src="<?php echo bloginfo( 'template_url' ); ?>/images/main_page/vk_icon_color.svg"
                             alt="" loading='lazy' width="38" height="38"></a>
                </li>
            </ul>
        </div>
    </div>
</div>
