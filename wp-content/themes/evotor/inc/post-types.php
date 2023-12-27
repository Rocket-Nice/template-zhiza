<?php

// Подкасты
add_action( 'init', 'register_podcasts_post_type' );
function register_podcasts_post_type() {

    register_taxonomy('podcastscat', array('podcasts'), array(
        'label'                 => 'Подкасты',
        'labels'                => array(
            'name'              => 'Категории',
            'singular_name'     => 'Категория',
            'search_items'      => 'Искать категорию',
        ),
        'description'           => 'Категории', // описание таксономии
        'public'                => true,
        'show_in_nav_menus'     => true,
        'show_ui'               => true,
        'show_tagcloud'         => false,
        'hierarchical'          => true,
        'rewrite'               => array('slug'=>'services', 'hierarchical'=>false,),
        'show_admin_column'     => true,
    ) );


    register_post_type('podcasts', array(
        'label'               => 'Подкасты',
        'labels'              => array(
            'name'          => 'Подкасты',
            'singular_name' => 'Подкасты',
            'menu_name'     => 'Подкасты',
            'all_items'     => 'Все подкасты',
            'add_new'       => 'Добавить подкаст',

        ),
        'description'         => '',
        'menu_position'       => 5,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_rest'        => false,
        'rest_base'           => '',
        'show_in_menu'        => true,
        'exclude_from_search' => false,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'rewrite'             => array( 'slug'=>'podcasts', ),
        'has_archive'         => 'podcasts',
        'query_var'           => true,
        'supports'            => array( 'title', 'editor' ),
        'taxonomies'          => array( 'podcastscat'),
    ) );
}

//Подборки
add_action( 'init', 'register_collections_post_type' );
function register_collections_post_type() {
    register_post_type('collections', array(
        'label'               => 'Подборки',
        'labels'              => array(
            'name'          => 'Подборки',
            'singular_name' => 'Подборки',
            'menu_name'     => 'Подборки',
            'all_items'     => 'Все подборки',
            'add_new'       => 'Добавить подборку',
        ),
        'description'         => '',
        'menu_position'       => 5,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_rest'        => false,
        'rest_base'           => '',
        'show_in_menu'        => true,
        'exclude_from_search' => false,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'has_archive'         => 'collections',
        'query_var'           => true,
        'supports'            => array( 'title', 'editor', 'thumbnail'),
        'taxonomies'          => array( '' ),
    ) );
}

// Польза
add_action( 'init', 'register_benefits_post_type' );
function register_benefits_post_type() {
    register_post_type('benefits', array(
        'label'               => 'Польза',
        'labels'              => array(
            'name'          => 'Польза',
            'singular_name' => 'Польза',
            'menu_name'     => 'Польза',
            'all_items'     => 'Все подборки пользы',
            'add_new'       => 'Добавить подборку пользы',
        ),
        'description'         => '',
        'menu_position'       => 6,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_rest'        => false,
        'rest_base'           => '',
        'show_in_menu'        => true,
        'exclude_from_search' => false,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'hierarchical'        => false,
        'has_archive'         => 'benefits',
        'query_var'           => true,
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'          => array( '' ),
    ) );
}
// Register Theme Features
function custom_theme_features()  {
    add_theme_support( 'post-thumbnails', array( 'post', 'benefits' ) );
}
add_action( 'after_setup_theme', 'custom_theme_features' );


function createPostAuthorsTaxonomy() {
    $labels = array(
        'name' => _x( 'Авторы', 'Авторы блока' ),
        'singular_name' => _x( 'Автор', 'Автор блога' ),
        'search_items' =>  __( 'Поиск по авторам' ),
        'popular_items' => __( 'Популярные авторы' ),
        'all_items' => __( 'Все авторы' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Редактировать автора' ),
        'update_item' => __( 'Обновить автора' ),
        'add_new_item' => __( 'Добавить нового автора' ),
        'new_item_name' => __( 'New Topic Name' ),
        'separate_items_with_commas' => __( 'Separate authors with commas' ),
        'add_or_remove_items' => __( 'Add or remove authors' ),
        'choose_from_most_used' => __( 'Choose from the most used authors' ),
        'menu_name' => __( 'Авторы' ),
    );
    // Теперь регистрируем НЕ-иерархическую таксономию вроде Тегов
    register_taxonomy('post_author','post', array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => [
            'slug' => 'o-proekte'
        ],
        'public' => true,
    ));
}
add_action( 'init', 'createPostAuthorsTaxonomy', 0 );
