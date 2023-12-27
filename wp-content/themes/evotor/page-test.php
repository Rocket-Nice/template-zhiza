<?php

$args = [
    'post_type'  => 'post',
    'orderby'    => 'date',
    'posts_per_page' => 1,
    'order'      => 'ASC',
    'name' => 'prodavcam-tabaka-i-sigaret-zakonnye-sposoby-prodvizheniya-v-internete-i-na-tochke',
    'meta_query' => [
        [
            'key'   => 'use_new_design_all',
            'value' => '1',
            'compare' => '='
        ]
    ]
];
$newDesignPosts = new WP_Query( $args );

while($newDesignPosts->have_posts()):
    $newDesignPosts->the_post();
    $post_ = [
        'ID'            => esc_attr(get_the_ID()),
        'title'         => esc_html(get_the_title()),
        'link'          => esc_url(get_the_permalink()),
        'has_thumbnail' => esc_attr(has_post_thumbnail()),
        'thumbnail'     => wp_kses_post(get_the_post_thumbnail(get_the_ID(),'blog-small' )),
        'excerpt'       => esc_html(getPostExcerpt(get_the_ID())),
        'date'          => esc_attr(get_the_date( 'j F Y' ))
    ];

    $cat = get_the_category(get_the_ID())[0];
    $marketCatId = get_term_meta($cat->term_id, 'evotor_market_category_id')[0];

    $content = load_template_part('template_parts/test');
    $description = get_field( 'subheadline' );

    $market = new Market();
    $market->createPost([
        'title'       => $post_['title'],
        'description' => $description,
        'categoryId'  => $marketCatId,
        'type'        => 'internal',
        'accessType'  => 'public',
        'buttonTitle' => 'Посмотреть',
        'imgUrl'      => $post_['thumbnail'],
        'content'     => $content,
    ]);
endwhile;
