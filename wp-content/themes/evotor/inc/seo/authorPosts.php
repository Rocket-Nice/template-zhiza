<?php

/**
 * Блок посвящённый работе с SEO страницы Страница автора
 */

// Регистрация обработки кастомной переменной
function register_yoast_var_countAuthorPost() {
    wpseo_register_var_replacement( '%%countAuthorPost%%', 'getCountAuthorPosts',
        'advanced' );
}
/**
 * Возвращает количество постов автора.
 * @return int Количество выбранных постов
 */
function getCountAuthorPosts() : int {
    global $wp_query;
    $authorSlug = $wp_query->query['post_author'];
    $postQuery = [
        'post_type' => 'post',
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'post_author',
                'field' => 'slug',
                'terms' => $authorSlug,
            ]
        ]
    ];

    // Количество постов у автора, в которых он указан как таксономия.
    return ( new WP_Query( $postQuery ) )->post_count;
}
// Add action
add_action('wpseo_register_extra_replacements', 'register_yoast_var_countAuthorPost');
