<?php
/**
 * Общий компонент, определяющий стиль отображения текста и наличие баннера в боковой части.
 * @var $args
 */
[
    /** @var boolean $hideAd Скрыть всю рекламу в статье */
    'hideAd' => $hideAd,
    /** @var array $block Текстовый элемент конструктора */
    'block'  => $block,
] = $args;

[
    /** @var string $text Текст блока */
    'page_text'          => $text,
    /** $selectTemplate выбранный шаблон */
    'page_text_template' => $selectTemplate,
    /** @var boolean $blockHasAd Имеет рекламную врезку */
    'show_ads'           => $blockHasAd,
    /** @var bool $showRightBanner Показывать баннер в правой части */
    'page_text_bn'       => $showRightBanner,
    /** @var string $adBannerId ID рекламной компании */
    'ad_banner_id'       => $adBannerId,
    /** @var string $adBannerCompany Название рекламной компании */
    'ad_company'         => $adBannerCompany,
] = $block;

preg_match_all( '@<h2.*?>(.*?)<\/h2>@', $text, $matches );
foreach ( $matches[0] as $match ) {
    $text = str_replace( $match, '<p><a name="' . $GLOBALS['titleCounter'] . '"></a></p>' . $matches[0][0], $text );
    $GLOBALS['titleCounter'] ++;
}
preg_match_all( '@<h3.*?>(.*?)<\/h3>@', $text, $matches );
foreach ( $matches[0] as $match ) {
    $text = str_replace( $match, '<p><a name="' . $GLOBALS['titleCounter'] . '"></a></p>' . $matches[0][0], $text );
    $GLOBALS['titleCounter'] ++;
}
?>

<?php
// Если активирована царь-кнопка, в блоке есть реклама, и это текстовый блок с оранжевой полосой или серый блок (которые могут иметь рекламу в себе)
if ( $blockHasAd && $hideAd && in_array( $selectTemplate, [ 'white', 'orange_line' ], true ) ) {
    return;
}
?>

<div class="common-text box">
    <div class="short-container">
        <div class="basic default-text">
            <?php switch ( $selectTemplate ) {
                case "default": ?>
                    <?= $text ?>
                    <?php break;
                case "white": ?>
                    <div class="gray-block-bg">
                        <?= $text ?>
                        <?php if ( $adBannerId && $blockHasAd ) { ?>
                            <p class="new-ad ads-info gray-v">
                                На правах рекламы
                                <span class="square"></span>
                                <?= $adBannerCompany ?: 'ООО “Эвотор”' ?>
                                <span class="square"></span>
                                <?= $adBannerId ?>
                            </p>
                        <?php } ?>
                    </div>
                    <?php break;
                case "orange_line": ?>
                    <div class="orange-block-bg">
                        <div></div>
                        <div>
                            <?= $text ?>
                                <?php if ( $adBannerId && $blockHasAd ) { ?>
                                <p class="new-ad ads-info gray-v">
                                    На правах рекламы
                                    <span class="square"></span>
                                    <?= $adBannerCompany ?: 'ООО “Эвотор”' ?>
                                    <span class="square"></span>
                                    <?= $adBannerId ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                    <?php break;
            } ?>
        </div>
        <?php if ( $showRightBanner ): ?>
            <?php
            get_template_part( 'template_parts/single/blockTypes/textBlock/banners/commonBanner', null, [
                'block'  => $block,
                'hideAd' => $hideAd,
                'hasAd'  => $blockHasAd,
            ] );
            ?>
        <?php endif; ?>
    </div>
</div>
