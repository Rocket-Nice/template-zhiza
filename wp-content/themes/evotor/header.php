<?php
header ("Last-Modified: " . date("D, d M Y H:i:s", strtotime($post->post_modified)) . " GMT");
?>
<!doctype html>
<html lang="ru-RU">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="robots" content="follow, index"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="4f92bb4bd07ce18f" />
    <meta name="google-site-verification" content="hyw6FsptIVSnj5zG9wczqHJh104hFJ7dUTIfIQf5n-Y"/>

    <link rel="preload" href="/wp-content/themes/evotor/fonts/kazimir-bold-web.woff2" as="font" type="font/woff" crossorigin="">
    <link rel="preload" href="/wp-content/themes/evotor/fonts/graphik-regular-web.woff2" as="font" type="font/woff" crossorigin="">
    <link rel="preload" href="/wp-content/themes/evotor/fonts/graphik-bold-web.woff2" as="font" type="font/woff" crossorigin="">

    <?php // amp_add_amphtml_link() ?>

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


<body class="n_main_page">

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

<div id="m_menu">
    <?php get_template_part('template_parts/menu/mobile-nav-menu');?>
</div>

<?php if ( amp_is_request() ): ?>
    <amp-sidebar id="amp-sidebar" class="sample-sidebar" layout="nodisplay" side="left">
        <?php get_template_part('template_parts/menu/mobile-nav-menu');?>
    </amp-sidebar>
<?php endif; ?>

