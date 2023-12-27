<?php
/**
 * Общий компонент баннера. Определяет, какой баннер требуется отрисовать в соответствии от пришедших данных
 * из аргументов.
 * @var $args
 */

[
    /** @var string $image Изображение баннера */
    'image' => $image,
    /** @var string $text Текст баннера */
    'text'  => $text,
    /** @var bool $hasAd В блоке имеется реклама */
    'hasAd' => $hasAd,
    'block' => $block,
    'hideAd' => $hideAd,
] = $args;

[
       /** @var string $adBannerId ID рекламной компании */
       'ad_banner_id' => $adBannerId,
       /** @var string $adBannerCompany Название рекламной компании */
       'ad_company' => $adBannerCompany,
] = $block;

if ($hideAd && $hasAd) {
    return;
}

// Определение, какой класс ставить баннеру
$type = '';
if (!$image) {
    $type = 'no-image';
    if (!$text) {
        $type = 'no-text-no-image';
    }
} else {
    if ($hasAd) {
        $type = 'haveADS';
    }
}
?>

<div class="singleBanner <?= $type ?>">
    <?php /** TODO Очистить текст для вставки в ALT и TITLE  */ ?>
    <?php /** Ссылка в баннере прописана напрямую с $text, т.к. это HTML редактор  */ ?>
    <?php if ( $image ): ?>
        <img src="<?= $image ?>"
             alt=""
             title=""
             width="200"
             height="200"
             loading="lazy"
             decoding="async"
        />
    <?php endif; ?>

    <?php if ($text): ?>
        <div class="banner-text">
            <?= $text ?>
        </div>
    <?php endif; ?>

    <?php if ($hasAd): ?>
        <p class="new-ad ads-info gray-v <?= !$text ? 'mt-0' : '' ?>">
            На правах рекламы
            <span class="square"></span>
            <?= $adBannerCompany ?: 'ООО “Эвотор”' ?>
            <span class="square"></span>
            <?= $adBannerId ?>
        </p>
    <?php endif; ?>
</div>
