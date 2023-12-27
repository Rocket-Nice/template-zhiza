<?php
/**
 * @var $args
 */

[
    /** @var array $group Группа с полями баннерам */
    'withEvotorBannerDataGroup' => $group,
    /** @var string $adBannerId ID рекламной компании */
    'adBannerId' => $adBannerId,
    /** @var string $adBannerCompany Название рекламной компании */
    'adBannerCompany' => $adBannerCompany,
] = $args;
[
    /** @var array $imageAndTextGroup Группа с данными изображения и текстом баннера */
    'image_and_text' => $imageAndTextGroup,
    /** @var array $otherFields Группа полей с заголовком, данными кнопки. */
    'other_fields'   => $otherFields
] = $group;

$image = $imageAndTextGroup['banner_image'] ? wp_get_attachment_image_src( $imageAndTextGroup['banner_image'], 'main-post-preview-mobile' ) : null;
?>

<div class="withEvotorBanner square-style <?= !$image ? ('__without-photo') : '' ?>">
    <?php if ( $image ): ?>
        <div class="img-container">
            <img src="<?= $image[0] ?>"
                 alt="<?= $otherFields['banner_title'] ?: '' ?>"
                 title="<?= $otherFields['banner_title'] ?: '' ?>"
                 width="<?= $image[1] ?>"
                 height="<?= $image[2] ?>"
            />
        </div>
    <?php endif; ?>

    <div class="content-wrapper">
        <?php if ( $otherFields['banner_title'] ): ?>
            <p class="banner-title">
                <?= $otherFields['banner_title'] ?>
            </p>
        <?php endif; ?>

        <?php if ( $imageAndTextGroup['banner_text'] ): ?>
            <div class="banner-text">
                <?= $imageAndTextGroup['banner_text'] ?>
            </div>
        <?php endif; ?>

        <?php if ($otherFields['button_link']): ?>
            <div class="btn--wrapper btn--wrapper--orange">
                <a href="<?= $otherFields['button_link'] ?>" class="btn btn-orange"
                   rel="nofollow noopener" target="_blank">
                    <?= $otherFields['button_text'] ?>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($adBannerId): ?>
            <p class="new-ad ads-info gray-v">
                На правах рекламы
                <span class="square"></span>
                <?= $adBannerCompany ?: 'ООО “Эвотор”' ?>
                <span class="square"></span>
                <?= $adBannerId ?>
            </p>
        <?php endif; ?>
    </div>
</div>
