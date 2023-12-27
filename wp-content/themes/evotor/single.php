<?php
get_template_part( 'header_redesign' );
$pdb_bot = get_field( 'single_page_posts' ); ?>

<main class="page-content page-single">
    <section class="new-wrapper content-padding overflow-tablet data-sticky-container p-b-md-0" style="padding-top: 0;"
             data-sticky-container>
        <?php get_breadcrumb( 'page--style page--single' ) ?>

        <?php
        // Заголовки для оглавления
        $content    = get_field( 'flexible_content' );
        $titlesList = [];
        $key        = 1;
        ?>
        <?php foreach ( $content as $block ): ?>
            <?php
            $blockType = $block['acf_fc_layout'];

            switch ( $blockType ) {
                case 'page_text_block':
                    preg_match_all( '@<h2.*?>(.*?)<\/h2>@', $block["page_text"], $matches );
                    foreach ( $matches[0] as $match ) {
                        preg_match_all( '~>\K.+?(?=<)~', $match, $titleText );
                        $titlesList[ $key ] = [
                            'title'     => $titleText[0][0],
                            'titleType' => 2
                        ];
                        $key ++;
                    }
                    preg_match_all( '@<h3.*?>(.*?)<\/h3>@', $block["page_text"], $matches );
                    foreach ( $matches[0] as $match ) {
                        preg_match_all( '~>\K.+?(?=<)~', $match, $titleText );
                        $titlesList[ $key ] = [
                            'title'     => $titleText[0][0],
                            'titleType' => 3
                        ];
                        $key ++;
                    }
                    break;
                case 'page_table_block':
                    preg_match_all( '@<h2.*?>(.*?)<\/h2>@', $block["page_table"], $matches );
                    foreach ( $matches[0] as $match ) {
                        preg_match_all( '~>\K.+?(?=<)~', $match, $titleText );
                        $titlesList[ $key ] = [
                            'title'     => $titleText[0][0],
                            'titleType' => 2
                        ];
                        $key ++;
                    }
                    preg_match_all( '@<h3.*?>(.*?)<\/h3>@', $block["page_table"], $matches );
                    foreach ( $matches[0] as $match ) {
                        preg_match_all( '~>\K.+?(?=<)~', $match, $titleText );
                        $titlesList[ $key ] = [
                            'title'     => $titleText[0][0],
                            'titleType' => 3
                        ];
                        $key ++;
                    }
                    break;
            } ?>

        <?php endforeach; ?>

        <div class="content-table">
            <div class="content-table_accord__container">
                <div class="content-table_accord accord">
                    <div class="accord_head">
                        <div class="accord_title">
                            Что в статье
                        </div>
                        <div class="accord_arrow">
                            <svg width="18" height="10" viewBox="0 0 18 10" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.999999 1.5L9 8.5L17 1.5" stroke="white" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="accord_body">
                        <ol class="content-table_title-list">
                            <?php foreach ( $titlesList as $key => $titlesItem ) {
                                if ( $titlesItem["titleType"] === 2 ) {
                                    ?>
                                    <li class="content-table_item">
                                        <a href="#<?= $key ?>"><?= $titlesItem["title"] ?></a>
                                    </li>
                                <?php }
                                if ( $titlesItem["titleType"] === 3 ) {
                                    ?>
                                    <li class="content-table_item content-table_item__sub">
                                        <a href="#<?= $key ?>"><?= $titlesItem["title"] ?></a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <?php get_template_part( 'template_parts/single/single__post_preview' ) ?>

        <div class="content-table__sticky">
            <div class="common-text box">
                <div class="basic"></div>
                <div class="banner content-table_accord__container" style="padding-bottom: 60px" data-margin-top="82">
                    <div id="left" class="content-table_accord accord">
                        <div class="accord_head">
                            <div class="accord_title">
                                Что в статье
                            </div>
                            <div class="accord_arrow">
                                <svg width="18" height="10" viewBox="0 0 18 10" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.999999 1.5L9 8.5L17 1.5" stroke="white" stroke-width="2"
                                          stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                        <div class="accord_body">
                            <ol class="content-table_title-list">
                                <?php foreach ( $titlesList as $key => $titlesItem ) {
                                    if ( $titlesItem["titleType"] === 2 ) {
                                        ?>
                                        <li class="content-table_item">
                                            <a href="#<?= $key ?>"><?= $titlesItem["title"] ?></a>
                                        </li>
                                    <?php }
                                    if ( $titlesItem["titleType"] === 3 ) {
                                        ?>
                                        <li class="content-table_item content-table_item__sub">
                                            <a href="#<?= $key ?>"><?= $titlesItem["title"] ?></a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php get_template_part( 'template_parts/single/single__post_content' ) ?>
    </section>

    <section class="new-wrapper content-padding p-t-md-0 p-b-md-0">
        <div class="soc_block">
            <?php
            $post_id = get_the_ID();
            echo do_shortcode( '[posts_like_dislike id=' . $post_id . ']' );
            ?>
            <div class="share">
                <div class="likely">
                    <div class="vkontakte"
                         onclick="dataLayer.push({'event':'evotorblog','eventCategory':'поделиться статьей','eventAction':'vk','eventLabel': window.location.href,});">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M12 0C5.38378 0 0 5.24211 0 11.6842V12.3158C0 18.7579 5.38378 24 12 24C18.6162 24 24 18.7579 24 12.3158V11.6842C24 5.24211 18.6162 0 12 0ZM12.5838 15.2211H11.8703C11.8703 15.2211 10.2486 15.2842 8.82162 13.9579C7.26486 12.4421 5.83784 9.53684 5.83784 9.53684C5.83784 9.53684 5.77297 9.34737 5.83784 9.22105C5.96757 9.09474 6.22703 9.09474 6.22703 9.09474H7.97838C7.97838 9.09474 8.17297 9.09474 8.23784 9.22105C8.36757 9.28421 8.36757 9.41053 8.36757 9.41053C8.36757 9.41053 8.62703 10.0421 9.01622 10.6737C9.72973 11.8105 10.1189 12.0632 10.3784 11.9368C10.7676 11.7474 10.6378 10.2947 10.6378 10.2947C10.6378 10.2947 10.6378 9.78947 10.4432 9.53684C10.3135 9.34737 9.98919 9.28421 9.92432 9.28421C9.79459 9.28421 9.98919 9.03158 10.1838 8.96842C10.5081 8.8421 11.0919 8.8421 11.7405 8.8421C12.2595 8.8421 12.3892 8.90526 12.5838 8.90526C13.0378 9.03158 13.0378 9.34737 13.0378 10.0421C13.0378 10.2316 13.0378 10.4842 13.0378 10.8C13.0378 10.8632 13.0378 10.9263 13.0378 10.9895C13.0378 11.3684 13.0378 11.7474 13.2973 11.9368C13.427 12 13.7514 11.9368 14.5946 10.6737C14.9838 10.0421 15.3081 9.34737 15.3081 9.34737C15.3081 9.34737 15.373 9.22105 15.5027 9.15789C15.6324 9.09474 15.7622 9.09474 15.7622 9.09474H17.6432C17.6432 9.09474 18.227 9.03158 18.2919 9.28421C18.3568 9.53684 18.0973 10.1053 17.3189 10.9895C16.6054 11.8737 16.2162 12.1895 16.2811 12.4421C16.2811 12.6316 16.5405 12.8211 16.9946 13.2C17.9027 13.9579 18.1622 14.4 18.227 14.4632C18.6162 15.0947 17.773 15.1579 17.773 15.1579H16.0865C16.0865 15.1579 15.7622 15.2211 15.2432 14.9053C14.9838 14.7789 14.7892 14.5263 14.5297 14.2737C14.2054 13.8947 13.8811 13.5789 13.5568 13.6421C13.1027 13.7684 13.1027 14.6526 13.1027 14.6526C13.1027 14.6526 13.1027 14.8421 12.973 14.9684C12.8432 15.1579 12.5838 15.2211 12.5838 15.2211Z"
                                  fill="#DF5B35"/>
                        </svg>
                        Поделиться
                    </div>
                    <div class="telegram"
                         onclick="dataLayer.push({'event':'evotorblog','eventCategory':'поделиться статьей','eventAction':'tg','eventLabel': window.location.href,});">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M11.9677 0C5.36927 0 0 5.36927 0 12.0323C0 18.6307 5.36927 24 11.9677 24C18.6307 24 24 18.6307 24 12.0323C24 5.36927 18.6307 0 11.9677 0ZM8.02156 13.3261L5.1752 12.2911C4.91644 12.1617 4.91644 11.7736 5.1752 11.6442L16.7547 7.18059C17.0135 7.1159 17.2722 7.30997 17.2075 7.56873L15.1375 17.531C15.0728 17.7898 14.814 17.8544 14.6199 17.7251L11.7736 15.655C11.5795 15.5256 11.3854 15.5256 11.1914 15.655L9.63881 16.9488C9.44475 17.0782 9.18598 17.0135 9.12129 16.8194L8.02156 13.3261ZM14.4259 9.31536L8.92722 12.7439C8.73315 12.8733 8.60377 13.1321 8.66846 13.3908L9.25067 15.4609C9.31536 15.5903 9.50943 15.5903 9.50943 15.4609L9.63881 14.2965C9.63881 14.1024 9.76819 13.9084 9.96226 13.7143L14.5553 9.44474C14.6846 9.44474 14.5553 9.25067 14.4259 9.31536Z"
                                  fill="#DF5B35"/>
                        </svg>
                        Отправить
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if ( comments_open( $post->ID ) ): ?>
        <section class="comment_block new-wrapper p-t-md-0 p-b-md-0">
            <?php comments_template(); ?>
        </section>
    <?php endif; ?>

    <section class="new-wrapper new-wrapper__width-unset form-subscribe--bottom-offset">
        <?php if ( ! amp_is_request() ): ?>
            <?php
            // Выбор цвета формы подписки. Делается из редактировании статьи.
            $style      = get_field( 'subscribe_form_style' );
            $styleClass = '';
            switch ( $style ) {
                case 'orange':
                    $styleClass = 'new_sub--orange';
                    break;
                case 'black':
                    $styleClass = 'new_sub--black';
                    break;
                default:
                    $styleClass = 'new_sub--white';
                    break;
            }
            ?>
            <section id="new_sub_main" class="modal new_sub" data-form="new_sub_form_article"
                     data-location="Форма подписки в статье">
                <div class="wrapper <?= $styleClass ?>">
                    <?php $dataLayerPlacement = 'блок подписки в статье'; ?>
                    <?php get_template_part( 'template_parts/subscribe_form', null, [ 'dataLayerPlacement' => $dataLayerPlacement ] ) ?>
                </div>
            </section>
        <?php endif; ?>
    </section>

    <?php if ( $pdb_bot ) { ?>
        <section class="read-more">
            <?php get_template_part( 'template_parts/read-more' ) ?>
        </section>
    <?php } ?>
</main>

<?php get_template_part( 'footer_redesign' ); ?>
