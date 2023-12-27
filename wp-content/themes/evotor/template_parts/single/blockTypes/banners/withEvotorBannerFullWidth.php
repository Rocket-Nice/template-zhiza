<?php
/**
 * @var $args
 */

[
    'block'                     => $block,
    /** @var array $group Группа с полями баннерам */
    'withEvotorBannerDataGroup' => $group,
    /** @var string $adBannerId ID рекламной компании */
    'adBannerId'                => $adBannerId,
    /** @var string $adBannerCompany Название рекламной компании */
    'adBannerCompany'           => $adBannerCompany,
    /** @var bool $showAds Блок имеет рекламную врезку */
    'showADS'                   => $showAds,
    'hideAllAd'                 => $hideAllAd,
] = $args;
[
    /** @var array $imageAndTextGroup Группа с данными изображения и текстом баннера */
    'image_and_text' => $imageAndTextGroup,
    /** @var array $otherFields Группа полей с заголовком, данными кнопки. */
    'other_fields'   => $otherFields,
] = $group;

$style = $otherFields['banner_style'];
$path  = 'template_parts/single/blockTypes/banners/evatorStyles/';

switch ( $style ) {
    case 'square':
        get_template_part( $path . 'squareFull', null, [
            'block'                     => $block,
            'withEvotorBannerDataGroup' => $group,
            'adBannerId'                => $adBannerId,
            'adBannerCompany'           => $adBannerCompany,
        ] );
        break;
    case 'fire':
        get_template_part( $path . 'fireFull', null, [
            'block'                     => $block,
            'withEvotorBannerDataGroup' => $group,
            'adBannerId'                => $adBannerId,
            'adBannerCompany'           => $adBannerCompany,
        ] );
        break;
}
