<?php

/**
 * Возвращает количество выбранных постов в кастомном посте Коллекции, выбранных в поле Статьи.
 * @return int Количество выбранных постов
 */
function getCountPostsInCategory() : int {
    global $wp_query;
    // Категории - Деньги, провалы и др.
    $categoryName = null;
    $category = get_category( get_query_var( 'cat' ) );

    $args = [
        'post_type' => 'post',
        'cat' => $category->cat_ID,
        'post_status' => 'publish',
        'posts_per_page' => -1,
    ];
    $query = new WP_Query($args); // Получим коллекцию с таким url
    //
    return $query->post_count;
}


// Регистрация обработки кастомной переменной
function register_custom_yoast_variables__countPostsInCategory() {
    wpseo_register_var_replacement( '%%countpostsInCategory%%', 'getCountPostsInCategory',
        'advanced' );
}

add_action('wpseo_register_extra_replacements', 'register_custom_yoast_variables__countPostsInCategory');


function modifyText($basic, $content, int $page) : string{
    if ($page > 1) {
        return $basic . $content;
    }

    return $basic;
}

function categoryYoastSeoTitle($basicText) {
    global $wp_query;
    global $post;
    $page = array_key_exists('page', $wp_query->query_vars) ? $wp_query->query_vars['page'] : 1;
    if (is_null($page)) {
        $page = 1;
    }

    if ($wp_query->is_category || in_array(get_post_type(), ['collections', 'benefits'])) {
        return modifyText($basicText, ' - Страница ' . $page, $page);
    }

    return $basicText;
}
add_filter('wpseo_title','categoryYoastSeoTitle',100,1);
add_filter('wpseo_metadesc','categoryYoastSeoTitle',100,1);
add_filter( 'wpseo_opengraph_title', 'categoryYoastSeoTitle' );
add_filter( 'wpseo_opengraph_desc', 'categoryYoastSeoTitle' );

function modifyCanonicalSeo(string $url) : string {
    global $wp_query;
    $page = array_key_exists('page', $wp_query->query_vars) ? $wp_query->query_vars['page'] : 1;
    if (is_null($page)) {
        $page = 1;
    }

    if ($wp_query->is_category || in_array(get_post_type(), ['collections', 'benefits'])) {
        return modifyText($url, '?page=' . $page, $page);
    }

    return $url;
}

add_filter( 'wpseo_canonical', 'modifyCanonicalSeo' );
add_filter( 'wpseo_opengraph_url', 'modifyCanonicalSeo' );