<div class="page" id="all_apge_wrapper">
    <div class="page_mask">
        <div class="close"></div>
    </div>

    <header id="n_header" <?= amp_is_request() ? 'next-page-hide' : '' ?> >
        <div class="wrapper">
            <div id="menu_btn" class="hamburger">
                <img width="24" height="24" alt="" <?= amp_is_request() ? 'on="tap:amp-sidebar.toggle"' : '' ?>
                     src="data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cmask id='mask0' mask-type='alpha' maskUnits='userSpaceOnUse' x='0' y='4' width='24' height='16'%3E%3Cpath d='M0 18.6667C0 19.403 0.596954 20 1.33333 20H22.6667C23.403 20 24 19.403 24 18.6667C24 17.9303 23.403 17.3333 22.6667 17.3333H1.33333C0.596954 17.3333 0 17.9303 0 18.6667ZM0 12C0 12.7364 0.596954 13.3333 1.33333 13.3333H22.6667C23.403 13.3333 24 12.7364 24 12C24 11.2636 23.403 10.6667 22.6667 10.6667H1.33333C0.596954 10.6667 0 11.2636 0 12ZM1.33333 4C0.596954 4 0 4.59695 0 5.33333C0 6.06971 0.596954 6.66667 1.33333 6.66667H22.6667C23.403 6.66667 24 6.06971 24 5.33333C24 4.59695 23.403 4 22.6667 4H1.33333Z' fill='black'%3E%3C/path%3E%3C/mask%3E%3Cg mask='url(%23mask0)'%3E%3Crect width='24' height='24' fill='%23DF5B35'%3E%3C/rect%3E%3C/g%3E%3C/svg%3E"/>
            </div>
            <div class="logo">
                <a href="/" class="main_logo" title="Жиза — онлайн-журнал Эвотора о малом бизнесе">
                    <svg width="128" height="33" viewBox="0 0 128 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M38.7182 33C43.8453 33 44.6851 30.2155 44.6851 25.3978H42.7845C42.7845 29.1989 42.2984 30.1271 41.6796 30.1271C40.9282 30.1271 40.663 28.9779 40.1326 26.9006C38.4088 20.0497 37.9227 19.1215 30.2762 16.6464C34.7403 15.1436 32.884 4.09392 36.7293 3.74033C35.4475 4.44751 35.2265 5.68508 35.2265 6.74586C35.2265 8.73481 36.8177 10.0608 39.0718 10.0608C41.326 10.0608 42.9613 8.42541 42.9613 5.55249C42.9613 2.54696 40.7514 1 38.1437 1C29.2155 1 33.105 15.7182 28.0663 15.7182H26.4751V2.94475H28.8619V1H15.9116V2.94475H18.2983V15.7182H16.5746C11.5359 15.7182 15.4696 1 6.49724 1C3.9337 1 1.72376 2.54696 1.72376 5.55249C1.72376 8.42541 3.35912 10.0608 5.74586 10.0608C8.0442 10.0608 9.32597 8.69061 9.32597 6.70166C9.32597 5.33149 8.75138 4.13812 7.77901 3.51934C11.7127 4.71271 9.72376 15.4088 14.0994 16.6464C6.71823 19.2099 6.27624 20.0497 4.55249 26.9006C4.0221 28.9779 3.75691 30.1271 3.04972 30.1271C2.38674 30.1271 1.90055 29.1989 1.90055 25.3978H0C0 30.3039 0.795581 33 5.96685 33C10.3425 33 11.9779 30.6133 12.9945 26.9448C14.0553 23.3646 14.1878 17.663 17.2376 17.663H18.2983V31.0552H15.9116V33H28.8619V31.0552H26.4751V17.663H27.4475C30.4972 17.663 30.5856 23.3646 31.6464 26.9448C32.663 30.6133 34.3425 33 38.7182 33Z" fill="#262626"/>
                        <path d="M60.3094 31.0552H57.9226V28.4917L65.0387 17.6188V31.0552H62.6519V33H76V31.0552H73.0829V11.7845H76V9.83978H62.6519V11.7845H65.0387V14.1713L57.9226 25.0442V11.7845H60.3094V9.83978H46.9613V11.7845H49.8784V31.0552H46.9613V33H60.3094V31.0552Z" fill="#262626"/>
                        <path d="M87.0601 33C92.6733 33 98.817 31.8066 98.817 26.105C98.817 22.3039 94.7065 20.9779 91.038 20.6243C94.9275 20.2265 97.933 18.5028 97.933 15.0995C97.933 10.4586 93.7341 9.0884 88.9606 9.0884C85.6899 9.0884 83.48 9.97238 82.2424 11.0332L80.828 9.1768H79.2369V17.3094H81.1816C81.3584 13.5525 83.48 11.3867 86.3971 11.3867C88.9164 11.3867 90.0656 12.8453 90.0656 15.3646C90.0656 18.3702 89.27 19.8287 85.9993 19.8287H83.6126V21.7293H85.9551C89.4026 21.7293 90.817 22.9669 90.817 26.1934C90.817 29.4199 89.3142 31.0111 86.3529 31.0111C84.585 31.0111 83.259 30.7017 82.2866 29.9503C83.7894 29.4641 84.9827 28.4917 84.9827 26.5028C84.9827 24.558 83.922 23.0111 81.3584 23.0111C78.9275 23.0111 77.7341 24.7348 77.7341 26.7238C77.7341 30.7017 80.9606 33 87.0601 33Z" fill="#262626"/>
                        <path d="M121.493 33C125.647 33 127.46 30.7901 127.46 25.5304H125.559C125.559 28.8453 124.763 30.0387 123.835 30.0387C122.996 30.0387 122.642 29.3757 122.642 28.1823V16.1602C122.642 11.7845 119.194 9.0884 112.918 9.0884C107.216 9.0884 101.913 11.5193 101.913 15.7624C101.913 17.7956 103.15 19.3867 105.802 19.3867C108.321 19.3867 109.515 17.7956 109.515 15.7624C109.515 13.6851 108.366 12.7127 106.73 12.1381C107.261 11.6961 108.542 11.2983 109.957 11.2983C112.962 11.2983 114.598 12.9337 114.598 16.6022V19.8287L111.415 20.2707C104.211 21.2873 101.117 23.5856 101.117 27.4309C101.117 31.232 104.123 33 107.835 33C112.034 33 114.598 30.7459 115.482 27.5193C115.879 31.1878 117.957 33 121.493 33ZM111.371 28.9337C110.045 28.9337 109.205 28.1823 109.205 26.2376C109.205 24.1602 110.045 22.7459 113.051 22.0829L114.598 21.7293V23.1878C114.598 27.1657 113.316 28.9337 111.371 28.9337Z" fill="#262626"/>
                        <path d="M53.6075 6.4273C53.2875 6.4273 53.0325 6.3498 52.8425 6.1948C52.6575 6.0348 52.5125 5.7698 52.4075 5.3998C52.3775 5.2998 52.34 5.1448 52.295 4.9348C52.255 4.7248 52.225 4.5798 52.205 4.4998C52.15 4.2598 52.08 4.0873 51.995 3.9823C51.915 3.8773 51.815 3.8248 51.695 3.8248H51.53V5.9698H51.935V6.2998H49.7375V5.9698H50.1425V3.8248H49.9625C49.8425 3.8248 49.74 3.8773 49.655 3.9823C49.575 4.0873 49.505 4.2598 49.445 4.4998C49.425 4.5798 49.3925 4.7248 49.3475 4.9348C49.3075 5.1448 49.2725 5.2998 49.2425 5.3998C49.1375 5.7748 48.9925 6.0398 48.8075 6.1948C48.6225 6.3498 48.37 6.4273 48.05 6.4273C47.68 6.4273 47.4175 6.3398 47.2625 6.1648C47.1125 5.9848 47.0375 5.6423 47.0375 5.1373H47.36C47.36 5.4123 47.375 5.6148 47.405 5.7448C47.435 5.8748 47.485 5.9398 47.555 5.9398C47.6 5.9398 47.6375 5.9123 47.6675 5.8573C47.6975 5.8023 47.745 5.6473 47.81 5.3923C47.91 5.0023 47.99 4.7348 48.05 4.5898C48.115 4.4398 48.195 4.3173 48.29 4.2223C48.38 4.1273 48.505 4.0398 48.665 3.9598C48.825 3.8748 49.08 3.7723 49.43 3.6523C49.295 3.6123 49.185 3.5173 49.1 3.3673C49.015 3.2173 48.935 2.9273 48.86 2.4973C48.785 2.0923 48.71 1.8223 48.635 1.6873C48.565 1.5473 48.4725 1.4598 48.3575 1.4248C48.4375 1.4748 48.5 1.5498 48.545 1.6498C48.595 1.7448 48.62 1.8498 48.62 1.9648C48.62 2.1398 48.565 2.2798 48.455 2.3848C48.35 2.4848 48.2025 2.5348 48.0125 2.5348C47.8025 2.5348 47.635 2.4673 47.51 2.3323C47.39 2.1923 47.33 2.0048 47.33 1.7698C47.33 1.5348 47.405 1.3473 47.555 1.2073C47.705 1.0673 47.9 0.997305 48.14 0.997305C48.335 0.997305 48.5025 1.0398 48.6425 1.1248C48.7875 1.2048 48.9075 1.3298 49.0025 1.4998C49.0575 1.6048 49.105 1.7273 49.145 1.8673C49.19 2.0023 49.24 2.2173 49.295 2.5123C49.375 2.9273 49.455 3.1948 49.535 3.3148C49.615 3.4348 49.72 3.4948 49.85 3.4948H50.1425V1.4548H49.7375V1.1248H51.935V1.4548H51.53V3.4948H51.8C51.93 3.4948 52.035 3.4348 52.115 3.3148C52.195 3.1948 52.275 2.9273 52.355 2.5123C52.41 2.2173 52.4575 2.0023 52.4975 1.8673C52.5425 1.7273 52.595 1.6048 52.655 1.4998C52.745 1.3298 52.86 1.2048 53 1.1248C53.145 1.0398 53.315 0.997305 53.51 0.997305C53.755 0.997305 53.9525 1.0673 54.1025 1.2073C54.2525 1.3473 54.3275 1.5348 54.3275 1.7698C54.3275 2.0048 54.2675 2.1923 54.1475 2.3323C54.0275 2.4673 53.8675 2.5348 53.6675 2.5348C53.4725 2.5348 53.315 2.4823 53.195 2.3773C53.075 2.2723 53.015 2.1373 53.015 1.9723C53.015 1.8473 53.035 1.7423 53.075 1.6573C53.12 1.5723 53.185 1.5073 53.27 1.4623C53.155 1.4723 53.06 1.5398 52.985 1.6648C52.915 1.7898 52.8425 2.0498 52.7675 2.4448C52.6825 2.8848 52.595 3.1848 52.505 3.3448C52.42 3.5048 52.31 3.6073 52.175 3.6523C52.525 3.7673 52.7825 3.8648 52.9475 3.9448C53.1175 4.0248 53.2525 4.1123 53.3525 4.2073C53.4525 4.3023 53.535 4.4248 53.6 4.5748C53.665 4.7248 53.7475 4.9973 53.8475 5.3923C53.9125 5.6473 53.96 5.8023 53.99 5.8573C54.025 5.9123 54.065 5.9398 54.11 5.9398C54.175 5.9398 54.2225 5.8748 54.2525 5.7448C54.2825 5.6148 54.2975 5.4123 54.2975 5.1373H54.62C54.62 5.6373 54.5425 5.9773 54.3875 6.1573C54.2375 6.3373 53.9775 6.4273 53.6075 6.4273ZM56.5302 6.4273C56.2602 6.4273 56.0352 6.3373 55.8552 6.1573C55.6752 5.9773 55.5852 5.7323 55.5852 5.4223C55.5852 5.2023 55.6477 5.0248 55.7727 4.8898C55.8977 4.7548 56.0652 4.6873 56.2752 4.6873C56.4702 4.6873 56.6252 4.7473 56.7402 4.8673C56.8552 4.9873 56.9127 5.1448 56.9127 5.3398C56.9127 5.5248 56.8602 5.6748 56.7552 5.7898C56.6502 5.8998 56.4977 5.9623 56.2977 5.9773C56.3277 6.0123 56.3702 6.0398 56.4252 6.0598C56.4802 6.0748 56.5477 6.0823 56.6277 6.0823C56.7977 6.0823 56.9402 6.0298 57.0552 5.9248C57.1702 5.8148 57.2927 5.6098 57.4227 5.3098L55.6152 1.4548H55.2102V1.1248H57.7152V1.4548H57.0702L58.0977 3.6298L58.9227 1.4548H58.3152V1.1248H59.7627V1.4548H59.3277L58.2102 4.3423C57.8452 5.2773 57.5627 5.8598 57.3627 6.0898C57.1677 6.3148 56.8902 6.4273 56.5302 6.4273ZM63.2619 6.2998H60.5619V5.9698H61.0644V1.4548H60.5619V1.1248H62.6319C63.3769 1.1248 63.9394 1.2498 64.3194 1.4998C64.7044 1.7498 64.8969 2.1198 64.8969 2.6098C64.8969 3.1048 64.7069 3.4923 64.3269 3.7723C63.9519 4.0523 63.4194 4.1923 62.7294 4.1923H62.4669V5.9698H63.2619V6.2998ZM63.5169 2.6173C63.5169 2.2023 63.4469 1.9048 63.3069 1.7248C63.1669 1.5448 62.9419 1.4548 62.6319 1.4548H62.4669V3.8623H62.6244C62.9294 3.8623 63.1544 3.7648 63.2994 3.5698C63.4444 3.3698 63.5169 3.0523 63.5169 2.6173ZM68.2112 6.2998H65.9012V5.9698H66.4037V1.4548H65.9012V1.1248H68.2112V1.4548H67.8062V3.4948H69.1787V1.4548H68.7812V1.1248H71.0912V1.4548H70.5812V5.9698H71.0912V6.2998H68.7812V5.9698H69.1787V3.8248H67.8062V5.9698H68.2112V6.2998ZM73.2591 4.3948H74.4741L73.8591 2.5273L73.2591 4.3948ZM73.3491 6.2998H71.9166V5.9698H72.3591L73.9866 1.0498H74.7816L76.4541 5.9698H76.8816V6.2998H74.3091V5.9698H74.9841L74.5791 4.7248H73.1541L72.7566 5.9698H73.3491V6.2998ZM80.8653 5.9698V1.4548H79.7778C79.7778 2.1648 79.7728 2.7323 79.7628 3.1573C79.7578 3.5823 79.7453 3.9448 79.7253 4.2448C79.6753 5.0698 79.5628 5.6398 79.3878 5.9548C79.2178 6.2698 78.9353 6.4273 78.5403 6.4273C78.2703 6.4273 78.0478 6.3423 77.8728 6.1723C77.6978 6.0023 77.6103 5.7773 77.6103 5.4973C77.6103 5.2823 77.6703 5.1073 77.7903 4.9723C77.9153 4.8323 78.0803 4.7623 78.2853 4.7623C78.4853 4.7623 78.6428 4.8223 78.7578 4.9423C78.8778 5.0623 78.9378 5.2123 78.9378 5.3923C78.9378 5.5573 78.8878 5.7023 78.7878 5.8273C78.6878 5.9523 78.5753 6.0223 78.4503 6.0373C78.4653 6.0523 78.4878 6.0648 78.5178 6.0748C78.5478 6.0798 78.5803 6.0823 78.6153 6.0823C78.8503 6.0823 79.0203 5.9223 79.1253 5.6023C79.2303 5.2823 79.3003 4.7223 79.3353 3.9223C79.3503 3.6273 79.3603 3.2848 79.3653 2.8948C79.3703 2.4998 79.3728 2.0198 79.3728 1.4548H78.7128V1.1248H82.7628V1.4548H82.2528V5.9698H82.7628V6.2998H80.3478V5.9698H80.8653ZM90.3263 3.7123C90.3263 4.4873 90.1163 5.1348 89.6963 5.6548C89.2813 6.1698 88.7388 6.4273 88.0688 6.4273C87.8588 6.4273 87.6663 6.3998 87.4913 6.3448C87.3163 6.2898 87.1563 6.2073 87.0113 6.0973L86.7113 6.3748H86.4938V4.6198H86.8238C86.8238 5.0548 86.9138 5.4023 87.0938 5.6623C87.2788 5.9173 87.5363 6.0448 87.8663 6.0448C88.2163 6.0448 88.4663 5.8748 88.6163 5.5348C88.7713 5.1898 88.8513 4.6198 88.8563 3.8248H87.2813V3.4948H88.8563C88.8463 2.7348 88.7663 2.1923 88.6163 1.8673C88.4663 1.5423 88.2163 1.3798 87.8663 1.3798C87.5613 1.3798 87.3163 1.5073 87.1313 1.7623C86.9513 2.0173 86.8613 2.3548 86.8613 2.7748H86.5313V1.0498H86.7488L87.0488 1.3273C87.1738 1.2173 87.3238 1.1348 87.4988 1.0798C87.6738 1.0248 87.8688 0.997305 88.0838 0.997305C88.7488 0.997305 89.2888 1.2573 89.7038 1.7773C90.1188 2.2923 90.3263 2.9373 90.3263 3.7123ZM93.7364 6.2998H91.4039V5.9698H91.9064V1.4548H91.4039V1.1248H93.4514C94.2064 1.1248 94.7714 1.2323 95.1464 1.4473C95.5264 1.6573 95.7164 1.9723 95.7164 2.3923C95.7164 2.7123 95.5964 2.9823 95.3564 3.2023C95.1214 3.4173 94.7989 3.5523 94.3889 3.6073C94.8889 3.6723 95.2739 3.8148 95.5439 4.0348C95.8139 4.2548 95.9489 4.5398 95.9489 4.8898C95.9489 5.3648 95.7664 5.7198 95.4014 5.9548C95.0364 6.1848 94.4814 6.2998 93.7364 6.2998ZM94.3439 2.3998C94.3439 2.0698 94.2739 1.8298 94.1339 1.6798C93.9939 1.5298 93.7689 1.4548 93.4589 1.4548H93.3089V3.4798H93.5339C93.8039 3.4798 94.0064 3.3923 94.1414 3.2173C94.2764 3.0373 94.3439 2.7648 94.3439 2.3998ZM94.5089 4.8523C94.5089 4.4873 94.4314 4.2173 94.2764 4.0423C94.1264 3.8673 93.8939 3.7798 93.5789 3.7798H93.3089V5.9698H93.6014C93.9264 5.9698 94.1589 5.8848 94.2989 5.7148C94.4389 5.5398 94.5089 5.2523 94.5089 4.8523ZM99.3477 0.997305C100.048 0.997305 100.61 1.2548 101.035 1.7698C101.465 2.2798 101.68 2.9273 101.68 3.7123C101.68 4.4973 101.465 5.1473 101.035 5.6623C100.61 6.1723 100.048 6.4273 99.3477 6.4273C98.6477 6.4273 98.0827 6.1723 97.6527 5.6623C97.2227 5.1473 97.0077 4.4973 97.0077 3.7123C97.0077 2.9273 97.2227 2.2798 97.6527 1.7698C98.0827 1.2548 98.6477 0.997305 99.3477 0.997305ZM99.3477 1.3348C99.0327 1.3348 98.8102 1.5198 98.6802 1.8898C98.5502 2.2548 98.4852 2.8623 98.4852 3.7123C98.4852 4.5623 98.5502 5.1723 98.6802 5.5423C98.8102 5.9073 99.0327 6.0898 99.3477 6.0898C99.6627 6.0898 99.8852 5.9073 100.015 5.5423C100.145 5.1723 100.21 4.5623 100.21 3.7123C100.21 2.8623 100.145 2.2548 100.015 1.8898C99.8852 1.5198 99.6627 1.3348 99.3477 1.3348ZM105.953 6.2998H103.418V5.9698H103.98V1.4548H103.853C103.523 1.4548 103.283 1.5448 103.133 1.7248C102.983 1.9048 102.908 2.1923 102.908 2.5873V2.7748H102.578V1.1248H106.793V2.7748H106.463V2.5873C106.463 2.1923 106.385 1.9048 106.23 1.7248C106.08 1.5448 105.84 1.4548 105.51 1.4548H105.383V5.9698H105.953V6.2998ZM110.026 0.997305C110.726 0.997305 111.289 1.2548 111.714 1.7698C112.144 2.2798 112.359 2.9273 112.359 3.7123C112.359 4.4973 112.144 5.1473 111.714 5.6623C111.289 6.1723 110.726 6.4273 110.026 6.4273C109.326 6.4273 108.761 6.1723 108.331 5.6623C107.901 5.1473 107.686 4.4973 107.686 3.7123C107.686 2.9273 107.901 2.2798 108.331 1.7698C108.761 1.2548 109.326 0.997305 110.026 0.997305ZM110.026 1.3348C109.711 1.3348 109.489 1.5198 109.359 1.8898C109.229 2.2548 109.164 2.8623 109.164 3.7123C109.164 4.5623 109.229 5.1723 109.359 5.5423C109.489 5.9073 109.711 6.0898 110.026 6.0898C110.341 6.0898 110.564 5.9073 110.694 5.5423C110.824 5.1723 110.889 4.5623 110.889 3.7123C110.889 2.8623 110.824 2.2548 110.694 1.8898C110.564 1.5198 110.341 1.3348 110.026 1.3348ZM116.142 6.2998H113.442V5.9698H113.945V1.4548H113.442V1.1248H115.512C116.257 1.1248 116.82 1.2498 117.2 1.4998C117.585 1.7498 117.777 2.1198 117.777 2.6098C117.777 3.1048 117.587 3.4923 117.207 3.7723C116.832 4.0523 116.3 4.1923 115.61 4.1923H115.347V5.9698H116.142V6.2998ZM116.397 2.6173C116.397 2.2023 116.327 1.9048 116.187 1.7248C116.047 1.5448 115.822 1.4548 115.512 1.4548H115.347V3.8623H115.505C115.81 3.8623 116.035 3.7648 116.18 3.5698C116.325 3.3698 116.397 3.0523 116.397 2.6173ZM119.299 4.3948H120.514L119.899 2.5273L119.299 4.3948ZM119.389 6.2998H117.956V5.9698H118.399L120.026 1.0498H120.821L122.494 5.9698H122.921V6.2998H120.349V5.9698H121.024L120.619 4.7248H119.194L118.796 5.9698H119.389V6.2998Z" fill="#262626"/>
                    </svg>
                </a>
            </div>

            <div class="top_nav">
                <?php wp_nav_menu(array('theme_location' => 'top-pages-menu', 'container_class' => '', 'menu_class' => '', 'container' => '',)); ?>
            </div>

            <?php if ( amp_is_request() ): ?>
                <a href="/?amp&s=">
                    <?php get_template_part('template_parts/menu/nav-search');?>
                </a>
            <?php else: ?>
                <?php get_template_part('template_parts/menu/nav-search');?>
            <?php endif; ?>
        </div>

        <div class="search_box">
            <div class="wrapper">
                <form class="search_form" action="<?php bloginfo('url'); ?>" method="GET">
                    <input type="text" name="s" placeholder="Найти" value="<?php if (!empty($_GET['s'])) {
                        echo $_GET['s'];
                    } ?>">
                    <input type="submit" value="">
                </form>

                <div id="search_close"></div>
            </div>
        </div>
    </header>

    <div id="cookie_banner">
        <!--noindex-->
        <div class="wrapper">
            <div class="cookie-content">
                <div class="left-side">
                    <div class="cookie"></div>

                    <div class="text-wrap">
                        <strong>Использование cookie</strong>
                        <p>Оставаясь на сайте, вы <a href="https://evotor.ru/legal/cookie" class="link" target="_blank">соглашаетесь</a> на использование файлов cookies.</p>
                    </div>
                </div>
                <div class="right-side">
                    <div id="accept-cookie">
                        Принять
                    </div>
                </div>
            </div>
        </div>
        <!--/noindex-->
    </div>
