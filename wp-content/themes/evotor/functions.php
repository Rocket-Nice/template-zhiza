<?php
const STYLES_SCRIPTS_VERSION = '1.0.67';
const VENDOR_SCRIPTS_VERSION = '1.0.2';
add_filter( 'automatic_updater_disabled', '__return_true' );


/**
 * Если URL содержит верхний регистр, преобразует его к нижнему.
 * @return void
 */
function parseUppercase() {
    $url  = $_SERVER['REQUEST_URI'];
    $need = isPartUppercase( $url );
    if ( $need ) {
        $lower = strtolower( $url );
        wp_redirect( $lower, 301 );
    }
}

add_action( 'parse_request', 'parseUppercase' );


/**
 * Начинается ли строка с верхнего регистра.
 *
 * @param $string
 *
 * @return bool
 */
function isPartUppercase( $string ) : bool {
    return (bool) preg_match( '/[A-Z]/', $string );
}


/**
 * Даёт доступ к плагину редиректов для роли редактор
 */
add_filter( 'redirection_role', 'redirection_to_editor' );
function redirection_to_editor() : string {
    return 'edit_pages';
}


/**
 * Скрывает раздел "Подкасты".
 * Раздел отключался по запросу клиента.
 */
add_action( 'template_redirect', 'hide_podcasts_post_type' );
function hide_podcasts_post_type() {
    if ( is_singular( 'podcasts' ) ) {
        wp_redirect( home_url(), 301 );
        exit;
    }
    if ( is_post_type_archive( 'podcasts' ) ) {
        wp_redirect( home_url(), 301 );
        exit;
    }
}


/**
 * Скрывает админ панель для залогиненных пользователей.
 */
add_filter( 'show_admin_bar', '__return_false' );



/**
 * Все правила связанные с поиском по сайту.
 */
require_once( 'inc/search.php' );

/**
 * Подключение всех основным стилей и скриптов.
 */
require_once( 'inc/script_and_styles.php' );

add_filter( 'wpseo_next_rel_link', '__return_false' );
add_filter( 'wpseo_prev_rel_link', '__return_false' );

/**
 * Подключение скриптов для ответов на комментарии
 */
require_once( 'inc/comment-reply.php' );

/**
 * Отключает оповещение о необходимости обновление плагина ACF.
 *
 * @param $value
 *
 * @return mixed
 */
function filter_plugin_updates( $value ) {
    unset( $value->response['advanced-custom-fields-pro/acf.php'] );

    return $value;
}

add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );


/**
 * TODO требуется к анализу, используется ли.
 * Что-то очень старое, и не понятно, используется ли.
 */
add_action( 'init', 'register_nav_menus_on_init' );
/**
 * Регистрация навигационного меню, для редактирования его из админки.
 */
function register_nav_menus_on_init() {
    register_nav_menus( array(
        'top-pages-menu' => 'Top Pages Menu',
    ) );
}


/**
 * TODO требуется к анализу, используется ли.
 * Что-то очень старое, и не понятно, используется ли.
 */
//include "selections/init.php";


/**
 * TODO: используется на странице поиска по сайту
 *
 * @param $post_id
 *
 * @return string
 */
function post_thumb( $post_id ) : string {
    $thumb_img = get_the_post_thumbnail( $post_id, 'blog-full' );
    if ( get_field( 'video_link', $post_id ) ) {
        $video = get_field( 'video_link', $post_id );
        if ( preg_match( '/[http|https]+:\/\/(?:www\.|)youtube\.com\/watch\?(?:.*)?v=([a-zA-Z0-9_\-]+)/i', $video, $matches ) || preg_match( '/[http|https]+:\/\/(?:www\.|)youtube\.com\/embed\/([a-zA-Z0-9_\-]+)/i', $video, $matches ) || preg_match( '/[http|https]+:\/\/(?:www\.|)youtu\.be\/([a-zA-Z0-9_\-]+)/i', $video, $matches ) ) {
            $image_url = 'https://img.youtube.com/vi/' . $matches[1] . '/sddefault.jpg';
            $video_img = "<img src='$image_url' alt='' loading='lazy'>";
        }
    }
    if ( $thumb_img ) {
        $thumb = $thumb_img;
    } else {
        $thumb = $video_img ?? '<img src="/wp-content/themes/evotor/images/default.jpg" alt="" loading="lazy">';
    }

    if ( ! $thumb ) {
        $thumb = '<img src="/wp-content/themes/evotor/images/default.jpg" alt="" loading="lazy">';
    }

    return $thumb;
}


