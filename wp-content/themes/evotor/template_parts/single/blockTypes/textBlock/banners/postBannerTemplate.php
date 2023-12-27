<?php
/**
 * Общий компонент баннера. Определяет, какой баннер требуется отрисовать в соответствии от пришедших данных
 * из аргументов.
 * @var $args
 */

[
    /** @var array $postId Массив с ID выбранной статьи для баннера. Всегда массив из 1 значения. Ограничение на число статей в админке. */
    'postIdArray' => $postIdArray,
    /** @var bool $hasAd В блоке имеется реклама */
    'hasAd' => $hasAd,
    /** @var string $uniqueBannerId Уникальный ID баннера */
    'uniqueBannerId' => $uid,
    /** @var int $postBannerImgId ID изображения, выбранного для шаблона Статьи. */
    'postBannerImgId' => $postBannerImgId,
    /** @var string $additionalText */
    'additionalText' => $additionalText,
] = $args;
if (!is_array($postIdArray)) {
    return;
}
if (!count($postIdArray)) {
    return;
}
$bannerPost = get_post($postIdArray[0]);
[
    'post_title' => $title
] = get_object_vars($bannerPost);
$image = get_the_post_thumbnail_url($postIdArray[0], 'main-post-preview-mobile');

if ($postBannerImgId) {
    $image = wp_get_attachment_image_src($postBannerImgId, 'main-post-preview-mobile')[0];
}
?>

<div class="postBanner <?= !$image ? 'no-image' : '' ?>" data-place>
    <?php if ( $image ): ?>
        <img src="<?= $image ?>"
             alt="<?= $title ?>"
             title="<?= $title ?>"
             width="240"
             loading="lazy"
             decoding="async"
             height="200"
        />
    <?php endif; ?>

    <div class="banner-text">
        <a href="<?= get_permalink($bannerPost->ID) ?>" <?= ! empty( $uid ) ? "id='$uid'" : '' ?> data-link>
            <?= $title ?>
        </a>

        <?php if ($additionalText): ?>
            <div class="additional-text">
                <?= $additionalText ?>
            </div>
        <?php endif; ?>
    </div>
</div>
