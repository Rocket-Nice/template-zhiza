<?php
$content = get_field( 'flexible_content' );
$a       = 0;
$hideAllAds = get_field( 'hide_all_ads' );
$GLOBALS['galleryIndex'] = 2;
$GLOBALS['titleCounter'] = 1;
?>

<div class="post-content">
    <?php foreach ( $content as $block ): ?>
        <?php
        $blockType = $block['acf_fc_layout'];

        switch ( $blockType ) {
            case 'page_text_block':
                get_template_part('template_parts/single/blockTypes/textBlock/commonTextBlock', null, [
                    'block' => $block,
                    'hideAd' => $hideAllAds,
                ]);
                break;
            case 'page_galery_block':
                get_template_part('template_parts/single/blockTypes/gallery/gallerySliders', null, [
                    'block' => $block,
                    'hideAd' => $hideAllAds,
                ]);
                break;
            case 'page_bn_block':
                get_template_part('template_parts/single/blockTypes/banners/commonBannerBlock', null, [
                    'block' => $block,
                    'hideAd' => $hideAllAds,
                ]);
                break;
            case 'page_table_block':
                get_template_part('template_parts/single/blockTypes/table/commonTableBlock', null, [
                    'block' => $block,
                    'hideAd' => $hideAllAds,
                ]);
                break;
        } ?>

    <?php endforeach; ?>
</div>
