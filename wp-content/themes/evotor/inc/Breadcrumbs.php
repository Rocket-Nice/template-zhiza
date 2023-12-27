<?php


function get_breadcrumb( string $className = '' ) {
    try {
        global $post;
        global $wp_query;
        $a = 0;
        $items = [
            createLdJsonElement(1, 'Главная', '/', true)
        ];
        $ld = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => []
        ];

        echo "<ol class='page-breadcrumbs $className'>";

        mainPage();
        $singularCollectionsOrBenefits = is_singular( 'collections' ) || is_singular( 'benefits' );
        $isSingularPost        = is_singular( 'post' );
        // Имя типа поста (Подборки или Польза)
        $postTypeObj = get_post_type_object(get_post_type());
        $postName = $postTypeObj->label;
        $postType = '/' . get_post_type() . '/';

        if ( $singularCollectionsOrBenefits || ( is_archive() && is_post_type_archive() ) ) {
            echo element( is_single() ? $postType : '', $postName );
            $items[] = createLdJsonElement( 2, $postName, $postType, true );
            //
            if ( is_single() ) {
                echo element( '', get_the_title(), false );
                $items[] = createLdJsonElement( 3, get_the_title() );
            }
        } else if ( $isSingularPost || is_category() ) {
            $categoryName = get_the_category()[0]->name;
            $categorySlug = get_the_category()[0]->slug;
            echo element( $isSingularPost ? "/category/$categorySlug/" : '', $categoryName );
            $items[] = createLdJsonElement(
                2,
                $categoryName,
                "/category/$categorySlug/",
                $isSingularPost
            );
            if ( is_single() ) {
                echo element( '', get_the_title() );
                $items[] = createLdJsonElement(
                    3,
                    get_the_title(),
                );
            }
        } else if (is_tax()) {
            $authorName = $wp_query->query['post_author'];
            echo element('/o-proekte/', 'О проекте' );
            $items[] = createLdJsonElement(
                2, 'О проекте', '/o-proekte/', true
            );
            $name = get_term_by('slug', $authorName, 'post_author'); // Имя уже на кириллице
            echo element("", $name->name );
            $items[] = createLdJsonElement(
                3, $name->name, "/o-proekte/{$authorName}", false
            );
        } else if (is_page()) {
            echo element( '', get_the_title() );
            $items[] = createLdJsonElement(2, get_the_title());
        }
        $ld['itemListElement'] = $items;

        echo '</ol>';

        echo '<script type="application/ld+json">'
             .
             json_encode($ld, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES )
             .
             '</script>';
    } catch (Exception $ex) {
        error_log('Error make page breadcruumbs');
    }
}


function mainPage() {
    echo '
    <li>
        <a href="/">
            <span>
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.99997 0.280273L0.599976 5.08027V13.7203H4.91998V9.24027H9.07997V13.7203H13.4V5.08027L6.99997 0.280273Z"/>
                </svg>
            </span>
        </a>
    </li>';
}


function category() {
    global $post;
    global $wp_query;
    $isCollections = get_post_type() === 'collections';

    if ( $isCollections ) {
        $title     = get_the_title();
        $isArchive = is_archive();
        //
        echo element( ! $isArchive ? '/collections/' : '', 'Подборки', ! $isArchive, 2 );
        if ( is_single() ) {
            echo element( '', $title, false );
        }
    } else if ( is_category() ) {
        echo element( '', get_the_category()[0]->name, false );
    } else if ( is_single() ) {
        $categoryName = get_the_category()[0]->name;
        $categorySlug = get_the_category()[0]->slug;
        //
        echo element( "/category/$categorySlug/", $categoryName, true, 2 );

        $title = get_the_title();
        echo element( '', $title );
    }
}


/**
 * Рендер пункта хлебных крошек
 *
 * @param string $link - ссылка. Если пустая
 * @param string $linkText - текст ссылки
 *
 * @return string
 */
function element( string $link, string $linkText ) : string {
    $text = "<span>$linkText</span>";
    //
    $withLink = "<a href='$link'>$text</a>";
    $noLink   = $text;
    //
    $element = ! empty( $link ) ? $withLink : $noLink;

    return "<li>$element</li>";
}


/**
 * @throws JsonException
 */
function createLdJsonElement($position, $name, $urlItem = '', $needAddUrlItem = false) {
    $url = get_site_url() . $urlItem;
    $item = [
        '@type' => 'ListItem',
        'position' => $position,
        'name' => $name,
    ];
    $needAddUrlItem && $item['item'] = $url;

    return $item;
}
