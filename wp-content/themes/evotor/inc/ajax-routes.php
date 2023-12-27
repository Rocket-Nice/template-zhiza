<?php

add_action( 'wp_ajax_collections_next_page', 'fn_collections_next_page' );
add_action( 'wp_ajax_nopriv_collections_next_page', 'fn_collections_next_page' );
/**
 * Обработчик получения карточек постов для страницы collections или benefits.
 * Входные параметры POST:
 * @return void
 * @var int $_POST ['postId']
 * @var string $_POST ['postType']
 * @var string $_POST ['page']
 */
function fn_collections_next_page() {
    try {
        $page     = stringToInt( $_POST['page'] ) ?? 1;
        $postId   = stringToInt( $_POST['postId'] );
        $postType = $_POST['postType'];
        //
        $p      = new WP_Query( [
            'p'         => $postId,
            'post_type' => $postType,
        ] );
        $output = '';
        //
        $p->the_post();
        $selectedPosts = get_field( 'select_posts' );
        //
        $queryArg = array(
            'post_type'      => 'post',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'posts_per_page' => 20,
            'post__in'       => $selectedPosts,
            'paged'          => $page
        );
        wp_reset_postdata();
        //
        $postObj = new WP_Query( $queryArg );
        $i       = 0;

        while ( $postObj->have_posts() ) {
            $postObj->the_post();
            $i ++;
            ob_start();
            get_template_part( 'template_parts/collections/redesign-collection-post-item', null, [
                'i' => $i,
            ] );
            $output .= ob_get_clean();
        }
        //
        wp_send_json( [
            'status' => true,
            'data'   => [
                'items' => $output
            ],
        ] );
    } catch ( Exception $e ) {
        wp_send_json( [
            'status'  => false,
            'message' => $e->getMessage(),
        ], 400 );
    }
}


/**
 * Конвертирует строковую переменную в булев тип
 *
 * @param string $str
 *
 * @return boolean
 */
function stringToBoolean( string $str ) : bool {
    return filter_var( $str, FILTER_VALIDATE_BOOLEAN );
}


/**
 * Конвертирует строковую переменную в числовое значение
 *
 * @param string $str
 *
 * @return int|false
 */
function stringToInt( string $str ) {
    return filter_var( $str, FILTER_VALIDATE_INT );
}


add_action( 'wp_ajax_random_collection', 'fn_get_random_collection' );
add_action( 'wp_ajax_nopriv_random_collection', 'fn_get_random_collection' );
function fn_get_random_collection() {
    $queryArg  = array(
        'post_type'          => 'collections',
        'orderby'            => 'rand',
        'posts_per_page'     => 1,
        // Игнорирование фильтров и фильтрации по menu.order.
        'suppress_filters'   => true,
        'ignore_custom_sort' => true,
    );
    $postObj   = new WP_Query( $queryArg );
    $postImage = get_the_post_thumbnail_url( $postObj->post, 'preview-newest-post' );
    //
    $selectedPosts          = get_field( 'select_posts', $postObj->post );
    $queryArg               = array(
        'post_type'      => 'post',
        'orderby'        => 'date',
        'order'          => 'DESC',
        'posts_per_page' => 3,
        'post__in'       => $selectedPosts,
    );
    $newestPostOfCollection = new WP_Query( $queryArg );

    $postsData = [];
    foreach ( $newestPostOfCollection->posts as $p ) {
        $postsData[] = [
            'title' => $p->post_title,
            'link'  => get_permalink( $p ),
            'date'  => get_the_date( 'j F Y', $p ),
        ];
    }

    wp_send_json( [
        'status' => true,
        'data'   => [
            'image'       => $postImage,
            'posts'       => $postsData,
            'title'       => $postObj->post->post_title,
            'link'        => get_permalink( $postObj->post ),
            'description' => $postObj->post->post_content,
        ],
    ] );
}


add_action( 'wp_ajax_author_page_next_page', 'fn_author_page_next_page' );
add_action( 'wp_ajax_nopriv_author_page_next_page', 'fn_author_page_next_page' );
/**
 * Обработчик получения карточек постов для страницы collections или benefits.
 * Входные параметры POST:
 * @return void
 * @var int $_POST ['authorSlug'] Слаг автора для поиска статей
 * @var string $_POST ['postType']
 * @var string $_POST ['page'] Номер страницы для загрузки
 */
