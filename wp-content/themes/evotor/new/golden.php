<section class="level level--dark" data-title="Золотой фонд">
    <?php if ( ! isset( $_COOKIE['golden_fund_shown'] ) ): ?>
        <button class="close"></button>
    <?php endif; ?>
    <?php if ( is_home() ) : ?>
        <h1>О чем мы пишем</h1>
    <?php else : ?>
        <span class="what-about">О чем мы пишем</span>
    <?php endif; ?>
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="news-card">
                <h2>
                    <?= get_option( 'golden_title_1' ) ?>
                </h2>
                <?php if ( get_option( 'golden_selections_1' ) ): ?>
                    <?php foreach ( get_option( 'golden_selections_1' ) as $p ): ?>
                        <a href="<?= get_the_permalink( get_post( $p ) ) ?>"
                           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $post->post_title ?>', 'eventLabel': '<?= get_post( $p )->post_title ?>',});"
                        >
                            <?= get_post( $p )->post_title ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="news-card">
                <h2>
                    <?= get_option( 'golden_title_2' ) ?>
                </h2>

                <?php if ( get_option( 'golden_selections_2' ) ): ?>
                    <?php foreach ( get_option( 'golden_selections_2' ) as $p ): ?>
                        <a href="<?= get_the_permalink( get_post( $p ) ) ?>"
                           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $post->post_title ?>','eventLabel': '<?= get_post( $p )->post_title ?>',});"
                        >
                            <?= get_post( $p )->post_title ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-4">
            <div class="news-card">
                <h2>
                    <?= get_option( 'golden_title_3' ) ?>
                </h2>

                <?php if ( get_option( 'golden_selections_3' ) ): ?>
                    <?php foreach ( get_option( 'golden_selections_3' ) as $p ): ?>
                        <a href="<?= get_the_permalink( get_post( $p ) ) ?>"
                           onclick="dataLayer.push({'event':'evotorblog','eventCategory':'контент','eventAction': '<?= $post->post_title ?>','eventLabel': '<?= get_post( $p )->post_title ?>',});"
                        >
                            <?= get_post( $p )->post_title ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