/**
 * TODO: используется на странице, например, архивная коллекций
 * Склонение слова 'Статьи'.
 *
 * @param $cnt
 *
 * @return string
 */
function post_count_text( $cnt ) : string {
    if ( $cnt >= 20 ) {
        $cnt = substr( $cnt, - 1 );
    }

    switch ( $cnt ) {
        case 1:
            $count_text = 'статья';
            break;
        case 2:
        case 3:
        case 4:
            $count_text = 'статьи';
            break;
        default:
            $count_text = 'статей';
    }

    return $count_text;
}


/**
 * TODO: использовалось в кастомном типе странице - подкасты
 * Склонение слова 'Эпизод'.
 *
 * @param $cnt
 *
 * @return string
 */
function epizod_count_text( $cnt ) : string {
    if ( $cnt >= 20 ) {
        $cnt = substr( $cnt, - 1 );
    }

    switch ( $cnt ) {
        case 1:
            $count_text = 'эпизод';
            break;
        case 2:
        case 3:
        case 4:
            $count_text = 'эпизода';
            break;
        default:
            $count_text = 'эпизодов';
    }

    return $count_text;
}


/**
 * Склонение слова 'Коллекции'.
 *
 * @param $cnt
 *
 * @return string
 */
function collections_count_text( $cnt ) : string {
    if ( $cnt >= 20 ) {
        $cnt = substr( $cnt, - 1 );
    }

    switch ( $cnt ) {
        case 1:
            $count_text = 'подборка';
            break;
        case 2:
        case 3:
        case 4:
            $count_text = 'подборки';
            break;
        default:
            $count_text = 'подборок';
    }

    return $count_text;
}


add_action( 'wp_ajax_loadmore', 'true_load_posts' );
add_action( 'wp_ajax_nopriv_loadmore', 'true_load_posts' );
/**
 * TODO проверить на актуальность использования
 * src/js/loadmore используется в нем.
 * @return void
 */
function true_load_posts() {
    $args                = unserialize( stripslashes( $_POST['query'] ) );
    $args['paged']       = $_POST['page'] + 1;
    $args['post_status'] = 'publish';
    query_posts( $args );
    $countPostsAtPage = 0;
    while ( have_posts() ) {
        the_post();
        $countPostsAtPage ++;
    }
    //
    if ( have_posts() ) : ?>
        <div class="block category_<?= $countPostsAtPage ?>">
            <?php
            $n = 0;
            while ( have_posts() ):
                the_post();
                $n ++;
                //
                get_template_part( 'template_parts/category/category-post-item', null, [ 'position' => $n ] );
                if ( $n === 10 ) {
                    echo '<div class="once_mask"></div>';
                }
            endwhile; ?>
        </div>
    <?php endif;
    die();
}


/* Миниатюра записи */
add_theme_support( 'post-thumbnails', array( 'post', 'page', 'select', 'collections' ) );


/* Отключение автоматических параграфов */
// remove_filter( 'the_content', 'wpautop' );


function disable_wp_emojicons() {
    global $wp_query;
    // all actions related to emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    //
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );
    //
    // filter to remove TinyMCE emojis
    //add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );

}

add_action( 'init', 'disable_wp_emojicons' );


add_filter( 'intermediate_image_sizes_advanced', 'true_remove_default_sizes' );
function true_remove_default_sizes( $sizes ) {
    unset( $sizes['1536x1536'], $sizes['2048x2048'] );

    //
    return $sizes;
}


