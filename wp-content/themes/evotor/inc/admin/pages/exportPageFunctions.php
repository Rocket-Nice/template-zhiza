<?php

function my_admin_menu() {
    add_menu_page(
        'Экспорт статей в маркет',
        'Экспорт статей',
        'manage_options',
        'sample-page',
        'my_admin_page_contents',
        'dashicons-database-export',
        90
    );
}

add_action( 'admin_menu', 'my_admin_menu' );

/**
 * Рисует страницу экспорта статей
 */
function my_admin_page_contents() {
    get_template_part( 'inc/admin/pages/exportPages' );
}

/**
 * AJAX обработчики
 */

add_action('wp_ajax_getPosts', 'getExportPosts');
/**
 * Возвращает ID всех постов, которые необходимо отправить в Маркет.
 */
function getExportPosts() {
    $args = [
        'post_type'      => 'post',
        'orderby'        => 'date',
        'order'          => 'ASC', // должно быть ASC
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'suppress_filters' => true,
        'ignore_custom_sort' => true,
        'meta_query' => [
            'relation' => 'AND',
            [
                'key'   => 'use_new_design_all',
                'value' => '1',
                'compare' => '='
            ],
            [
                'key'   => 'export_post_to_market',
                'value' => '1',
                'compare' => '='
            ]
        ],
        'category__in' => [
            20, // Провалы
            6, // Деньги
            8, // Законы
        ]
    ];

    $newDesignPosts = new WP_Query( $args );

    $payload = [];
    while ( $newDesignPosts->have_posts() ) {
        $newDesignPosts->the_post();
        //
        $payload[] = [
            'title' => esc_html(get_the_title()),
            'ID'    => esc_html(get_the_ID()),
        ];
    }
    //
    wp_reset_postdata();
    //
    try {
        wp_send_json($payload);
    } catch ( JsonException $e ) {
        echo $e;
    }
}


add_action('wp_ajax_getNewPosts', 'getNewPost');
function getNewPost() {
    $args = [
        'post_type'      => 'post',
        'orderby'        => 'date',
        'order'          => 'ASC', // должно быть ASC
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'suppress_filters' => true,
        'ignore_custom_sort' => true,
        'meta_query' => [
            'relation' => 'AND',
            [
                'relation' => 'OR',
                [
                    'key'   => 'id_market_post',
                    'compare' => 'NOT EXISTS'
                ],
                [
                    'key'   => 'id_market_post',
                    'value' => '',
                    'compare' => '='
                ]
            ],
            [
                'key'   => 'export_post_to_market',
                'value' => '1',
                'compare' => '='
            ]
        ],
        'category__in' => [
            20, // Провалы
            6, // Деньги
            8, // Законы
        ]
    ];

    $newDesignPosts = new WP_Query( $args );

    $payload = [];
    while ( $newDesignPosts->have_posts() ) {
        $newDesignPosts->the_post();
        //
        $payload[] = [
            'title' => esc_html(get_the_title()),
            'ID'    => esc_html(get_the_ID()),
        ];
    }
    //
    wp_reset_postdata();
    //
    try {
        wp_send_json($payload);
    } catch ( JsonException $e ) {
        echo $e;
    }
}


add_filter( 'the_excerpt', function( $excerpt ) {
    return str_replace( [ '&nbsp; ', '&nbsp;' ], ' ', $excerpt );
}, 999, 1 );


/**
 * Получить данные поста по его ID.
 */
add_action('wp_ajax_getPostData', 'getPostData');
function getPostData() {
    //
    $postId = $_POST['ID'];
    //
    $post_object = new WP_Query([
        'p'         => $postId,
        'post_type' => 'post',
    ]);
    $post_object->the_post();
    //
    $cat = get_the_category(get_the_ID())[0];
    $marketCatId = get_term_meta($cat->term_id, 'evotor_market_category_id')[0];

    $content = load_template_part('template_parts/test');
    // Очистка от инлайновых стилей.
    $content = preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3', $content);
    //
    $imgUrl = wp_kses_post(get_the_post_thumbnail_url(get_the_ID(),'blog-small' ));

    $post_ = [
        'ID'         => esc_attr(get_the_ID()),
        'content'    => $content,
        'marketId'   => get_field('id_market_post', get_the_ID()),
        'title'      => str_replace( [ '&nbsp; ', '&nbsp;' ], ' ', wp_filter_nohtml_kses(get_the_title()) ),
        'thumbnail'  => [
            'url'         => $imgUrl,
            'marketImgId' => get_field('url_image_market_post', esc_attr(get_the_ID())),
        ],
        'excerpt'    => str_replace( [ '&nbsp; ', '&nbsp;' ], ' ', wp_filter_nohtml_kses(getPostExcerpt(get_the_ID())) ),
        'date'       => esc_attr(get_post_timestamp() * 1000),
        'categoryId' => $marketCatId,
    ];

    wp_send_json($post_);
}


add_action('wp_ajax_getBasicToken', 'getBasicToken');
function getBasicToken() {
    $env = $_GET['env'];
    //
    if ($env === 'test') {
        wp_send_json([
            'token' => MARKET_BASIC_TOKEN_TEST,
        ]);
    } else {
        wp_send_json([
            'token' => MARKET_BASIC_TOKEN_PROD,
        ]);
    }
}


add_action('wp_ajax_updatePostMeta', 'updatePostMeta');
function updatePostMeta() {
    $postID = $_POST['postID'];
    $metaValue = $_POST['metaValue'];
    $metaName = $_POST['metaName'];
    //
    $status = update_post_meta(
        $postID,
        $metaName,
        $metaValue
    );
    //
    wp_send_json([
        'status' => (boolean) $status,
        'message' => ((boolean) $status) ? 'ID поста маркета сохранен.' : 'Ошибка сохранения ID поста маркета.',
    ]);
}


add_action('wp_ajax_getFile', 'getFile');
function getFile() {
    $postID = $_POST['postID'];
    //
    $id_market_post = get_field('id_market_post', $postID);
    $url_image_market_post = get_field('url_image_market_post', $postID);
    //
    $url = wp_kses_post(get_the_post_thumbnail_url($postID,'blog-small' ));
    $uploads = wp_upload_dir();
    $file_path = str_replace( $uploads['baseurl'], $uploads['basedir'], $url );
    //
    wp_send_json([
        'url' => $url,
    ]);
}
