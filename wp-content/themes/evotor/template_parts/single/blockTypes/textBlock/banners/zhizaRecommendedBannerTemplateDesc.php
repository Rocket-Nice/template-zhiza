<?php
/**
 * @var $args
 */

[
    /** @var string $linkInBanner Ссылка в баннере */
    'linkInBanner'       => $linkInBanner,
    /** @var string $uniqueBannerPostId Уникальный ID баннера */
    'uniqueBannerPostId' => $uid,
    /** @var string $adBannerId ID рекламной компании */
    'adBannerId'         => $adBannerId,
    /** @var string $adBannerCompany Название рекламной компании */
    'adBannerCompany'    => $adBannerCompany,
    /** @var string $imgBnBlock фото выбранное вручную */
    'imgBnBlock'         => $imgBnBlock,
    /** @var bool $imgBanner показать рекламу */
    'showADS'            => $showADS,
    /** @var string $buttonLink ссылка текста */
    'buttonLink'         => $buttonLink,
    /** @var boolean $yeallowType желтый блок */
    'yeallowType'        => $yeallowType,
    /** @var boolean $orangeType оранжевый блок */
    'orangeType'         => $orangeType,
    /** @var array $postId Массив с ID выбранной статьи для баннера. Всегда массив из 1 значения. Ограничение на число статей в админке. */
    'postIdArray'        => $postIdArray,
    /** @var bool $hasAd В блоке имеется реклама */
    'hasAd'              => $hasAd,
    /** @var string $uniqueBannerId Уникальный ID баннера */
    'uniqueBannerId'     => $uid,
    /** $postBannerType тип "свой" или "статья" */
    'postBannerType'     => $postBannerType,
    /** @var bool $hideAd Отключение всей рекламы царь-кнопкой */
    'hideAd'             => $hideAd,
] = $args;
if ($hideAd && $showADS) {
    return;
}


$bannerPost = get_post( $postIdArray[0] );
[
    'post_title' => $title
] = get_object_vars( $bannerPost );

// Если выбрали руками изображение в поле
if ( $imgBnBlock ) {
    $image = wp_get_attachment_image_src( $imgBnBlock, 'main-post-preview-mobile' )[0];
} // Если выбрана статья
else if ( $postBannerType === "post" && is_array( $postIdArray ) && count( $postIdArray ) ) {
    $image = get_the_post_thumbnail_url( $postIdArray[0], 'main-post-preview-mobile' );
}
// Если не удалось получить остальные изображения (собственноручно загруженное изображение, либо фото статьи).
if (!$image) {
    $image = '/wp-content/themes/evotor/assets/images/thumb_banner.png';
}

?>

<div class="zhizaRecommendedBannerDesc <?php if ( $orangeType ) { ?>orange-class-block<?php } ?>" data-place>
    <img class="circle" src="<?= $image ?>"
         loading="lazy" decoding="async" width="96" height="96" alt="Жиза советует"
    />

    <div class="info-block">
        <a href="<?= get_permalink( $bannerPost->ID ) ?>" <?= ! empty( $uid ) ? "id='$uid'" : '' ?> target="_blank"
           rel="nofollow noopener" class="text"
           data-link>
            <?php
            if ( $postBannerType === "self" ) {
                echo $linkInBanner;

                if ( $showADS ) { ?>
                    <p class="new-ad ads-info gray-v">
                        На правах рекламы
                        <span class="square"></span>
                        <?= $adBannerCompany ?: 'ООО “Эвотор”' ?>
                        <span class="square"></span>
                        <?= $adBannerId ?>
                    </p>
                <?php }
            } elseif ( $postBannerType === "post" ) {
                echo $title;
            }
            ?>
        </a>
    </div>

    <picture class="img">
        <?php
        $srcImage = $yeallowType ? 'zhiza_recommended_triple_label.svg' : 'zhiza_readed_desc.svg ';
        $img      = $yeallowType ? 'zhiza_recommended_triple_label.svg' : 'zhiza_readed_desc.svg'
        ?>
        <source
            srcset="/wp-content/themes/evotor/assets/images/<?= $srcImage ?>"
            media="(max-width: 991px)" width="324" height="61">
        <img
            src="/wp-content/themes/evotor/assets/images/<?= $img ?>"
            loading="lazy" decoding="async" width="201" height="61"
            alt="Жиза советует"
        />
    </picture>
</div>
