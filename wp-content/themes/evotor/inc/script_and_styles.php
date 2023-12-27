<?php
/**
 * Файл с подключениями и удалениями скриптов / стилей.
 */


add_action( 'wp_enqueue_scripts', 'remove_block_library_css' );
/**
 * Удаление стилей блочного редактора Guttenberg
 * @return void
 */
function remove_block_library_css() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'classic-theme-styles' );
}


// Удалить WLWmanifest из секции head.
remove_action( 'wp_head', 'wlwmanifest_link' );
// Скрытие лишних inline стилей добавки их в wordpress после 5.9 обновления.
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );


add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );
//  Отключаем загрузку файла dashicons.min.css стилей, не для залогиненных пользователей в админку.
function wpdocs_dequeue_dashicon() {
    if ( is_admin() ) {
        return;
    }
    $plugins             = get_option( 'active_plugins' );
    $queryMonitorEnabled = in_array( 'query-monitor/query-monitor.php', $plugins, true );
    // Если включен плагин Query Monitor не нужно отключать эти стили, т.к. ломается весь admin bar.
    if ($queryMonitorEnabled) {
        return;
    }
    wp_deregister_style( 'dashicons' );
}


add_filter( 'script_loader_tag', 'add_defer_attribute', 10, 2 );
/**
 * Добавить всем встраиваемым скриптам вне админки добавить атрибут defer.
 *
 * @param $tag
 * @param $handle
 *
 * @return array|mixed|string|string[]
 */
function add_defer_attribute( $tag, $handle ) {
    if ( is_admin() ) {
        return $tag;
    }

    return str_replace( ' src', ' defer="defer" src', $tag );
}


add_action( 'wp_enqueue_scripts', 'js_scripts' );
/**
 * Подключение основных скриптов проекта для фронтаю
 * @return void
 */
function js_scripts() {
    $plugins             = get_option( 'active_plugins' );
    $queryMonitorEnabled = in_array( 'query-monitor/query-monitor.php', $plugins, true );

    if ( ! is_admin() && !$queryMonitorEnabled ) {
        wp_deregister_script( 'jquery' );
    }
    //

    // Отключить загрузку этих скриптов вне статей.
    // TODO: дописать, чтобы отключалось также в статьях, когда нет формы комментария
    if ( get_post_type() !== 'post' ) {
        wp_deregister_script( 'sgr_main' );
        wp_deregister_script( 'sgr_js' );
        wp_deregister_script( 'sgr-js' );
        wp_deregister_script( 'sgr' );
        wp_dequeue_style( 'sgr_main' );
        wp_dequeue_style( 'sgr_css' );
        wp_dequeue_style( 'sgr-css' );
        wp_dequeue_style( 'sgr');
        wp_dequeue_style( 'post-views-counter-frontend-css' );
        wp_deregister_style( 'post-views-counter-frontend-css' );
        //
        wp_dequeue_script( 'sgr' );
    }
    global $wp_scripts;

    if ((is_singular('benefits')) || (is_singular('collections')) || (is_page('o-proekte'))
        || (is_page('subscription')    || (is_page('unsubscribe')))
        || (is_tax('post_author')) || is_front_page() || is_search()
        || is_single()
    ) {
        register_dist_css('/dist/css/redesign.*', 'theme-redesign');
        // Этот скрипт только для страниц, где есть Masonry сетка
        register_dist_js('/dist/js/runtime.*', 'runtime');
        wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/jquery.min.js', false, null, true );
        register_dist_js('/dist/js/vendor.*', 'vendor', ['runtime']);
        register_dist_js('/dist/js/redesign.*', 'redesign', ['runtime', 'vendor', 'jquery']);
        wp_dequeue_style( 'sgr');
    } else {
        wp_enqueue_script( 'jquery-last', '//cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js', false, STYLES_SCRIPTS_VERSION, true );
        wp_enqueue_script( 'jquery' );
        register_dist_js('/dist/js/runtime.*', 'runtime');
        register_dist_js('/dist/js/index.*', 'redesign', ['runtime', 'jquery-last']);
        //
        register_dist_css('/dist/css/index.*', 'theme-style');
        //wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/dist/index.css', null, STYLES_SCRIPTS_VERSION );
    }
    if (is_single()) {
        // уникальные стыли для статьи
        register_dist_js('/dist/js/single.*', 'single');
        register_dist_css('/dist/css/single.*', 'theme-single');
    }
}

/**
 * Удаляем link rel=EditURI
 */
remove_action( 'wp_head', 'rsd_link' );


/**
 * @param string $pattern
 * @param string $name
 * @param array|null $deps
 * @param bool $inFooter
 *
 * @return void
 */
function register_dist_js( string $pattern, string $name, array $deps = [], bool $inFooter = true ) {
    $find = glob( get_template_directory() . $pattern );
    if ( $find && count( $find ) ) {
        $fileName = basename( $find[0] );
        $uri      = get_template_directory_uri() . '/dist/js/' . $fileName;
        wp_enqueue_script( $name, $uri, $deps, null, $inFooter );
    }
}

function register_dist_css( string $pattern, string $name, array $deps = [] ) {
    $find = glob( get_template_directory() . $pattern );
    if ( $find && count( $find ) ) {
        $fileName = basename( $find[0] );
        $uri      = get_template_directory_uri() . '/dist/css/' . $fileName;
        wp_enqueue_style( $name, $uri, $deps );
    }
}

//

add_action( 'wp_print_scripts', 'deregister_plugins_scripts', 100 );
function deregister_plugins_scripts() {
    if ( is_admin()) {
        return;
    }
    $postType = get_post_type();
    if ($postType !== 'post') { // Удалить стиле simple google recaptcha для всех страниц, кроме статей.
        wp_deregister_script( 'sgr' );
        wp_dequeue_script( 'sgr' );
    }

}

add_action( 'wp_print_styles', 'deregister_plugins_styles', 100 );
function deregister_plugins_styles() {
    if ( is_admin()) {
        return;
    }
    $postType = get_post_type();
    if ($postType !== 'post') { // Удалить стиле simple google recaptcha для всех страниц, кроме статей.
        wp_dequeue_style( 'sgr' );
        wp_deregister_style( 'sgr' );
    }

    wp_dequeue_style( 'post-views-counter-frontend' );
    wp_deregister_style( 'post-views-counter-frontend' );
    //
}
