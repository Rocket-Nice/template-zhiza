<?php

require_once ('seo/collections.php');
require_once ('seo/category.php');
require_once ('seo/authorPosts.php');

/**
 * Отключение предупреждения в консоли Яндекс.Метрики о том, что
 * атрибут article не определён.
 * @param $lang
 * @return array|string|string[]|null
 */
function artabr_opengraph_fix_yandex($lang) {
    $lang_prefix = 'prefix="og: http://ogp.me/ns# article: http://ogp.me/ns/article#  profile: http://ogp.me/ns/profile# fb: http://ogp.me/ns/fb#"';
    $lang_fix = preg_replace('!prefix="(.*?)"!si', $lang_prefix, $lang);
    return $lang_fix;
}
add_filter( 'language_attributes', 'artabr_opengraph_fix_yandex', 20, 1);

/**
 * Отключить Schema.org из плагина Yoast.SEO
 */
add_filter( 'wpseo_json_ld_output', '__return_false' );

/**
 * @param $postID - post ID
 *
 * @return array Существующих для поста авторов массивом, с тиком Person
 */
function postSchemaOrgAuthors($postID) : array {
    global $post;

    $authorsPrefixes = ['author', 'expert', 'editor'];
    $existed = [];
    //
    foreach ($authorsPrefixes as $slug) {
        $authorName = trim( get_post_meta($postID, $slug . '_name', true) );
        $link = !empty($authorName) ? get_post_meta($postID, $slug . '_link', true) : '';
        //
        $authorTaxonomy = wp_get_post_terms($post->ID,'post_author');
        if ($slug === 'author' && count($authorTaxonomy) > 0) {
            /** @var WP_Term $author */
            $author = $authorTaxonomy[0];
            //
            $authorName = $author->name;
            $link = get_site_url() . '/o-proekte/' . $author->slug;
        }

        if (!empty($authorName)) {
            $existed[] = [
                '@type' => 'Person',
                'name' => $authorName,
                'url'  => $link,
            ];
        }
    }
    //
    return $existed;
}

/**
 * @param $postID - post ID
 * @param $slug - префикс автора
 *
 * @return array
 */
function postSchemaOrgAuthorSingle($postID, $slug) : array {
    $authorName = trim( get_post_meta($postID, $slug . '_name', true) );
    //
    $link = !empty($authorName) ? get_post_meta($postID, $slug . '_link', true) : '';

    return [
        'name' => $authorName,
        'url' => $link,
    ];
}



if ( ! function_exists( 'wp_add_page_number' ) ) {
    function wp_add_page_number( $s ) {
        global $page;
        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        ! empty ( $page ) && 1 < $page && $paged = $page;
        $paged > 1 && $s .= sprintf( __( ' - Страница %s' ), $paged );

        return $s;
    }

    add_filter( 'wpseo_metadata', 'wp_add_page_number', 100, 1 );
}


/**
 *
 *
 * Данный раздел добавляет для страниц Коллекции, Польза префикс
 * " - Страница %page% "
 * в Заголовок, Описание, Описание-OpenGraph, Заголовок OpenGraph
 *
 *
 */


/**
 * Если это single страницы коллекций или пользы, то для не первой страницы
 * в canonical вставляется ссылка с пагинацией на текущую страницу.
 * Например, будет:
 * ```html
 * <link rel="canonical" href="http://zhiza.local/collections/chtoby-ne-shtrafovali/?pg=2">
 * вместо
 * <link rel="canonical" href="http://zhiza.local/collections/chtoby-ne-shtrafovali/">
 * ```
 * @param string $url
 *
 * @return string
 */
function design_canonical( string $url) : string {
    global $post;
    $pg = $_REQUEST['pg'] ?? '';
    return changeYoastSeoDataInCollections($url, '?pg=' . $pg);
}
add_filter( 'wpseo_canonical', 'design_canonical' );
add_filter( 'wpseo_opengraph_url', 'design_canonical' );


function changeYoastSeoDataInCollections($basic, $content) {
    if ((is_single() && in_array(get_post_type(), ['collections', 'benefits'])) || is_tax('post_author')) {
        $params = '';
        if (isset($_REQUEST['pg']) && $_REQUEST['pg'] !== '1') {
            $params .= $content;
        }
        return $basic . $params;
    }
    return $basic;
}


function collections_benefits_yoastseo_title($title) {
    global $post;
    $pg = $_REQUEST['pg'] ?? '';
    return changeYoastSeoDataInCollections($title, ' – Страница ' . $pg);
}
add_filter( 'wpseo_title', 'collections_benefits_yoastseo_title' );
add_filter('wpseo_metadesc','collections_benefits_yoastseo_title',100,1);
add_filter( 'wpseo_opengraph_title', 'collections_benefits_yoastseo_title' );
add_filter( 'wpseo_opengraph_desc', 'collections_benefits_yoastseo_title' );

/**
 *
 *
 * Конец раздела работы с SEO для Коллекций и Пользы
 *
 *
 */
