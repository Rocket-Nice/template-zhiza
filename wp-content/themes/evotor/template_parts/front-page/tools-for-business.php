<?php
$btg = get_field('business_tools_group');
?>

<?php if ($btg):
    $selected_post = $btg['tools_for_business'];
    $selected_post_description = $btg['tools_for_business_description'];
    //
    $ad_banner_title = $btg['ad_banner_group']['ad_banner_title'];
    $ad_banner_description = $btg['ad_banner_group']['ad_banner_description'];
    $ad_banner_image = $btg['ad_banner_group']['ad_banner_img'][0];
    $ad_banner_image_mobile = $btg['ad_banner_group']['ad_banner_img_mobile'][0];
    $ad_link = $btg['ad_banner_group']['ad_link'];
    $open_new_tab = $btg['ad_banner_group']['open_new_tab'];
    //
    $selected_post_img = get_the_post_thumbnail_url($selected_post, 'business-tools-preview');
    //
    $category = (get_the_category($selected_post))[0];

    $showAds = $btg['show_ads'];
    $adBannerId = $btg['ad_banner_id'];
?>
    <div class="tools-for-business">
        <div class="new-wrapper banners content-padding">
            <div class="post-banner--wrapper">
                <div class="post-banner card card-with-cover" data-place>
                    <div class="img-wrapper">
                        <img src="<?= $selected_post_img ?>"
                             alt="<?= $selected_post->post_title ?>"
                             title="<?= $selected_post->post_title ?>"
                             width="680" height="360" decoding="async" loading="lazy"
                        />
                    </div>
                    <div class="text-block">
                        <div class="post-meta">
                            <a href="/category/<?= $category->slug ?>/" class="category" title="<?= $category->name ?>">
                                <?= $category->name ?>
                            </a>
                            <p class="date"><?php echo get_the_date( 'j F Y', $selected_post ); ?></p>
                        </div>
                        <a href="<?= get_permalink($selected_post) ?>" class="post-title"
                           data-link title="<?= $selected_post->post_title ?>"
                        >
                            <?= $selected_post->post_title ?>
                        </a>
                        <?php if ($selected_post_description): ?>
                            <p class="description">
                                <?= $selected_post_description ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="tool-banner--wrapper">
                <div class="tool-banner">
                    <div class="card" data-place>
                        <div class="img-wrapper">
                            <img src="<?= $ad_banner_image['url'] ?>"
                                 alt="<?= $ad_banner_title ?>"
                                 title="<?= $ad_banner_title ?>"
                                 width="328" height="360" decoding="async" loading="lazy"
                                 srcset="<?= $ad_banner_image['url'] ?> 1920w,
                                     <?= $ad_banner_image_mobile['url'] ?> 576w"
                            />
                        </div>
                        <div class="text-block unique-paddings">
                            <a href="<?= $ad_link ?>" data-link
                               class="post-title" <?php if ($open_new_tab): echo 'target="_blank" rel="noopener nofollow"'; endif; ?>
                            >
                                <?= $ad_banner_title ?>
                            </a>
                            <?php if ($ad_banner_description): ?>
                                <p class="description">
                                    <?= $ad_banner_description ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($showAds): ?>
                                <p class="ads-info">
                                    На правах рекламы
                                    <span class="square"></span>
                                    ООО “Эвотор”
                                    <span class="square"></span>
                                    <?= $adBannerId ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn--wrapper btn--wrapper--outline-orange">
                <a href="/collections/podborki-servisov-dlya-evotora/" title="Ещё о сервисах"
                   class="btn btn-outline-orange">Ещё о сервисах</a>
            </div>
        </div>
    </div>
<?php endif; ?>