function fn_author_page_next_page() {
    try {
        $page       = stringToInt( $_POST['page'] ) ?? 1;
        $authorSlug = $_POST['authorSlug'];
        $postType   = $_POST['postType'];
        $postQuery  = [
            'post_type'      => 'post',
            'orderby'        => 'date',
            'order'          => 'DESC',
            'posts_per_page' => 10,
            'paged'          => $page,
            'tax_query'      => [
                [
                    'taxonomy' => 'post_author',
                    'field'    => 'slug',
                    'terms'    => $authorSlug,
                ]
            ]
        ];
        $query      = new WP_Query( $postQuery );//
        $output     = '';
        while ( $query->have_posts() ) {
            $query->the_post();
            ob_start();
            get_template_part( 'template_parts/author/author-post-item' );
            $output .= ob_get_clean();
        }
        wp_reset_query();
        wp_send_json( [
            'status' => true,
            'data'   => [
                'items' => $output
            ],
        ] );
    } catch ( Exception $ex ) {
        wp_send_json( [
            'status'  => false,
            'message' => $ex->getMessage(),
        ], 400 );
    }

}


add_action( 'wp_ajax_search_page_next_page', 'fn_search_page_next_page_next_page' );
add_action( 'wp_ajax_nopriv_search_page_next_page', 'fn_search_page_next_page_next_page' );
/**
 * Обработчик получения карточек постов для страницы collections или benefits.
 * Входные параметры POST:
 * @return void
 * @var string $_POST ['searchTerm'] Искомое пользователем фраза.
 * @var string $_POST ['page'] Номер страницы для загрузки.
 */
function fn_search_page_next_page_next_page() {
    try {
        global $wp;
        $page       = stringToInt( $_POST['page'] ) ?? 1;
        $searchTerm = $_POST['searchTerm'];
        $args = [
            's'                  => $searchTerm,
            'paged'              => $page,
            'posts_per_page'     => 10,
            'post_type'          => 'post',
            'post_status'        => [ 'publish' ],
            'orderby'            => 'post_date',
            'order'              => 'DESC',
            'ignore_custom_sort' => true,
            'relevanssi'         => true,
        ];
        $the_query = new WP_Query($args);
        $output     = '';
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            ob_start();
            get_template_part( 'template_parts/search/search-result-item' );
            $output .= ob_get_clean();
        }
        wp_reset_query();

        $paginatorArgs = [
            'format'    => "?pg=%#%&s={$searchTerm}",
            'base'      => get_pagenum_link( 1 ) . '%_%',
            'type'      => 'plain',
            'show_all'  => false,
            'end_size'  => 1,
            'mid_size'  => 1,
            'current'   => $page,
            'total'     => $the_query->max_num_pages,
            'prev_next' => false,
        ];
        $paginate = paginate_links( $paginatorArgs );

        wp_send_json( [
            'status' => true,
            'data'   => [
                'items' => $output,
                'paginate' => $paginate,
            ],
        ] );
    } catch ( Exception $ex ) {
        wp_send_json( [
            'status'  => false,
            'message' => $ex->getMessage(),
        ], 400 );
    }
}

add_action( 'wp_ajax_partial_search_term', 'fn_search_partial_search_term' );
add_action( 'wp_ajax_nopriv_partial_search_term', 'fn_search_partial_search_term' );
/**
 * Обработчик получения карточек постов для страницы collections или benefits.
 * Входные параметры POST:
 * @return void
 * @var string $_POST ['searchTerm'] Искомое пользователем фраза.
 */
function fn_search_partial_search_term() {
    try {
        $searchTerm = $_POST['searchTerm'];
        $args = [
            's'                  => $searchTerm,
            'posts_per_page'     => 5,
            'post_type'          => 'post',
            'post_status'        => [ 'publish' ],
            'relevanssi'         => true,
        ];
        $the_query = new WP_Query($args);
        $output     = [];
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $url = get_the_permalink(get_the_ID());
            $output[] = [
                'title' => $the_query->post->post_highlighted_title,
                'url' => $url,
            ];
        }
        wp_reset_query();
        //
        wp_send_json( [
            'status' => true,
            'data'   => [
                'posts' => $output,
                'found' => $the_query->post_count,
            ],
        ] );
    } catch ( Exception $ex ) {
        wp_send_json( [
            'status'  => false,
            'message' => $ex->getMessage(),
        ], 400 );
    }
};
