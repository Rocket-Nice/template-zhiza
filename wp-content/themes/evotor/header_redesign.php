<?php
header ("Last-Modified: " . date("D, d M Y H:i:s", strtotime($post->post_modified)) . " GMT");
?>

<!doctype html>
<html lang="ru-RU">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>

    <?php if (is_search()): ?>
        <meta name="robots" content="noindex" />
    <?php else: ?>
        <meta name="robots" content="follow, index"/>
    <?php endif; ?>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="4f92bb4bd07ce18f" />
    <meta name="google-site-verification" content="hyw6FsptIVSnj5zG9wczqHJh104hFJ7dUTIfIQf5n-Y"/>

    <link rel="preload" href="/wp-content/themes/evotor/fonts/kazimir-bold-web.woff2" as="font" type="font/woff" crossorigin="">
    <link rel="preload" href="/wp-content/themes/evotor/fonts/graphik-regular-web.woff2" as="font" type="font/woff" crossorigin="">
    <link rel="preload" href="/wp-content/themes/evotor/fonts/graphik-bold-web.woff2" as="font" type="font/woff" crossorigin="">
    <link rel="preload" href="/wp-content/themes/evotor/fonts/graphik-semibold.woff2" as="font" type="font/woff" crossorigin="">

    <link rel="shortcut icon" href="/favicon.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_16px.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_32px.png">
    <link rel="icon" type="image/png" sizes="48x48" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_48px.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_96px.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_192px.png">
    <link rel="icon" type="image/png" sizes="270x270" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_270px.png">
    <link rel="apple-touch-icon" type="image/png" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_57px.png">
    <link rel="apple-touch-icon" type="image/png" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_60px.png">
    <link rel="apple-touch-icon" type="image/png" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_72px.png">
    <link rel="apple-touch-icon" type="image/png" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_76px.png">
    <link rel="apple-touch-icon" type="image/png" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_114px.png">
    <link rel="apple-touch-icon" type="image/png" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_120px.png">
    <link rel="apple-touch-icon" type="image/png" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_144px.png">
    <link rel="apple-touch-icon" type="image/png" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_152px.png">
    <link rel="apple-touch-icon" type="image/png" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/assets/favicons/new/favicon_180px.png">

    <?php wp_head(); ?>

    <?php if ( amp_is_request() ): ?>
        <script async custom-element="amp-next-page" src="https://cdn.ampproject.org/v0/amp-next-page-1.0.js"></script>
        <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <?php endif; ?>

    <?php if ( is_front_page() ): ?>
        <meta property="vk:image" content="https://zhiza.evotor.ru/wp-content/themes/evotor/ZHIZA_VK.png"/>
        <meta property="fb:image" content="https://zhiza.evotor.ru/wp-content/themes/evotor/ZHIZA_VK.png"/>
        <meta property="viber:image" content="https://zhiza.evotor.ru/wp-content/themes/evotor/ZHIZA_Viber.png"/>
        <meta property="twitter:image:src" content="https://zhiza.evotor.ru/wp-content/themes/evotor/ZHIZA_VK.png"/>
        <meta property="og:image" content="https://zhiza.evotor.ru/wp-content/themes/evotor/ZHIZA_Odnoklassniki.png"/>
    <?php endif; ?>

    <?php if (ENABLE_METRICS): ?>
        <!-- VK Retargeting -->
        <script type="text/javascript">!function () {
                var t = document.createElement("script");
                t.type = "text/javascript", t.async = !0, t.src = "https://vk.com/js/api/openapi.js?160", t.onload = function () {
                    VK.Retargeting.Init("VK-RTRG-312094-8gYwD"), VK.Retargeting.Hit()
                }, document.head.appendChild(t)
            }();</script>
        <noscript><img src="https://vk.com/rtrg?p=VK-RTRG-312094-8gYwD" style="position:fixed; left:-999px;" alt=""/></noscript>
        <!-- End VK Retargeting -->
        <!-- Google Tag Manager -->
    <?php if ( !amp_is_request() ): ?>
        <script>
            (function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-NFGF235');
        </script>
    <?php endif; ?>
        <!-- End Google Tag Manager -->
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (m, e, t, r, i, k, a) {
                m[i] = m[i] || function () {
                    (m[i].a = m[i].a || []).push(arguments)
                };
                m[i].l = 1 * new Date();
                k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
            })
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(38756435, "init", {
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true,
                webvisor: true,
                ecommerce: "dataLayer"
            });
        </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/38756435" style="position:absolute; left:-9999px;" alt=""/></div>
        </noscript>
        <!-- /Yandex.Metrika counter -->
        <!-- Google Analytics -->
    <?php if ( amp_is_request() ): ?>
        <!-- AMP Analytics -->
        <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
    <?php else: ?>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o), m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-84163503-13', 'auto', {'allowLinker': true});
            ga('require', 'linker');
            ga('require', 'GTM-MWGCV99');
            ga('linker:autoLink', ['evotor.ru', 'marka.evotor.ru', 'market.evotor.ru']);
            ga('send', 'pageview');
        </script>
    <?php endif; ?>
        <!-- End Google Analytics -->
    <?php endif; ?>

    <?php get_template_part( 'template_parts/schema_org/NewsArticle' ); ?>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "url": "https://zhiza.evotor.ru",
            "logo": "https://zhiza.evotor.ru/wp-content/themes/evotor/logo.png"
        }
    </script>
