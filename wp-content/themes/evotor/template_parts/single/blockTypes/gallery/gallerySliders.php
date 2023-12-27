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
    /** @var array $galleryList Галерея */
    'page_galery_block_gal'      => $galleryList,
    /** @var boolean $hideCarousel переключить на карусель */
    'page_galery_block_carousel' => $hideCarousel,
    /** @var boolean $enableZoom */
    'enable_pc_photo_zoom'       => $enableZoom,
] = $block;

$title       = $post->post_title;
$postAuthor  = postSchemaOrgAuthorSingle( get_the_ID(), 'author' );
$imgAltArray = [];
?>

<div class="common-text box">
    <div class="gallery <?php if ( $hideCarousel ) { ?>__carousel<?php } ?>">
        <div class="<?php if ( $hideCarousel ) { ?>swiper<?php } ?>">
            <div class="<?php echo ( $hideCarousel ) ? 'swiper-wrapper' : 'gallery-wrapper'; ?>">
                <?php foreach ( $galleryList as $in => $image ):
                    $imgAltArray[] = autoAltAttribute( $title, $image, $GLOBALS['galleryIndex'] );
                    if ( ! $image['alt'] ) {
                        ++ $GLOBALS['galleryIndex'];
                    }
                    ?>
                    <div class="<?= $hideCarousel ? 'swiper-slide' : '' ?> once"
                         style="width: <?= $image['sizes']['medium_large-width'] ?>px">
                        <?php if ( $enableZoom ): ?>
                            <a href="<?= $image['url'] ?>" data-fancybox="gal-img-pc">
                                <img src="<?php echo $image['url'] ?>"
                                     alt="<?= $imgAltArray[ $in ] ?>"
                                     title="<?= $imgAltArray[ $in ] ?>"
                                    <?php if ( ! $hideCarousel ) : ?>
                                        width="<?= $image['sizes']['medium_large-width'] ?>"
                                        height="<?= $image['sizes']['medium_large-height'] ?>"
                                    <?php endif; ?>
                                     loading='lazy'
                                     decoding="async"
                                    <?php if ( ! $hideCarousel ) : ?>
                                        srcset="
                                        <?= $image['sizes']['medium_large'] . ' 1920w' ?>,
                                        <?= $image['sizes']['main-post-preview-mobile'] . ' 1199w' ?>"
                                    <?php endif; ?>
                                />
                                <img src="/wp-content/themes/evotor/assets/images/zoom.svg" alt="" loading="lazy"
                                     decoding="async">
                            </a>
                        <?php else: ?>
                            <img
                                src="<?= $image['url'] ?>"
                                alt="<?= $imgAltArray[ $in ] ?>"
                                title="<?= $imgAltArray[ $in ] ?>"
                                <?php if ( ! $hideCarousel ) { ?>
                                    width="<?= $image['sizes']['medium_large-width'] ?>"
                                    height="<?= $image['sizes']['medium_large-height'] ?>"<?php }
                                ?>
                                loading='lazy'
                                decoding="async"
                                <?php if ( ! $hideCarousel ) : ?>
                                    srcset="
                                    <?= $image['sizes']['medium_large'] . ' 1920w' ?>,
                                    <?= $image['sizes']['main-post-preview-mobile'] . ' 1199w' ?>"
                                <?php endif; ?>
                            />
                        <?php endif; ?>

                        <?php get_template_part( 'template_parts/schema_org/ImageObject', null, [
                            'imgObj'     => $image,
                            'title'      => $title,
                            'postAuthor' => $postAuthor
                        ] ); ?>

                        <div class="info-wrapper">
                            <span class="info">
                                <?= $image['description'] ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <div class="swiper-button-prev">
            <div class="arrow-wrapper">
                <img src="/wp-content/themes/evotor/assets/images/white_arrow.svg" alt="" loading="lazy"
                     decoding="async"/>
            </div>
        </div>
        <div class="swiper-button-next">
            <div class="arrow-wrapper __right">
                <img src="/wp-content/themes/evotor/assets/images/white_arrow.svg" alt=""
                     loading="lazy" decoding="async"/></div>
        </div>
    </div>
</div>
