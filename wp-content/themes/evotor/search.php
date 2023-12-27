<?php
get_template_part( 'header_redesign' ); ?>

<?php
$sq          = get_search_query();
$searchQuery = $sq ?: '';
//
global $wp_query;
$page_ = get_current_page();
$b     = 0;
?>

<main class="page-content page-search" data-search-term="<?= $searchQuery ?>">
    <div class="empty-gray-section"></div>

    <section class="search-panel content-padding">
        <div class="new-wrapper relative">
            <form class="search-panel--input-wrapper" action="<?php bloginfo( 'url' ); ?>" method="GET">
                <input type="search" aria-label="Поиск" minlength="1" autocomplete="off"
                       autofocus formmethod="get" maxlength="1024" name="s" placeholder="Найти"
                       height="40" spellcheck="true" value="<?= $searchQuery ?>" tabindex="1"
                />
                <div class="wrap">
                    <div class="input-wrapper">
                        <input type="submit" width="97" height="40" value="Найти" tabindex="2"/>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php if ( have_posts() ): ?>
        <section class="found-posts-count content-padding">
            <div class="new-wrapper">
                <?php // TODO склонение слова результаты ?>
                <p>
                    <?= num_decline($wp_query->found_posts, 'результат, результата, результатов') ?>
                </p>
            </div>
        </section>

        <section class="found-results content-padding <?= ((int) $wp_query->max_num_pages) === 1 ? 'bottom-offset' : '' ?>">
            <div class="new-wrapper post--list">
                <?php while ( have_posts() ): the_post(); ?>
                    <?php get_template_part( 'template_parts/search/search-result-item' ); ?>
                <?php endwhile; ?>
            </div>
        </section>

        <?php if ( $wp_query->max_num_pages > 1 ): ?>
            <section class="new-wrapper">
                <div class="paginator" data-max_pages="<?= $wp_query->max_num_pages ?>" data-current="<?= $page_ ?>">
                    <?php
                    $paginatorArgs = [
                        'format'    => "?pg=%#%&s={$sq}",
                        'base'      => get_pagenum_link( 1 ) . '%_%',
                        'type'      => 'plain',
                        'show_all'  => false,
                        'end_size'  => 1,
                        'mid_size'  => 1,
                        'current'   => $page_,
                        'total'     => $wp_query->max_num_pages,
                        'prev_next' => false,
                        'prev_text' => "<div class='back-arrow'></div>",
                        'next_text' => "<div class='next-arrow'></div>",
                    ];
                    $paginate      = paginate_links( $paginatorArgs );
                    echo $paginate; ?>
                </div>
            </section>
        <?php endif; ?>
    <?php else: ?>
        <?php get_template_part( 'template_parts/search/no-results' ); ?>
    <?php endif; ?>
</main>

<?php get_template_part( 'footer_redesign' ); ?>