</head>


<body class="bg--gray">

<?php if (ENABLE_METRICS): ?>
    <!-- Google Tag Manager (noscript) -->
    <?php if ( amp_is_request() ): ?>
        <!-- Google Tag Manager -->
        <amp-analytics config="https://www.googletagmanager.com/amp.json?id=GTM-WMQJR78&gtm.url=SOURCE_URL"
                       data-credentials="include"></amp-analytics>
    <?php else: ?>
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NFGF235"
                    height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
    <?php endif; ?>
    <!-- End Google Tag Manager (noscript) -->
<?php endif; ?>

<?php if ( amp_is_request() ): ?>
    <amp-sidebar id="amp-sidebar" class="sample-sidebar" layout="nodisplay" side="left">
        <?php get_template_part('template_parts/menu/mobile-nav-menu');?>
    </amp-sidebar>
<?php else: ?>
    <div id="m_menu">
        <?php get_template_part('template_parts/menu/mobile-nav-menu');?>
    </div>

    <div id="close_mobile_menu" class="page_mask">
        <div class="close"></div>
    </div>
<?php endif; ?>

<header id="header" class="header">
    <nav class="nav new-wrapper">
        <div id="menu_btn" class="hamburger">
            <img width="24" height="24" alt="" <?= amp_is_request() ? 'on="tap:amp-sidebar.toggle"' : '' ?>
                 src="data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cmask id='mask0' mask-type='alpha' maskUnits='userSpaceOnUse' x='0' y='4' width='24' height='16'%3E%3Cpath d='M0 18.6667C0 19.403 0.596954 20 1.33333 20H22.6667C23.403 20 24 19.403 24 18.6667C24 17.9303 23.403 17.3333 22.6667 17.3333H1.33333C0.596954 17.3333 0 17.9303 0 18.6667ZM0 12C0 12.7364 0.596954 13.3333 1.33333 13.3333H22.6667C23.403 13.3333 24 12.7364 24 12C24 11.2636 23.403 10.6667 22.6667 10.6667H1.33333C0.596954 10.6667 0 11.2636 0 12ZM1.33333 4C0.596954 4 0 4.59695 0 5.33333C0 6.06971 0.596954 6.66667 1.33333 6.66667H22.6667C23.403 6.66667 24 6.06971 24 5.33333C24 4.59695 23.403 4 22.6667 4H1.33333Z' fill='black'%3E%3C/path%3E%3C/mask%3E%3Cg mask='url(%23mask0)'%3E%3Crect width='24' height='24' fill='%23DF5B35'%3E%3C/rect%3E%3C/g%3E%3C/svg%3E"/>
        </div>

        <a href="/" class="nav__logo" title="Жиза — онлайн-журнал Эвотора о малом бизнесе">
            <img src="/logo.svg"
                 width="128" height="33"
                 decoding="async"
                 alt="Жиза — онлайн-журнал Эвотора о малом бизнесе"
                 title="Жиза — онлайн-журнал Эвотора о малом бизнесе"
            />
        </a>

        <?php wp_nav_menu([
            'theme_location' => 'top-pages-menu',
            'container_class' => '',
            'menu_class' => 'nav_menu--links',
            'container' => '',
        ]); ?>

        <?php if ( amp_is_request() ): ?>
            <a href="/?amp&s=">
                <?php get_template_part('template_parts/menu/search');?>
            </a>
        <?php else: ?>
            <?php get_template_part('template_parts/menu/search'); ?>
        <?php endif; ?>
    </nav>

    <?php get_template_part('template_parts/search/search-panel'); ?>
</header>
