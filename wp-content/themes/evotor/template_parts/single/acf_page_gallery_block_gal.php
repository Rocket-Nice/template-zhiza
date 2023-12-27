<?php
/**
 * Шаблон вывода ACF галереи в статье
 * @var $args['images] - acf объект галереи изображений
 * @var $args['title] - h1 страницы
 * @var $args['postAuthor] - автор поста для SchemaOrg
 * @var $args['imageIndex] - передача по ссылке
 */

$images     = $args['images'];
$title      = $args['title'];
$postAuthor = $args['postAuthor'];
$imageIndex = &$args['imageIndex'];
//
$imgAltArray = [];
?>

<div class="post_galary <?= get_sub_field( 'page_galery_block_gal' ) ? 'w_car' : '' ?>">
    <div class="box">
        <?php foreach ( $images as $in => $image ) {
            $imgAltArray[] = autoAltAttribute($title, $image, $imageIndex);
            if (!$image['alt']) {
                $imageIndex++;
            }
            ?>
            <div class="once" style="width: <?= $image['sizes']['blog-full-th-width'] ?>px;">
                <?php if (get_sub_field('enable_pc_photo_zoom')): ?>
                    <a href="<?= $image['url'] ?>" data-fancybox="gal-img-pc" class="zoom-image">
                        <img src="<?= $image['sizes']['medium_large'] ?>"
                             alt="<?= $imgAltArray[$in] ?>"
                             title="<?= $imgAltArray[$in] ?>"
                             width="<?= $image['sizes']['medium_large-width'] ?>"
                             height="<?= $image['sizes']['medium_large-height'] ?>"
                             loading='lazy'
                             decoding="async"
                             srcset="<?= $image['sizes']['medium_large'] ?> 1920w,
                                 <?= $image['sizes']['main-post-preview-mobile'] ?> 1199w"
                        />
                    </a>
                <?php else: ?>
                    <img src="<?= $image['sizes']['medium_large'] ?>"
                         alt="<?= $imgAltArray[$in] ?>"
                         title="<?= $imgAltArray[$in] ?>"
                         width="<?= $image['sizes']['medium_large-width'] ?>"
                         height="<?= $image['sizes']['medium_large-height'] ?>"
                         loading='lazy'
                         decoding="async"
                         srcset="<?= $image['sizes']['medium_large'] ?> 1920w,
                                 <?= $image['sizes']['main-post-preview-mobile'] ?> 1199w"
                    />
                <?php endif; ?>

                <?php get_template_part('template_parts/schema_org/ImageObject', null, [
                    'imgObj' => $image,
                    'title' => $title,
                    'postAuthor' => $postAuthor
                ]); ?>

                <p class="info">
                    <?= $image['description'] ?>
                </p>
            </div>
        <?php } ?>
    </div>
</div>

<?php
// Блок слайдера для мобильной версии
if ( get_sub_field( 'page_galery_block_gal' ) ) : ?>
    <?php if ( get_sub_field( 'page_galery_block_carousel' ) ) : ?>
        <div class="post_galary_m owl-carousel">
            <?php foreach ( $images as $in => $image ) : ?>
                <div class="once">
                    <a href="<?= $image['url'] ?>"
                       data-fancybox="gal-img"
                       class="<?= (get_sub_field('enable_pc_photo_zoom')) ? 'zoom-image' : '2' ?>"
                    >
                        <img src="<?php echo $image['sizes']['main-post-preview-mobile']; ?>"
                             alt="<?= $imgAltArray[$in] ?>"
                             title="<?= $imgAltArray[$in] ?>"
                             width="<?= $image['sizes']['main-post-preview-mobile-width'] ?>"
                             decoding="async"
                             loading='lazy'
                        />
                        <?php get_template_part('template_parts/schema_org/ImageObject', null, [
                            'imgObj' => $image,
                            'title' => $title,
                            'postAuthor' => $postAuthor
                        ]); ?>
                    </a>
                    <p class="info">
                        <?php echo $image['description']; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: // page_galery_block_carousel ?>
        <div class="post_galary_m alone-img">
            <?php foreach ( $images as $in => $image ) : ?>
                <div class="once">
                    <a href="<?php echo $image['sizes']['blog-full-th']; ?>"
                       data-fancybox="gal-img"
                       class="<?= (get_sub_field('enable_pc_photo_zoom')) ? 'zoom-image' : '2' ?>"
                    >
                        <img src="<?= $image['sizes']['main-post-preview-mobile'] ?>"
                             alt="<?= $imgAltArray[$in] ?>"
                             title="<?= $imgAltArray[$in] ?>"
                             loading='lazy'
                             decoding="async"
                             width="<?= $image['sizes']['main-post-preview-mobile-width'] ?>"
                        />
                        <?php get_template_part('template_parts/schema_org/ImageObject', null, [
                            'imgObj' => $image,
                            'title' => $title,
                            'postAuthor' => $postAuthor,
                        ]); ?>
                    </a>
                    <p class="info">
                        <?php echo $image['description']; ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; // page_galery_block_carousel?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.post_galary_m.owl-carousel').owlCarousel({
                items: 1,
                nav: false,
                dots: false,
                loop: false,
                margin: 20,
                autoWidth: true,
            })
        });
    </script>
<?php endif; // page_galery_block_gal ?>
