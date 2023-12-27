<?php
if ( isset( $_COOKIE['golden_fund_shown'] ) ) {
    $cookie = 1;
} else {
    setcookie( 'golden_fund_shown', '1', ( time() + 60 * 60 * 24 * 365 ), '/' );
    $cookie = 0;
}
?>

<?php if (!amp_is_request()): ?>
    <div id="modal_subs" style="display: none;">
        <section class="modal new_sub" data-form="new_subscribe_once_modal" data-location="Всплывающее модальное окно">
            <div class="wrapper new_sub--white">
                <?php $dataLayerPlacement = 'поп-ап с подпиской'; ?>
                <?php get_template_part( 'template_parts/subscribe_form', null, [ 'dataLayerPlacement' => $dataLayerPlacement ] ) ?>
            </div>
        </section>
    </div>

    <a href="#modal_subs" id="my_modal_subs_btn" data-fancybox data-auto-focus="false" data-touch="false"></a>
<?php endif; ?>

<div id="cookie_banner" class="wide">
    <!--noindex-->
    <div class="new-wrapper">
        <div class="cookie-content">
            <div class="left-side">
                <div class="cookie"></div>

                <div class="text-wrap">
                    <strong>Использование cookie</strong>
                    <p>Оставаясь на сайте, вы <a href="https://evotor.ru/legal/cookie" class="link" target="_blank">соглашаетесь</a> на использование файлов cookies.</p>
                </div>
            </div>
            <div class="right-side">
                <div class="cookie-accept-wrapper">
                    <div id="accept-cookie">
                        Принять
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/noindex-->
</div>

<footer itemscope itemtype="http://schema.org/WPFooter" <?= amp_is_request() ? 'next-page-hide' : '' ?> >
    <div class="new-wrapper">
        <div class="container">
            <div class="Logo">
                <div class="logo">
                    <a href="/" title="Жиза — онлайн-журнал Эвотора о малом бизнесе">
                        <img src="/logo-light.svg"
                             width="128" height="33"
                             decoding="async"
                             loading="lazy"
                             alt="Жиза — онлайн-журнал Эвотора о малом бизнесе"
                             title="Жиза — онлайн-журнал Эвотора о малом бизнесе"
                        />
                    </a>
                </div>

                <div class="SiteDescription">
                    <p class="describe">
                        Жиза — онлайн-журнал Эвотора о малом бизнесе.
                        Рассказываем о реальном опыте предпринимателей:
                        правда, жизненность, драйв и приключения
                        <br>
                        <br>
                        <span class="copy">
                            @ Жиза <?= date( "Y" ) ?>
                            <meta itemprop="copyrightYear" content="<?= date( "Y" ) ?>">
                            <meta itemprop="copyrightHolder" content="Жиза">
                        </span>
                    </p>

                    <?php get_template_part('template_parts/footer/soc-list') ?>

                    <nav class="sitemap_footer hide-mobile">
                        <a href="/sitemap/" title="Карта сайта" class="link">Карта сайта</a>
                        <a href="/o-proekte/" title="Карта сайта" class="link">О проекте</a>
                    </nav>
                </div>
            </div>

            <div class="NavPages">
                <nav class="pages_list">
                    <a href="/category/practice/" title="Истории" class="link">Истории</a>
                    <a href="/category/theory/" title="Законы" class="link">Законы</a>
                    <a href="/category/provaly/" title="Провалы" class="link">Провалы</a>
                    <a href="/category/money/" title="Деньги" class="link">Деньги</a>
                    <a href="/benefits/" title="Польза" class="link">Польза</a>
                </nav>
            </div>

            <div class="SubForm">
                <p>Получайте раз в неделю подборку лучших статей</p>
                <form id="new_subscribe_form_foot" action="#">
                    <label>
                        <input type="email" placeholder="Электронная почта" name="mail" inputmode="email" required>
                    </label>
                    <div class="btn-wrapper">
                        <input type="submit" value="Подписаться">
                    </div>

                    <!--noindex-->
                    <p id="foot" class="subs_succes">
                        Ура, получилось! Осталось подтвердить адрес. Проверьте почту — там письмо со ссылкой для подтверждения.
                    </p>
                    <!--/noindex-->

                    <!--noindex-->
                    <p class="policy">
                        Подписываясь на рассылку, вы соглашаетесь с
                        <a href="https://evotor.ru/legal/pers-data/" target="_blank" title="Политика персональных данных">
                            политикой персональных данных
                        </a>
                    </p>
                    <!--/noindex-->

                    <?php get_template_part('template_parts/footer/soc-list') ?>

                    <nav class="sitemap_footer">
                        <a href="/sitemap/" title="Карта сайта" class="link">Карта сайта</a>
                        <a href="/o-proekte/" title="Карта сайта" class="link">О проекте</a>
                    </nav>
                </form>
            </div>
        </div>
    </div>
</footer>

<div class="to_top disabled">
    <img src="/wp-content/themes/evotor/assets/images/white_arrow.svg" alt="" width="24" height="11"
         loading="lazy" decoding="async" />
</div>

<?php wp_footer(); ?>

</body>
</html>
