<?php if ( ! amp_is_request() ):
    $pdb_bot            = get_field( 'single_page_posts' );
    $currentPostId      = $post->ID;
    $canonicalPostTitle = $post->post_title;

    if ( $pdb_bot ):
        $countOfShowPost = count( $pdb_bot ); // Количество карточек, которые были выбраны в админке.

        $sliderType = '__fourth-slide';
        foreach ( $pdb_bot as $post_ ) {
            setup_postdata( $post_ );
            $type = get_post_type( $post_ );

            if ( ( $type === 'collections' || $type === 'benefits' ) && $countOfShowPost !== 1 ) {
                $sliderType = "__three-slide";
                break;
            }
        }
        wp_reset_postdata();
        ?>
        <section id="n_podbor_page" class="n_podbor_page new-wrapper content-padding <?= $sliderType ?>">
            <div class="wrapper">
                <h2>
                    <?= checkIsSoloCollection( $pdb_bot ) // На ту же тему    ?>
                </h2>
                <div class="swiper">
                    <div class="n_podbor_carousel_page swiper-wrapper">
                        <?php
                        foreach ( $pdb_bot as $post ):
                            setup_postdata( $post ); // Устанавливает все глобальные переменные для текущего поста из цикла.
                            $type       = get_post_type( $post ); // Получаем тип записи. Может быть либо просто записью, либо подборкой, либо Пользой. Коллекция == подборка.
                            $post_count = get_field( 'select_posts' ) ? count( get_field( 'select_posts' ) ) : 0; // Для текущего поста берет подборку, и ищет в ней все стать. Список статей настраивается в самой подборке.
                            $thumb      = get_the_post_thumbnail( $post, 'blog-big' );
                            //
                            $postThumbnailUrl   = get_the_post_thumbnail_url( $post, 'main_post_small_preview' );
                            $postThumbMobileUrl = get_the_post_thumbnail_url( $post, 'main_post_small_preview_mobile_smallest' );

                            if ( $countOfShowPost === 1 ) {
                                // Если только 1 пост, и это Коллекция или Польза, выведем все статьи подборки
                                $category = get_the_category();
                                //
                                if ( $type === 'collections' || $type === 'benefits' ):
                                    foreach ( get_field( 'select_posts' ) as $collectionPostId ):
                                        $postOfCollection = get_post( $collectionPostId ); // Объект поста
                                        if ( $postOfCollection->ID !== $currentPostId ) : // Не выводить в подборке текущую статью
                                            ?>
                                            <div class="once cr_posts swiper-slide">
                                                <div class="desc_block">
                                                    <div class="cat_date_block">
                                                        <div class="category">
                                                            <?= wp_get_post_categories( $collectionPostId, [ 'fields' => 'all' ] )[0]->name ?>
                                                        </div>
                                                        <span class="square"></span>
                                                        <div class="date">
                                                            <?php
                                                            setlocale( LC_ALL, 'ru_RU.UTF-8' );
                                                            echo strftime( '%d.%m.%Y', strtotime( $postOfCollection->post_date ) );
                                                            ?>
                                                        </div>
                                                        <p class="count-views">
                                                            <img
                                                                src="/wp-content/themes/evotor/images/front-page/Eye.svg"
                                                                width="16" height="16" alt="Количество просмотров"
                                                                loading="lazy" decoding="async"
                                                            /> <?= pvc_get_post_views( $postOfCollection->ID ) ?>
                                                        </p>
                                                    </div>
                                                    <div class="vis_block">
                                                        <div class="box">
                                                            <a href="/<?= $postOfCollection->post_name ?>/"
                                                               class="title"
                                                               onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostTitle ?>','eventLabel': '<?= $postOfCollection->post_title ?>',});"
                                                            >
                                                                <?= $postOfCollection->post_title ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="img_block">
                                                    <a href="/<?= $postOfCollection->post_name ?>/"
                                                       onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostTitle ?>','eventLabel': '<?= $postOfCollection->post_title ?>',});"
                                                    >
                                                        <?php
                                                        $postThumbnailUrl   = get_the_post_thumbnail_url( $collectionPostId, 'main_post_small_preview' );
                                                        $postThumbMobileUrl = get_the_post_thumbnail_url( $collectionPostId, 'main_post_small_preview_mobile_smallest' );
                                                        ?>
                                                        <?php if ( $postThumbnailUrl ): ?>
                                                            <img src="<?= $postThumbnailUrl ?>"
                                                                 alt="<?= "Статья по теме: " . get_the_title() ?>"
                                                                 title="<?= "Статья по теме: " . get_the_title() ?>"
                                                                 width="285" height="193"
                                                                 loading="lazy"
                                                                 decoding="async"
                                                                 srcset="<?= $postThumbnailUrl ?> 1920w,
                                                                    <?= $postThumbMobileUrl ?> 1199w"
                                                            />
                                                        <?php else: ?>
                                                            <img
                                                                src="/wp-content/themes/evotor/assets/images/defaultPost.png"
                                                                alt="<?= "Статья по теме: " . get_the_title() ?>"
                                                                title="<?= "Статья по теме: " . get_the_title() ?>"
                                                                width="285" height="193"
                                                                loading="lazy"
                                                                decoding="async"
                                                            />
                                                        <?php endif; ?>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach;
                                else:
                                    // Если выбрана только одна статья, вывести её одной карточкой
                                    ?>
                                    <div class="once cr_posts swiper-slide">
                                        <div class="desc_block">
                                            <div class="cat_date_block">
                                                <div class="category">
                                                    <?= $category[0]->cat_name ?>
                                                </div>
                                                <span class="square"></span>
                                                <div class="date">
                                                    <?= get_the_date( 'd.m.Y' ) ?>
                                                </div>
                                                <p class="count-views">
                                                    <img src="/wp-content/themes/evotor/images/front-page/Eye.svg"
                                                         width="16" height="16" alt="Количество просмотров"
                                                         loading="lazy" decoding="async"
                                                    /> <?= pvc_get_post_views( $post->ID ) ?>
                                                </p>
                                            </div>
                                            <div class="vis_block">
                                                <div class="box">
                                                    <a href="<?= get_the_permalink( $post ) ?>" class="title"
                                                       onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostTitle ?>','eventLabel': '<?php the_title(); ?>',});"
                                                    >
                                                        <?php the_title(); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="img_block">
                                            <a href="<?= get_the_permalink( $post ) ?>"
                                               onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostTitle ?>','eventLabel': '<?php the_title(); ?>',});"
                                            >
                                                <?php if ( $postThumbnailUrl ): ?>
                                                    <img src="<?= $postThumbnailUrl ?>"
                                                         alt="<?= "Статья по теме: " . get_the_title() ?>"
                                                         title="<?= "Статья по теме: " . get_the_title() ?>"
                                                         width="285" height="193"
                                                         loading="lazy"
                                                         decoding="async"
                                                         srcset="<?= $postThumbnailUrl ?> 1920w,
                                                            <?= $postThumbMobileUrl ?> 1199w"
                                                    />
                                                <?php else: ?>
                                                    <img src="/wp-content/themes/evotor/assets/images/defaultPost.png"
                                                         alt="<?= "Статья по теме: " . get_the_title() ?>"
                                                         title="<?= "Статья по теме: " . get_the_title() ?>"
                                                         width="285" height="193"
                                                         loading="lazy"
                                                         decoding="async"
                                                    />
                                                <?php endif; ?>
                                            </a>
                                        </div>
                                    </div>

                                <?php endif;
                            } else if ( $type === 'collections' || $type === 'benefits' ):
                                // Вывести списком все подборки или пользу из списка, т.к. их больше чем 1
                                ?>
                                <div class="once swiper-slide">
                                    <div class="img_block">
                                        <a href="<?php the_permalink(); ?>"
                                           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostTitle ?>','eventLabel': '<?php the_title(); ?>',});"
                                        >
                                            <?php if ( $postThumbnailUrl ): ?>
                                                <img src="<?= $postThumbnailUrl ?>"
                                                     alt="<?= "Статья по теме: " . get_the_title() ?>"
                                                     title="<?= "Статья по теме: " . get_the_title() ?>"
                                                     width="285" height="193"
                                                     loading="lazy"
                                                     decoding="async"
                                                     srcset="<?= $postThumbnailUrl ?> 1920w,
                                                        <?= $postThumbMobileUrl ?> 1199w"
                                                />
                                            <?php else: ?>
                                                <img src="/wp-content/themes/evotor/assets/images/defaultPost.png"
                                                     alt="<?= "Статья по теме: " . get_the_title() ?>"
                                                     title="<?= "Статья по теме: " . get_the_title() ?>"
                                                     width="285" height="193"
                                                     loading="lazy"
                                                     decoding="async"
                                                />
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <div class="desc_block">
                                        <a href="<?php the_permalink(); ?>" class="title"
                                           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostTitle ?>','eventLabel': '<?php the_title(); ?>',});"
                                        >
                                            <?php the_title(); ?>
                                        </a>
                                        <div class="info">
                                            <?php the_content(); ?>
                                        </div>
                                        <div class="all_num_block">
                                            <a href="<?php the_permalink(); ?>"
                                               onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostTitle ?>','eventLabel': '<?php the_title(); ?>',});"
                                            >
                                                <div class="num">
                                                    <?= $post_count ?>
                                                </div>
                                                <div class="st">
                                                    <span>
                                                        <?= post_count_text( $post_count ) ?>
                                                    </span>
                                                </div>
                                                <div>
                                                    <img src="/wp-content/themes/evotor/assets/images/right-arrow.svg"
                                                         alt="">
                                                </div>
                                            </a>
                                        </div>
                                        <svg width="277" height="164" viewBox="0 0 277 164" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.05"
                                                  d="M332.724 275C376.783 275 384 251.07 384 209.669H367.668C367.668 242.334 363.49 250.311 358.172 250.311C351.715 250.311 349.436 240.435 344.878 222.583C330.065 163.709 325.887 155.732 260.178 134.461C298.54 121.547 282.588 26.5884 315.632 23.5497C304.617 29.6271 302.718 40.2624 302.718 49.3785C302.718 66.471 316.392 77.866 335.763 77.866C355.134 77.866 369.187 63.8121 369.187 39.1229C369.187 13.2942 350.196 0 327.786 0C251.062 0 284.487 126.485 241.187 126.485H227.513V23.1699H248.024V6.45717H136.736V23.1699H157.246V126.485H142.433C99.1335 126.485 132.938 0 55.8338 0C33.8042 0 14.8131 13.2942 14.8131 39.1229C14.8131 63.8121 28.8665 77.866 49.3769 77.866C69.1276 77.866 80.1424 66.0911 80.1424 48.9986C80.1424 37.2238 75.2048 26.9682 66.8487 21.6505C100.653 31.9061 83.5608 123.826 121.163 134.461C57.7329 156.492 53.9347 163.709 39.1217 222.583C34.5638 240.435 32.2849 250.311 26.2077 250.311C20.5104 250.311 16.3323 242.334 16.3323 209.669H0C0 251.83 6.8368 275 51.276 275C88.8783 275 102.932 254.489 111.668 222.963C120.783 192.196 121.923 143.198 148.131 143.198H157.246V251.83H136.736V268.543H248.024V251.83H227.513V143.198H235.869C262.077 143.198 262.837 192.196 271.953 222.963C280.688 254.489 295.122 275 332.724 275Z"
                                                  fill="#242121"/>
                                        </svg>
                                    </div>
                                </div>
                            <?php
                            // Шаблон карточки обычной статьи
                            else:
                                // Вывод обычной карточки статьи
                                $category = get_the_category(); ?>

                                <div class="once cr_posts swiper-slide">
                                    <div class="desc_block">
                                        <div class="cat_date_block">
                                            <div class="category">
                                                <?= $category[0]->cat_name ?>
                                            </div>
                                            <span class="square"></span>
                                            <div class="date">
                                                <?= get_the_date( 'd.m.Y' ) ?>
                                            </div>
                                            <p class="count-views">
                                                <img src="/wp-content/themes/evotor/images/front-page/Eye.svg"
                                                     width="16" height="16" alt="Количество просмотров"
                                                     loading="lazy" decoding="async"
                                                /> <?= pvc_get_post_views( $post->ID ) ?>
                                            </p>
                                        </div>
                                        <div class="vis_block">
                                            <div class="box">
                                                <a href="<?= get_the_permalink( $post ) ?>" class="title"
                                                   onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostTitle ?>','eventLabel': '<?php the_title(); ?>',});"
                                                >
                                                    <?php the_title(); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="img_block">
                                        <a href="<?= get_the_permalink( $post ) ?>"
                                           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $canonicalPostTitle ?>','eventLabel': '<?php the_title(); ?>',});"
                                        >
                                            <?php if ( $postThumbnailUrl ): ?>
                                                <img src="<?= $postThumbnailUrl ?>"
                                                     alt="<?= "Статья по теме: " . get_the_title() ?>"
                                                     title="<?= "Статья по теме: " . get_the_title() ?>"
                                                     width="285" height="193"
                                                     loading="lazy"
                                                     decoding="async"
                                                     srcset="<?= $postThumbnailUrl ?> 1920w,
                                                        <?= $postThumbMobileUrl ?> 1199w"
                                                />
                                            <?php else: ?>
                                                <img src="/wp-content/themes/evotor/assets/images/defaultPost.png"
                                                     alt="<?= "Статья по теме: " . get_the_title() ?>"
                                                     title="<?= "Статья по теме: " . get_the_title() ?>"
                                                     width="285" height="193"
                                                     loading="lazy"
                                                     decoding="async"
                                                />
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                </div>

                            <?php endif; ?>

                        <?php endforeach; ?>

                        <?php wp_reset_postdata(); // Возврат глобальной переменной post в правильное состояние.
                        ?>
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
        </section>
    <?php endif; ?>
<?php endif; ?>
