<?php

/**
 * Здесь происходит очень странная магия. Если поисковый запрос содержит двойные или одинарные
 * кавычки, производится переадресовка на главную страницу.
 * Это работает как на фронтовом поиске, так и в поиске по админке.
 */
//if ( isset( $_GET['s'] ) ) {
//    if ( strpos( $_GET['s'], '"' ) !== false || strpos( $_GET['s'], "'" ) !== false ) {
//        exit( "<meta http-equiv='refresh' content='0; url=/'>" );
//    }
//}


/**
 * Преобразует специальные символы в html сущности.
 * - '&' (амперсанд) преобразуется в '&amp;'
 * - '"' (двойная кавычка) преобразуется в '&quot;' в режиме ENT_NOQUOTES is not set.
 * - "'" (одиночная кавычка) преобразуется в '&#039;' (или &apos;) только в режиме ENT_QUOTES.
 * - '<' (знак "меньше чем") преобразуется в '&lt;'
 * - '>' (знак "больше чем") преобразуется в '&gt;'
 */
//if ( isset( $_POST['search'] ) ) {
//    $my_str = sanitize_text_field( $_POST['search'] );
//    $my_str = htmlspecialchars( strip_tags( $my_str ) );
//    exit( "<meta http-equiv='refresh' content='0; url=/?s=" . $my_str . "'>" );
//}


add_filter( 'get_search_query', 'filter_get_search_query' );
/**
 * Очищает входную строку поиска от различных тегов, ошибок кодировки UTF-8, переносы строк и т.д.
 *
 * @param $get_query_var
 *
 * @return string
 */
function filter_get_search_query( $get_query_var ) : string {
    return ( sanitize_text_field( $get_query_var ) );
}


add_action( 'pre_get_posts', 'search_filter' );
/**
 * Вытягиваем из GET параметров текущую страницу. И устанавливаем по умолчанию 10 страниц
 *
 * @param $query
 *
 * @return void
 */
function search_filter( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {
        if ( $query->is_search ) {
            $currentPage = get_current_page();
            $query->set( 'paged', $currentPage ?: 1 );
            $query->set( 'relevanssi', true );
            $query->set( 'posts_per_page', 10 ); // Можно использовать значение из админки. Но нет запроса на это сейчас.
        }
    }
}


add_filter( "pre_get_posts", "include_search_filter" );
/**
 * Поиск только по типу записей - Посты.
 *
 * @param WP_Query $query
 *
 * @return WP_Query
 */
function include_search_filter( WP_Query $query ) : WP_Query {
    if ( ! is_admin() && $query->is_main_query() && $query->is_search ) {
        $query->set( "post_type", "post" );
        $query->set( 'post_status', [ 'publish' ] );
    }

    return $query;
}


add_filter( "pre_get_posts", "my_exclude_category_search_filter" );
/**
 * Из поиска должны быть скрыты статьи, у которых есть рублика Скрыто(slug=hide).
 *
 * @param WP_Query $query
 *
 * @return WP_Query
 */
function my_exclude_category_search_filter( WP_Query $query ) : WP_Query {
    if ( $query->is_search ) {
        $cat = get_category_by_slug( 'hide' );
        $id  = $cat->term_id;
        $query->set( "category__not_in", [ $id ] );
    }

    return $query;
}


//add_filter( 'posts_join', 'cf_search_join' );
function cf_search_join( $join ) {
    global $wpdb;
    if ( isSearchQuery() ) {
        $join .= " LEFT JOIN $wpdb->postmeta ON ID = $wpdb->postmeta.post_id ";
    }

    return $join;
}


//add_filter( 'posts_where', 'cf_search_where' );
function cf_search_where( $where ) {
    global $wpdb;
    if ( isSearchQuery() ) {
        $where = preg_replace( "/\(\s*$wpdb->posts.post_title\s+LIKE\s*('[^']+')\s*\)/", "($wpdb->posts.post_title LIKE $1) OR ($wpdb->postmeta.meta_value LIKE $1)", $where );
    }

    return $where;
}


//add_filter( 'posts_distinct', 'cf_search_distinct' );
function cf_search_distinct( $where ) {
    return isSearchQuery() ? 'DISTINCT' : $where;
}


add_filter( 'relevanssi_modify_wp_query', 'rlv_asc_date' );
function rlv_asc_date( $query ) {
//    $query->set( 'orderby', 'post_date' );
//    $query->set( 'order', 'DESC' );

    return $query;
}

/**
 * Проверка, является ли это запрос кастомным запросом поиска.
 * @return bool
 */
function isSearchQuery() : bool {
    return is_search() || ( array_key_exists( 'action', $_POST ) && $_POST['action'] === 'search_page_next_page' );
}


add_filter( 'get_pagenum_link', 'edit_paginate_url_for_home_page' );
/**
 * При ajax запросах в paginate_links для 1 страницы вставлялся wp-admin/ajax.
 * Что не корректно, и для конкретного запроса исправляем на путь до корня проекта.
 *
 * @param $url
 *
 * @return array|mixed|string|string[]|null
 */
function edit_paginate_url_for_home_page( $url ) {
    $b = 0;
    if ( isSearchQuery() ) {
        $site = home_url();
        $add  = '';

        return preg_replace( "@$site/(.*)@", "$site/$add\1", $url );
    }

    return $url;
}


//add_filter( 'relevanssi_excerpt_part', 'rlv_excerpt_parts', 10, 2 );
function rlv_excerpt_parts( $excerpt_text, $excerpt ) {
    $re = '#[www\.|https?://|//|/]*[a-z0-9]+\.[a-z0-9]{1,12}\S*#m';
    /* Сначала нужно найти вообще все имеющиеся в тексте ссылки. */
    $links = []; // В этом массиве будет список всех ссылок.
    preg_match_all( $re, $excerpt_text, $links ); // Поиск ссылок.
    $links = array_multi_to_linear( $links );

    return str_replace( $links, '', $excerpt_text );
}


add_filter( 'relevanssi_index_custom_fields', 'rlv_skip_custom_fields' );
/**
 * Добавляет в индексирование только избранные вручную поля.
 *
 * @param array|null $custom_fields
 *
 * @return array
 */
function rlv_skip_custom_fields( ?array $custom_fields ) : array {

    $diff2 = array_filter( $custom_fields, static function( $field ) {
        $wanted_fields = [
            '_page_text', // Конструктор - Текст \ (нет заголовка)
            '_page_table', // Конструктор - Таблица \ (нет заголовка)
            'subheadline',
            'expert_name', //,
            'editor_name', //,
            '_page_text_bn_text', //,
        ];
        foreach ( $wanted_fields as $suffix ) {
            $suffix_length = strlen( $suffix );
            if ( $suffix === substr( $field, - $suffix_length ) ) {
                return true;
            }
        }

        return false;
    } );
    $b = 0;

    return $diff2;
}
