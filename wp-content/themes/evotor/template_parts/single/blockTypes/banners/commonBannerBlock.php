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
    /** $selectTemplate выбранный шаблон */
    'page_bn_block_template'                       => $selectTemplate,
    /** @var string $adBannerId ID рекламной компании */
    'ad_banner_id'                                 => $adBannerId,
    /** @var string $adBannerCompany Название рекламной компании */
    'ad_company'                                   => $adBannerCompany,
    /** @var array $withEvotorBannerDataGroup Группа данных баннера Для тех, кто с Эвотором */
    'with_evotor_banner_data_group_big_banner'     => $withEvotorBannerDataGroup,
    /** @var string $linkTextInBanner Текст ссылки в баннере */
    'page_bn_block_template_link_name'             => $linkTextInBanner,
    /** @var string $uniqueBannerPostId Уникальный ID баннера */
    'unique_banner_post_id'                        => $uniqueBannerPostId,
    /** @var string $linkInBanner Ссылка в баннере */
    'page_bn_block_template_n_type_self_link_text' => $linkInBanner,
    /** @var int $imgBnBlock Фото в баннере */
    'page_bn_block_template_n_type_self_img'       => $imgBnBlock,
    /** @var boolean $showADS показать рекламу */
    'show_ads_text'                                => $showADS,
    /** @var string $buttonLink ссылка текста */
    'page_bn_block_template_n_type_self_link'      => $buttonLink,
    /** @var string $page_bn_block_template_post ID выбранного поста */
    'page_bn_block_template_post'                  => $postInBanner,
    /** @var string $additionalTextInBanner Дополнительное описание к выбранной статье */
    'additional_text_to_selected_post'             => $additionalTextInBanner,
    /** $postBannerType тип "свой" или "статья" */
    'page_bn_block_template_n_type'                => $postBannerType,
] = $block;

if ( $showADS && $hideAd && in_array( $selectTemplate, [ 'with_evotor_banner', 'orange', 'white' ], true ) ) {
    return;
}

?>

<div class="common-text box">
    <div class="short-container restyle-for-banner">
        <div class="basic">
            <?php switch ( $selectTemplate ) {

                case "orange":
                    get_template_part( 'template_parts/single/blockTypes/textBlock/banners/zhizaRecommendedBannerTemplateDesc', null, [
                        'linkInBanner'       => $linkInBanner,
                        'uniqueBannerPostId' => $uniqueBannerPostId,
                        'linkTextInBanner'   => $linkTextInBanner,
                        'adBannerId'         => $adBannerId,
                        'adBannerCompany'    => $adBannerCompany,
                        'imgBnBlock'         => $imgBnBlock,
                        'showADS'            => $showADS,
                        'buttonLink'         => $buttonLink,
                        'orangeType'         => 'orangeType',
                        'postIdArray'        => $postInBanner,
                        'uniqueBannerId'     => $uniqueBannerPostId,
                        'additionalText'     => $additionalTextInBanner,
                        'postBannerType'     => $postBannerType,
                    ] );
                    break;

                case 'white':
                    get_template_part( 'template_parts/single/blockTypes/textBlock/banners/zhizaRecommendedBannerTemplateDesc', null, [
                        'linkInBanner'       => $linkInBanner,
                        'uniqueBannerPostId' => $uniqueBannerPostId,
                        'linkTextInBanner'   => $linkTextInBanner,
                        'adBannerId'         => $adBannerId,
                        'adBannerCompany'    => $adBannerCompany,
                        'imgBnBlock'         => $imgBnBlock,
                        'showADS'            => $showADS,
                        'buttonLink'         => $buttonLink,
                        'yeallowType'        => 'yeallowType',
                        'postIdArray'        => $postInBanner,
                        'uniqueBannerId'     => $uniqueBannerPostId,
                        'additionalText'     => $additionalTextInBanner,
                        'postBannerType'     => $postBannerType,
                    ] );
                    break;

                case "with_evotor_banner":
                    get_template_part( 'template_parts/single/blockTypes/banners/withEvotorBannerFullWidth', null, [
                        'hideAllAd'                 => $hideAd,
                        'showADS'                   => $showADS,
                        'block'                     => $block,
                        'withEvotorBannerDataGroup' => $withEvotorBannerDataGroup,
                        'adBannerId'                => $adBannerId,
                        'adBannerCompany'           => $adBannerCompany,
                    ] );
                    break;
            } ?>
        </div>
    </div>
</div>
