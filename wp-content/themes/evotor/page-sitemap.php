<?php get_template_part( 'header_redesign' ); ?>

<?php
// Удаляем дефолтную сортировку. Там стоит всегда menu_order первый, что не позволяет нормально сортировать по заголовку.
remove_all_filters('posts_orderby');
$posts = new WP_Query(array(
    'post_type' => 'collections',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => [
        'title' => 'ASC',
        'menu_order' => 'ASC'
    ],
) );
?>

<section class="sitemap">
    <div class="wrapper">
        <h1>
            Карта сайта
        </h1>

        <ul class="pages-list">
            <li class="long-arrow">
                <a href="/">
                    Главная
                </a>
            </li>
            <li>
                <ul class="pages-list">
                    <li class="minus-arrow">
                        <a href="/category/theory/">
                            Законы
                        </a>
                    </li>
                    <li class="minus-arrow">
                        <a href="/category/practice/">
                            Истории
                        </a>
                    </li>
                    <li class="minus-arrow">
                        <a href="/category/money/">
                            Деньги
                        </a>
                    </li>
                    <li class="minus-arrow">
                        <a href="/category/provaly/">
                            Провалы
                        </a>
                    </li>
                    <li class="minus-arrow">
                        <a href="/benefits/">
                            Польза
                        </a>
                    </li>
                    <li class="minus-arrow">
                        <a href="/collections/">
                            Подборки
                        </a>
                    </li>
                    <li>
                        <ul class="pages-list">
                            <?php while ($posts->have_posts()): $posts->the_post(); ?>
                                <li class="angle-arrow">
                                    <a href="<?= get_permalink() ?>">
                                        <?= the_title() ?>
                                    </a>

                                    <?php $postsInCollections = get_field('select_posts'); ?>
                                    <ul class="posts-list">
                                        <?php foreach ($postsInCollections as $p): ?>
                                            <li class="minus-arrow">
                                                <a href="<?= get_permalink($p) ?>">
                                                    <?= get_the_title($p) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="long-arrow">
                <a href="/o-proekte">
                    О проекте
                </a>
            </li>
        </ul>
    </div>
</section>


<?php get_template_part( 'footer' ); ?>
