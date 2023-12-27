<?php
/**
 * @var $args
 */

[
    /** @var string $linkInBanner Ссылка в баннере */
    'linkInBanner'       => $linkInBanner,

    /** @var string $uniqueBannerPostId Уникальный ID баннера */
    'uniqueBannerPostId' => $uid,

    /** @var string $linkInBanner Ссылка в баннере */
    'linkTextInBanner'   => $linkTextInBanner,

    /** @var string $adBannerId ID рекламной компании */
    'adBannerId'         => $adBannerId,
    /** @var bool $hasAd В блоке имеется реклама */
    'hasAd' => $hasAd,
    /** @var bool $hideAd Отключение рекламы царь кнопкой */
    'hideAd' => $hideAd,
    /** @var string $adBannerCompany Название рекламной компании */
    'adBannerCompany'    => $adBannerCompany,
] = $args;

if ($hideAd && $hasAd) {
    return;
}
?>

<div class="zhizaRecommendedBanner" data-place>
    <img class="circle" src="/wp-content/themes/evotor/assets/images/circle_zhiza_recommended.png"
         loading="lazy" decoding="async" width="96" height="96" alt="Жиза советует"
    />

    <div class="info-block">
        <a href="<?= $linkInBanner ?>" <?= ! empty( $uid ) ? "id='$uid'" : '' ?> target="_blank" rel="nofollow noopener" class="text"
           data-link>
            <?= $linkTextInBanner ?>
        </a>

        <div class="btn--wrapper btn--wrapper--outline-black btn--wrapper--animated">
            <p class="btn btn-black h-40" title="О проекте">Подписаться</p>
        </div>

        <?php if ( $hasAd ): ?>
            <p class="new-ad ads-info gray-v">
                На правах рекламы
                <span class="square"></span>
                <?= $adBannerCompany ?: 'ООО “Эвотор”' ?>
                <span class="square"></span>
                <?= $adBannerId ?>
            </p>
        <?php endif; ?>
    </div>

    <picture class="img">
        <source srcset="/wp-content/themes/evotor/assets/images/zhiza_recommended_label.svg"
                media="(min-width: 992px)" width="201" height="61">
        <source srcset="/wp-content/themes/evotor/assets/images/zhiza_recommended_triple_label.svg"
                media="(max-width: 991px)" width="324" height="61">

        <img src="/wp-content/themes/evotor/assets/images/zhiza_recommended_label.svg"
             loading="lazy" decoding="async" width="201" height="61"
             alt="Жиза советует"
        />
    </picture>
</div>