function wps_display_attachment_settings() {
    //    update_option( 'image_default_align', 'left' );
    //    update_option( 'image_default_link_type', 'none' );
    //    update_option( 'image_default_size', 'large' );
    // image sizes
    add_image_size( 'circle-post', 46, 46, array( 'center', 'center' ) );
    //
    add_image_size( 'main-post-preview', 500, 500 );
    add_image_size( 'main-post-preview-mobile', 700, 0 );
    //
    add_image_size( 'main_post_small_preview', 423, 330 );
    add_image_size( 'main_post_small_preview_mobile', 266, 214, true );
    add_image_size( 'main_post_small_preview_mobile_smallest', 220, 160 );
    //
    add_image_size( 'gold_fond_image', 390, 200 );
    //
    add_image_size( 'right_banner_image', 150, 150 );
    add_image_size( 'collection_circle', 164, 164, [ 'center', 'center' ] );
    //    add_image_size( 'blog-my', 683, 456 ); // Not use
    add_image_size( 'blog-big', 590, 9999 );
    //    add_image_size( 'blog-small', 450, 9999 );
    //    add_image_size( 'blog-full', 1140, 9999, true );
    add_image_size( 'blog-full-th', 1140, 9999 );
    //    add_image_size( 'blog-adjacent', 260, 150, true );
    //    add_image_size('blog-gall', 9999, 400,  array('center','center'));
    // Вывод изображения в карточках статьи. Пример - карточки в Пользе, или в Важное на главной.
    add_image_size( 'collection-image', 576, 200, [ 'center', 'center' ] );
    // В блоке посмотрите другие подборки на странице коллекций
    add_image_size( 'other-collections-image', 500, 310, [ 'center', 'center' ] );
    //
    add_image_size( 'collection-page-banner', 1032, 248, [ 'center', 'center' ] );
    add_image_size( 'collection-page-banner-mobile', 576, 360, [ 'center', 'center' ] );
    // Превью нового поста на главной
    add_image_size( 'preview-newest-post', 1412, 556, [ 'center', 'center' ] );
    add_image_size( 'preview-newest-post-mobile', 800, 320, [ 'center', 'center' ] );
    // Бизнес инструменты баннер выбранный вручную
    add_image_size( 'business-tools-preview', 780, 420, [ 'center', 'center' ] );
}

add_action( 'after_setup_theme', 'wps_display_attachment_settings' );


/**
 * Get post excerpt
 * Получение цитаты статьи.
 *
 * @param $post_id
 *
 * @return string
 */
function getPostExcerpt( $post_id ) : string {
    return get_the_excerpt( $post_id );
    //return get_field('excerpt',$id);
}


/**
 *
 * @param $postId
 * @param $slug - приставка, с которой будет идти конечный поиск мета поля
 * @param string $peopleText - что это?
 * @param false $featured - что это?
 *
 * @return string
 */
function postNewSinglePeople( $postId, $slug, string $peopleText = '', bool $featured = false ) : string {
    $html = '';

    // Если выбран пользователь в таксономии Авторы
    $authorTaxonomy = wp_get_post_terms( $postId, 'post_author' );

    if ( ( $peopleText === 'Автор' ) && count( $authorTaxonomy ) > 0 ) { // Только если пользователь выбран как таксономия
        /** @var WP_Term $author */
        $author = $authorTaxonomy[0];
        $name   = $author->name;
        //
        $link = '/o-proekte/' . $author->slug;
    } else if ( $slug === 'illustrator' ) {
        $imageUrl   = [];
        $name       = trim( get_post_meta( $postId, 'illustrator_text', true ) );
        $peopleText = ( get_post_meta( $postId, 'illustrator_role', true ) ) ?: 'Иллюстратор';
        // Проставка rel=nofollow
        $name = str_replace( ' href', ' rel="nofollow noopener" href', $name );
        $link = '';
        //
        if ( str_contains( $name, 'facebook' ) || str_contains( $name, 'instagram' ) ) {
            $name = preg_replace( '/ href="(.*?)"/i', '', $name );
            $name = preg_replace( "/ href='(.*?)'/i", '', $name );
        }
    } else { // Редактор, Эксперт или Автор(если не выбран как пользователь).
        $name = trim( get_post_meta( $postId, $slug . '_name', true ) );

        if ( ! empty( $name ) ) {

            $imageId = trim( get_post_meta( $postId, $slug . '_image', true ) );
            if ( ! empty( $imageId ) ) {
                $imageUrl = wp_get_attachment_image_src( $imageId, 'author', true );
            }

            $link = get_post_meta( $postId, $slug . '_link', true );
            // Если ссылка содержит фейсбук или инстаграм - обнуляем ссылку.
            if ( str_contains( $link, 'facebook' ) || str_contains( $link, 'instagram' ) ) {
                $link = '';
            } else {
                $link = ( strlen( $link ) > 0 ) ? esc_url( trim( $link ) ) : '';
            }
        }
    }

    $class = ( $featured ) ? 'author-featured' : 'author';

    if ( ! empty( $name ) ) {
        $linkName = ( $link ) ? '<a href="' . $link . '" target="_blanc" rel="nofollow noopener" title="' . esc_html( $name ) . '">' . $name . '</a>' : $name;

        $html .= '<li>';
        $html .= '' . $peopleText . ': ' . $linkName;
        $html .= '</li>';
    }

    return $html;
}


