<?php
/**
 * @var $args
 */

[
    'block' => $block,
    /** @var array $group Группа с полями баннерам */
    'withEvotorBannerDataGroup' => $group,
    /** @var string $adBannerId ID рекламной компании */
    'adBannerId'                => $adBannerId,
    /** @var string $adBannerCompany Название рекламной компании */
    'adBannerCompany'           => $adBannerCompany,
    /** @var bool $hasAd В блоке имеется реклама */
    'hasAd'              => $hasAd,
    /** @var bool $hideAd Отключение всей рекламы царь-кнопкой */
    'hideAd'             => $hideAd,
] = $args;
[
    /** @var array $imageAndTextGroup Группа с данными изображения и текстом баннера */
    'image_and_text' => $imageAndTextGroup,
    /** @var array $otherFields Группа полей с заголовком, данными кнопки. */
    'other_fields'   => $otherFields
] = $group;

if ($hideAd && $hasAd) {
    return;
}

$style = $otherFields['banner_style'];
$path = 'template_parts/single/blockTypes/textBlock/banners/withEvotorBannerStyles/';

switch ( $style ) {
    case 'square':
        get_template_part( $path . 'squareStyle', null, [
            'block' => $block,
            'withEvotorBannerDataGroup' => $group,
            'adBannerId' => $adBannerId,
            'adBannerCompany' => $adBannerCompany,
        ] );
        break;
    case 'triangle':
        get_template_part( $path . 'triangleStyle', null, [
            'block' => $block,
            'withEvotorBannerDataGroup' => $group,
            'adBannerId' => $adBannerId,
            'adBannerCompany' => $adBannerCompany,
        ] );
        break;
    case 'fire':
        get_template_part( $path . 'fireStyle', null, [
            'block' => $block,
            'withEvotorBannerDataGroup' => $group,
            'adBannerId' => $adBannerId,
            'adBannerCompany' => $adBannerCompany,
        ] );
        break;
}
