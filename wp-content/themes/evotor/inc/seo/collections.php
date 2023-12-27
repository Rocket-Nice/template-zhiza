<?php

/**
 * Возвращает количество выбранных постов в кастомном посте Коллекции, выбранных в поле Статьи.
 * @return int Количество выбранных постов
 */
function getCountPostsInCollection() : int {
    global $wp_query;
    // Категории - Деньги, провалы и др.
    $categoryName = null;

    $args = [
        'post_type' => 'collections',
        'name' => $wp_query->query['collections'],
    ];
    $query = new WP_Query($args); // Получим коллекцию с таким url
    // Количество постов в этой коллекции.
    $selected = get_post_meta($query->post->ID, 'select_posts', true);
    return $selected ? count($selected) : 0;
}


// Регистрация обработки кастомной переменной
function register_custom_yoast_variables__countPosts() {
    wpseo_register_var_replacement( '%%countposts%%', 'getCountPostsInCollection',
        'advanced' );
}

add_action('wpseo_register_extra_replacements', 'register_custom_yoast_variables__countPosts');