/**
 * Включение автоматической подстановки title страниц.
 * В данном случае title прописывает плагин Yoast SEO
 * Тэг <title> в header должен отсутствовать.
 */
add_theme_support( 'title-tag' );


/**
 * TODO проверить на использование
 * Используется в подключаемом блоке init.php, являющийся собой
 * блоком сборки коллекций, которые уже не используются на сайте.
 * Вопрос использования под вопросом.
 *
 * @param $filename
 *
 * @return false|string
 */
function get_file_ver( $filename ) {
    $file = WP_CONTENT_DIR . "/themes/" . get_template() . "/" . $filename;

    return ( file_exists( $file ) ? date( 'ymdHis', filemtime( $file ) ) : '0' );
}


/**
 * TODO проверить на использование
 * Используется в подключаемом блоке selections.
 * Вопрос необходимости остается под вопросом
 *
 * @param $U
 *
 * @return array|string|string[]
 */
function filter_date( $U ) {

    $dateObject = new DateTime;
    $dateObject->setTimestamp( $U );
    $format = 'j %m Y';
    $date   = $dateObject->format( $format );

    $pub_date = str_replace( array(
        "%01",
        "%02",
        "%03",
        "%04",
        "%05",
        "%06",
        "%07",
        "%08",
        "%09",
        "%10",
        "%11",
        "%12"
    ), array(
        "января",
        "февраля",
        "марта",
        "апреля",
        "мая",
        "июня",
        "июля",
        "августа",
        "сентября",
        "октября",
        "ноября",
        "декабря"
    ), $date );

    return $pub_date;
}


/**
 * Используется в одном из хуков для OpenGraph.
 * Имеет ли смысл существование, неясно.
 *
 * @param WP_Post|false $post
 * @param string $size
 *
 * @return mixed|void
 */
function get_thumb_url( $post = false, string $size = 'loop' ) {
    if ( ! $post ) {
        global $post;
    }

    if ( has_post_thumbnail( $post ) ) {
        $thumb_id  = get_post_thumbnail_id( $post );
        $thumb_url = wp_get_attachment_image_src( $thumb_id, $size, true );

        return $thumb_url[0];
    }
}


/**
 * Используется на странице single постов.
 *
 * @param $post
 *
 * @return array|WP_Error|WP_Term[]
 */
function get_post_categories( $post ) {
    $categories = get_the_terms( $post->ID, 'category' );

    if ( $categories && ! is_wp_error( $categories ) ) {
        return $categories;
    } else {
        return [];
    }
}


/**
 * Используется в блоке selection.
 * Надобность - под вопросом.
 *
 * @param $url
 *
 * @return mixed|void
 */
function parse_youtube( $url ) {
    if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match ) ) {
        return $match[1];
    }
}


/**
 * Удаление для каноничной ссылки в категориях PAGE и PAGED префиксов
 */
add_filter( 'wpseo_canonical', function( $string ) {
    if ( is_category() && get_query_var( 'paged' ) ) {
        return str_replace( '/page/' . get_query_var( 'paged' ), '', $string );
    }

    return $string;
} );


/**
 * Изменение meta description для страницы категорий, для страниц с пагинацией
 */
add_filter( 'wpseo_metadesc', function( $string ) {
    if ( is_category() && get_query_var( 'paged' ) ) {
        return get_queried_object()->name . " — Страница " . get_query_var( 'paged' ) . " — полезные статьи для предпринимателей и владельцев бизнеса — " . get_bloginfo( 'name' );
    }

    return $string;
} );


