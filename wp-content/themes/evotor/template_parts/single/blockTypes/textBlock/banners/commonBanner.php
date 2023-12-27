<?php
/**
 * Общий компонент баннера. Определяет, какой баннер требуется отрисовать в соответствии от пришедших данных
 * из аргументов.
 * @var $args
 */

/**
 * Типы шаблонов баннера:
 * post_zhiza : Жиза советует
 * post : Статья
 * single : Пользовательский
 * post_sbs : Подписка
 */

/**
 * Тип баннера:
 * post : Статья - #Этот тип статьи был удалён для Жиза советует в новом дизайне для правого блока.
 * self : Свой вариант
 */

[
    /** @var boolean $hideAd Скрыть всю рекламу в статье */
    'hideAd' => $hideAd,
    /** @var array $block Текстовый элемент конструктора */
    'block'  => $block,
    /** @var bool $hasAd В блоке имеется реклама */
    'hasAd' => $hasAd
] = $args;

[
    /** @var string $bannerTemplate Шаблон баннера.  */
    'page_text_bn_template' => $bannerTemplate,
    /** @var string $bannerType Тип баннера */
    'page_text_bn_type' => $bannerType,
    /** @var string $postInBanner ID выбранного поста */
    'page_text_bn_post' => $postInBanner,
    /** @var string $additionalTextInBanner Дополнительное описание к выбранной статье */
    'additional_text_to_selected_post' => $additionalTextInBanner,
    /** @var string $imgInBanner Изображение выбранное для баннера */
    'page_text_bn_type_self_img' => $imgInBanner,
    /** @var string $linkInBanner Ссылка в баннере */
    'page_text_bn_type_self_link' => $linkInBanner,
    /** @var string $linkTextInBanner Текст ссылки в баннере */
    'page_text_bn_type_self_link_text' => $linkTextInBanner,
    /** @var string $textInBanner HTML текст баннера */
    'page_text_bn_text' => $textInBanner,
    /** @var string $uniqueBannerPostId Уникальный ID баннера */
    'unique_banner_post_id' => $uniqueBannerPostId,
    /** @var int $postBannerImg ID изображения, выбранного для шаблона Статьи. */
    'post_banner__img' => $postBannerImg,

    /** @var string $adBannerId ID рекламной компании */
    'ad_banner_id' => $adBannerId,
    /** @var string $adBannerCompany Название рекламной компании */
    'ad_company' => $adBannerCompany,
    /** @var array $withEvotorBannerDataGroup Группа данных баннера Для тех, кто с Эвотором */
    'with_evotor_banner_data_group' => $withEvotorBannerDataGroup,
] = $block;
?>
<div class="banner">
    <?php
    switch ( $bannerTemplate ) {
        case 'post':
            get_template_part('template_parts/single/blockTypes/textBlock/banners/postBannerTemplate', null, [
                'hasAd' => $hasAd,
                'postIdArray' => $postInBanner,
                'uniqueBannerId' => $uniqueBannerPostId,
                'additionalText' => $additionalTextInBanner,
                'postBannerImgId' => $postBannerImg
            ]);
            break;
        case 'post_zhiza':
            get_template_part('template_parts/single/blockTypes/textBlock/banners/zhizaRecommendedBannerTemplate', null, [
                'hideAd' => $hideAd,
                'block' => $block,
                'linkInBanner'=> $linkInBanner,
                'uniqueBannerPostId' => $uniqueBannerPostId,
                'linkTextInBanner' => $linkTextInBanner,
                'hasAd' => $hasAd,
                'adBannerId' => $adBannerId,
                'adBannerCompany' => $adBannerCompany,
            ]);
            break;
        case 'single':
            get_template_part('template_parts/single/blockTypes/textBlock/banners/singleBannerTemplate', null, [
                'hideAd' => $hideAd,
                'image' => $imgInBanner,
                'text' => $textInBanner,
                'hasAd' => $hasAd,
                'block' => $block,
            ]);
            break;
        case 'post_sbs':
            get_template_part('template_parts/single/blockTypes/textBlock/banners/postSbsBannerTemplate', null, [
                'block' => $block,
            ]);
            break;
        case 'with_evotor':
            get_template_part('template_parts/single/blockTypes/textBlock/banners/withEvotorBanner', null, [
                'hideAd' => $hideAd,
                'block' => $block,
                'withEvotorBannerDataGroup' => $withEvotorBannerDataGroup,
                'hasAd' => $hasAd,
                'adBannerId' => $adBannerId,
                'adBannerCompany' => $adBannerCompany,
            ]);
            break;
    }
    ?>
</div>
