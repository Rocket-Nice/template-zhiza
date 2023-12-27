<?php
global $post;
global $wp_query;
//
get_template_part( 'header_redesign' );

$authorSlug = $wp_query->query['post_author'];
/** @var WP_Term $author */
$author = get_term_by('slug', $authorSlug, 'post_author'); // Имя уже на кириллице
$name = $author->name;
$haveDesc = !empty($author->description);
//
$term = get_queried_object();
//
$image = get_field('author_image', $term);
$haveImg = empty($image) ? 'no-image--padding' : '';
$imageUrl = '';
if (!empty($image)) {
    $imageUrl = $image['sizes']['collection_circle'];
}
//
$perPage = 10;
$page_ = 1;
if ( isset( $_GET['pg'] ) ) {
    $page_ = (int) $_GET['pg'] ?: 1;
}
//
$postQuery = [
    'post_type' => 'post',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => $perPage,
    'paged' => $page_,
    'tax_query' => [
        [
            'taxonomy' => 'post_author',
            'field' => 'slug',
            'terms' => $authorSlug,
        ]
    ]
]
?>

<script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Person",
        "name": "<?= $name ?>",
        "image": "<?= $imageUrl ?>",
        "jobTitle": "журналист",
        "url": "<?= get_site_url() . '/o-proekte/' . $authorSlug ?>",
        "worksFor": {
            "@type": "Organization",
            "name": "«Жиза» — бизнес-блог для предпринимателей"
        }
    }
</script>


<main class="page-content page-author" data-author_slug="<?= $authorSlug ?>" data-post_type="<?= get_post_type() ?>">
    <section class="about--author">
        <section class="new-wrapper content-padding">
            <div class="breadcrumbs">
                <?php get_breadcrumb('page--style') ?>
            </div>

            <div class="author--info <?= $haveImg ?>">
                <div class="photo">
                    <img src="<?= $imageUrl ?>" alt="<?= $name ?>" title="<?= $name ?>"
                         width="128" height="128" loading="lazy" decoding="async" />
                </div>
                <h1 class="title f-32">
                    <?= $name ?>
                </h1>
                <p class="description">
                    <?= $author->description ?>
                </p>
            </div>
        </section>
    </section>

    <section class="new-wrapper content-padding author--posts">
        <h2 class="section--title f-32">Статьи автора</h2>

        <?php $query = new WP_Query($postQuery); ?>
        <ul class="post--list">
            <?php
            while ( $query->have_posts() ) {
                $query->the_post();
                get_template_part('template_parts/author/author-post-item');
            }
            wp_reset_query(); ?>
        </ul>

        <?php if ( $query->max_num_pages > 1 ): ?>
            <section class="new-wrapper">
                <div class="paginator" data-max_pages="<?= $query->max_num_pages ?>" data-current="<?= $page_ ?>">
                    <?php
                    $paginatorArgs = [
                        'format'    => '?pg=%#%',
                        'type'      => 'plain',
                        'show_all'  => true,
                        'current'   => $page_,
                        'total'     => $query->max_num_pages,
                        'prev_next' => false,
                        'prev_text' => "<div class='back-arrow'></div>",
                        'next_text' => "<div class='next-arrow'></div>",
                    ];
                    $paginate      = paginate_links( $paginatorArgs );
                    echo $paginate; ?>
                </div>
            </section>
        <?php endif; ?>
    </section>
</main>

<?php get_template_part( 'footer_redesign' ); ?>