/**
 * OpenGraph изображение для статей
 */
add_filter( 'wpseo_opengraph_image', function( $string ) {
    if ( is_single() ) {
        $meta = get_post_meta( get_the_ID(), '_yoast_wpseo_opengraph-image', true );
        if ( $meta ) {
            return $meta;
        }

        return get_thumb_url( get_post( get_the_ID() ) );
    }

    return $string;
} );


/**
 * TODO Обратить сюда внимание на пагинацию
 * Переопределение числа элементов на странице категории
 *
 * @param $query
 *
 * @return mixed|WP_Query
 */
function namespace_add_custom_types( $query ) {
    global $wp_the_query;
    if ( $wp_the_query === $query ) {
        if ( is_category() ) {
            $query->set( 'posts_per_page', 24 );
        }
    }

    return $query;
}

add_filter( 'pre_get_posts', 'namespace_add_custom_types' );


/**
 * При помощи буфера вывода получаем с переменную буферизированный
 * вывод работы частичного шаблона.
 *
 * @param string $template_name путь до частичного шаблона
 * @param null|string $part_name
 *
 * @return false|string
 */
function load_template_part( string $template_name, $part_name = null ) {
    ob_start();
    get_template_part( $template_name, $part_name );

    return ob_get_clean();
}


function callback_relative_url( $buffer ) {
    if ( ! is_feed( 'turbo' ) ) {
        // Replace normal URLs
        $home_url          = esc_url( home_url( '/' ) );
        $home_url_relative = wp_make_link_relative( $home_url );

        // Replace URLs in inline scripts
        $home_url_escaped          = str_replace( '/', '\/', $home_url );
        $home_url_escaped_relative = str_replace( '/', '\/', $home_url_relative );

        // $buffer = str_replace($home_url, $home_url_relative, $buffer);
        // $buffer = str_replace($home_url_escaped, $home_url_escaped_relative, $buffer);
    }

    return $buffer;
}


function buffer_start_relative_url() {
    ob_start( 'callback_relative_url' );
}

function buffer_end_relative_url() {
    @ob_end_flush();
}


add_action( 'registered_taxonomy', 'buffer_start_relative_url' );
add_action( 'shutdown', 'buffer_end_relative_url' );


function bybe_remove_yoast_json( $data ) {
    if ( ( isset( $data['@type'] ) ) && ( $data['@type'] == 'WebSite' ) ) {
        $data = array();
    }

    return $data;
}

add_filter( 'wpseo_json_ld_output', 'bybe_remove_yoast_json', 10, 1 );


function webp_upload_mimes( $existing_mimes ) {
    $existing_mimes['webp'] = 'image/webp';

    return $existing_mimes;
}

add_filter( 'mime_types', 'webp_upload_mimes' );


/**
 * Action: newest_post
 * Возвращает определённое число последних опубликованных статей, для которых
 * meta поле shot_at_evotor_main_site установлено в true.
 */
function getLastPostForParentSite() {
    $numberOfPosts = array_key_exists('count', $_GET) ? (int) $_GET['count'] : 4;

    $newestPostsArgs = [
        'posts_per_page' => $numberOfPosts,
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'meta_query'     => [
            [
                'key'   => 'show_at_evotor_main_site',
                'value' => true,
            ]
        ],
    ];
    $newestPosts     = new WP_Query( $newestPostsArgs );

    $data = [];

    if ( $newestPosts->have_posts() ) {
        while ( $newestPosts->have_posts() ) {
            $newestPosts->the_post();

            $post_ = $newestPosts->post;

            $data[] = [
                'title'        => $post_->post_title,
                'url'          => get_site_url() . '/' . $post_->post_name,
                'thumbnail'    => get_the_post_thumbnail_url( $post_->ID ),
                'publish_date' => get_the_date( 'j F Y' ),
            ];
        }
    }

    wp_send_json( $data );
}

add_action( 'wp_ajax_nopriv_newest_post', 'getLastPostForParentSite' );
add_action( 'wp_ajax_newest_post', 'getLastPostForParentSite' );


# Закрывает все маршруты REST API от публичного доступа
# Если не залогинен, будет выдавать сообщение ошибки.
add_filter( 'rest_authentication_errors', function( $result ) {
    if ( is_null( $result ) && ! current_user_can( 'edit_others_posts' ) ) {
        return new WP_Error( 'rest_forbidden', 'You are not currently logged in.', [
            'status' => 401
        ] );
    }

    return $result;
} );


/**
 * Добавляет на странице Записи новый столбец, показывающий, отправляется ли данная страница
 * на основной сайт evotor.ru
 *
 * Источник: https://www.smashingmagazine.com/2017/12/customizing-admin-columns-wordpress/
 */
function external_view_filter_posts_columns( $columns ) {
    $columns['external_view'] = __( 'Вывод на главной Evotor', 'post' );

    return $columns;
}

add_filter( 'manage_posts_columns', 'external_view_filter_posts_columns' );


/**
 * Формирует значения для столбца в таблице.
 *
 * @param $column_name - slug таблицы. В данном случае external_view.
 * @param $post_id - id каждой таблицы в переборе.
 */
function action_external_view_posts_column( $column_name, $post_id ) {
    if ( $column_name === 'external_view' ) {
        $showAtMainSiteMetaValue = get_post_meta( $post_id, 'show_at_evotor_main_site', true );

        $show = empty( $showAtMainSiteMetaValue ) ? 'Нет' : 'Да'; // Мета-свойство равно либо '', либо '0', либо '1'.

        echo $show;
    }
}

add_action( 'manage_posts_custom_column', 'action_external_view_posts_column', 10, 2 );


function filter_external_view_column( $sortable_columns ) {
    $sortable_columns['external_view'] = [ 'external_view_column', true ];
    // false = asc (по умолчанию)
    // true  = desc

    return $sortable_columns;
}

add_filter( 'manage_edit-post_sortable_columns', 'filter_external_view_column' );


/**
 * Добавить в просмотр
 *
 * @param $query
 *
 * @return void
 */
function external_view_posts_orderby( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( 'external_view_column' === $query->get( 'orderby' ) ) {
        $query->set( 'orderby', 'meta_value' );
        $query->set( 'meta_key', 'show_at_evotor_main_site' );
        $query->set( 'meta_type', 'string' );
    }
}

add_action( 'pre_get_posts', 'external_view_posts_orderby' );


function filter_function_replace( $output ) {
    $patterns = [
        "%<lastmod[^>]*?>.*?<\/lastmod>%",
    ];

    return preg_replace( $patterns, '', $output );

}

add_filter( 'wpseo_sitemap_url', 'filter_function_replace' );


require_once( get_template_directory() . "/inc/Market.php" );
require_once( get_template_directory() . "/inc/admin/pages/exportPageFunctions.php" );


require_once( get_template_directory() . "/inc/yandex_turbo.php" );
require_once( get_template_directory() . "/inc/SeoFunctions.php" );
require_once( __DIR__ . '/inc/post-types.php' );


/**
 * TODO: проанализировать, используется ли ещё на проде данная рубрика.
 *
 * @param $query
 *
 * @return mixed
 */
function exclude_category_from_search( $query ) {
    if ( $query->is_search ) {
        $cat_id = get_category_by_slug( 'hide' )->term_id;
        $query->set( 'cat', '-' . $cat_id );
    }

    return $query;
}

add_filter( 'pre_get_posts', 'exclude_category_from_search' );


/**
 * Скрыть блок комментариев для amp страниц.
 * Из-за реализации в AMP компонента amp-next-page, блок комментариев для каждой статьи будет излишним
 * и нарушать логику обработки отправки комментария.
 */
if ( amp_is_request() ) {
    add_filter( 'comments_open', '__return_false', 20, 2 );
    add_filter( 'pings_open', '__return_false', 20, 2 );
}


/**
 * При работе Google Tag Manager и использовании amp-next-page
 * при подгрузке новых статей над блоков новой статьи образовывалось пространство
 * высотой в 400px. Связано было, вероятно, с багом самого amp, что при подстановке
 * <amp-iframe> он не схлопывался. Второе правило native_iframe_user запрещает amp
 * заменять стандартный iframe, на amp-iframe, что позволяет избавиться от проблемы.
 */
add_filter( 'amp_content_sanitizers', static function( $sanitizers ) {
    $sanitizers[ AMP_Iframe_Sanitizer::class ]['add_noscript_fallback'] = false;

    //$sanitizers[ AMP_Iframe_Sanitizer::class ]['native_iframe_used'] = true;
    return $sanitizers;
} );


/**
 * @param int $post - POST id
 * @param int $index - порядковый номер выводимого изображения в группе коллекции
 * @param bool $isMobile - использовать формат для мобильных версий
 *
 * @return array
 */
function getActualCollectionImage( int $post, int $index, bool $isMobile ) : array {
    $thumbSize  = $isMobile ? 'main-post-preview-mobile' : 'blog-big';
    $circleSize = 'collection_circle';
    //
    $listCirclePc     = [ 2, 3, 4, 5, 6, 10, 11, 12 ];
    $listCircleMobile = [ 3, 4, 5, 6, 9, 10, 11, 12 ];
    //
    $listThumbMobile = [ 1, 2, 7, 8, 13 ];
    $listThumbPC     = [ 1, 7, 8, 9, 13 ];
    //
    $size = in_array( $index, $isMobile ? $listCircleMobile : $listCirclePc, true ) ? $circleSize : $thumbSize;
    if ( in_array( $index, $isMobile ? $listThumbMobile : $listThumbPC, true ) ) {
        $size = $thumbSize;
    }
    //
    $thumbnail = get_the_post_thumbnail_url( $post, $size );
    //
    $thumbnailCircle = get_field( 'collect_sircle_img' ) ? wp_get_attachment_image_url( get_field( 'collect_sircle_img' ), $size ) : $thumbnail;

    return [
        'thumbnail'       => $thumbnail,
        'thumbnailCircle' => $thumbnailCircle,
    ];
}


/**
 * Обрабатывает ACF мета поля. Для всех внешних ссылок добавляется rel='nofollow'.
 *
 * @param $field array|string - ACF мета поле
 *
 * @return array|string|string[]|null
 */
function add_nofollow_acf( $field ) {
    // Не фильтруем контент в админке, чтобы атрибуты не проставлялись при обновлении статьи.
    if ( is_admin() ) {
        return $field;
    }
    // Не обрабатываем контент обычных полей
    if ( is_array( $field ) ) {
        return $field;
    }
    $a    = 0;
    $text = stripslashes( $field );

    return preg_replace_callback( '|<a (.+?)>|i', static function( $matches ) {
        $urlText = $matches[1];
        $attrs   = wp_kses_hair( $urlText, wp_allowed_protocols() );
        // Если это ссылка на контент на сайте
        $isSiteLink      = strtolower( wp_parse_url( $attrs['href']['value'], PHP_URL_HOST ) ) === strtolower( wp_parse_url( home_url(), PHP_URL_HOST ) );
        $linkHasProtocol = str_contains( $attrs['href']['value'], 'http' );

        // Только если домен не совпадает с текущим и в url присутствует протокол http(s).
        if ( ! $isSiteLink && $linkHasProtocol ) {
            $nofollow = wp_rel_callback( $matches, 'nofollow noopener' );

            // Если target blank уже есть, пропустим
            return str_contains( $nofollow, 'target="_blank' ) ? $nofollow : str_replace( ' rel', ' target="_blank" rel', $nofollow );
        }

        return $matches[0];
    }, $text );
}

add_filter( 'acf/load_value', 'add_nofollow_acf', 100 );


/**
 * Вставка в HEAD тега контент css файла.
 * В данный файл вынесены критическая часть стилей.
 *
 * @return void
 */
//function head_inline_styles() {
//    echo "<style>" . file_get_contents(get_template_directory_uri() . '/dist/style.css') . "</style>";
//}
//add_action( 'wp_head', 'head_inline_styles' );


/**
 * Параметр блокировки инкремента индекса используется для предотвращения
 * изменения индекса фото для мобильной и ПК версии фотографии.
 * Для мобильной версии используется отдельный HTML блок со слайдером, что приводило к появлению лишних инкрементов
 * индекса фото.
 *
 * @param string $title - заголовок статьи
 * @param mixed $imageObj - объект ACF изображения галереи
 * @param int $index - ссылка на переменную инкремента
 *
 * @return mixed|string
 */
function autoAltAttribute( string $title, $imageObj, int &$index ) {
    $alt = $imageObj['alt'];
    if ( ! $alt ) {
        $alt = $title . ', фото ' . $index;
    }

    return $alt;
}


/**
 * Автоматический Title атрибут для ссылок в навигационном меню.
 * Title полностью дублирует текст ссылки.
 *
 * @param $atts
 * @param $item
 * @param $args
 * @param $depth
 *
 * @return mixed
 */
function addTitleToNavMenuLinks( $atts, $item, $args, $depth ) {
    $atts['title'] = $item->title;

    //
    return $atts;
}

add_filter( 'nav_menu_link_attributes', 'addTitleToNavMenuLinks', 10, 4 );


/**
 * @param $link - ссылка для проверки
 *
 * @return bool - ссылка ведёт на локальный адрес, или не имеет http протокола
 */
function isLocalDomainLink( $link ) : bool {
    return str_contains( $link, home_url() ) || ! str_contains( $link, 'http' );
}


/**
 * Если для статьи в блоке "На ту же тему" выбран только 1 элемент,
 * и этот элемент является коллекцией, в заголовок выводит название коллекции,
 * иначе фразу по умолчанию 'На ту же тему'.
 *
 * @param $pdb_bot
 *
 * @return string
 */
function checkIsSoloCollection( $pdb_bot ) : string {
    $title         = 'На ту же тему';
    $countElements = count( $pdb_bot );
    //
    if ( $countElements === 1 && get_post_type( $pdb_bot[0] ) === 'collections' ) {
        $title = get_the_title( $pdb_bot[0] );
    }

    //
    return $title;
}


function replaceLocalDevAddressToProduction( string $url ) : string {
    $newUrl = $url;

    if ( LOCAL_DEV_ADDRESS ) {
        return str_replace( get_site_url(), 'https://zhiza.evotor.ru', $url );
    }

    return $newUrl;
}


require_once( __DIR__ . "/inc/Breadcrumbs.php" );
require_once( __DIR__ . "/inc/ajax-routes.php" );


/**
 * Получить номер текущей страницы.
 *
 * @param string $pageKey
 *
 * @return int
 */
function get_current_page( string $pageKey = 'pg' ) : int {
    $page_ = 1;
    if ( isset( $_GET[ $pageKey ] ) ) {
        $page_ = (int) $_GET[ $pageKey ] ?: 1;
    }

    return $page_;
}

/**
 * Превращает многоуровневый массив в линейный.
 *
 * @param array $arr
 *
 * @return array mixed
 */
function array_multi_to_linear( array $arr ) : array {
    static $rez = [];
    foreach ( $arr as $v ) {
        if ( is_array( $v ) ) {
            array_multi_to_linear( $v );
        } else {
            $rez[] = $v;
        }
    }

    return $rez;
}


/**
 * Word declension after a number.
 *
 *     // Examples of invocation:
 *     num_decline( $num, 'книга,книги,книг' )
 *     num_decline( $num, 'book,books' )
 *     num_decline( $num, [ 'книга','книги','книг' ] )
 *     num_decline( $num, [ 'book','books' ] )
 *
 * @param int|string $number The number that is followed by the word. You can use HTML tags.
 * @param string|array $titles Variants of words for numbers.
 * @param bool $show_number Set to `false`, when you don't want to output the number itself.
 *
 * @return string For example: 1 book, 2 books, 10 books.
 *
 * @version 3.1
 */
function num_decline( $number, $titles, bool $show_number = true ) : string {

    if ( is_string( $titles ) ) {
        $titles = preg_split( '/, */', $titles );
    }

    // когда указано 2 элемента
    if ( empty( $titles[2] ) ) {
        $titles[2] = $titles[1];
    }

    $cases = [ 2, 0, 1, 1, 1, 2 ];

    $intnum = abs( (int) strip_tags( $number ) );

    $title_index = ( $intnum % 100 > 4 && $intnum % 100 < 20 ) ? 2 : $cases[ min( $intnum % 10, 5 ) ];

    return ( $show_number ? "$number " : '' ) . $titles[ $title_index ];
}
