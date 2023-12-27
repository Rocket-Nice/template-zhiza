<?php get_header(); ?>
<!-- main - start -->
<div class="main pb-66">
    <div class="container">
        <div class="blog">
            <div class="title--blog">Жиза</div>
            <div class="blog__text">Блог Эвотора. <span class="blog__text__span"><a target="_blank" href="https://evotor.ru">Эвотор</a></span> — это онлайн-кассы для малого бизнеса. Мы помогаем предпринимателям избавиться от рутины и зарабатывать больше.</div>
            <?php
            $categories = [];
            if(count($categories) > 0): ?>
                <div class="blog__categories">
                    <?php foreach ($categories as $category):?>
                        <a <?php if($category->current == true){ echo 'class="current"'; } ?>href="<?php echo get_term_link($category->term_id); ?>"><?php echo $category->name; ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="blog__item blog__item--first" data-permalink="<?php the_permalink(); ?>">
                <?php if ( has_post_thumbnail() ): ?>
                    <div class="blog__item__left">
                        <a href="<?php the_permalink() ?>">
                            <?php the_post_thumbnail( 'blog-big' ) ?>
                        </a>
                    </div>
                <?php endif ?>
                <div class="blog__item__right">
                    <a href="<?php the_permalink() ?>" class="blog__item__title"><?php the_title() ?></a>
                    <div class="blog__item__text">
                        <?php echo getPostExcerpt(get_the_ID()); ?>
                    </div>
                    <div class="blog__item__info">
                        <div class="blog__item__date"><?php the_date( 'j F Y' ) ?></div>
                    </div>
                </div>
            </div>
            <?php get_template_part('form','subscribe'); ?>
            <div id="blog__items">
                <?php
                $count = 1;
                while(have_posts()) :
                    the_post();
                    if($count != 1):?>
                    <div class="blog__item" data-permalink="<?php the_permalink(); ?>">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="blog__item__left"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'blog-small' ) ?></a></div>
                        <?php endif; ?>
                        <div class="blog__item__right">
                            <a href="<?php the_permalink() ?>" class="blog__item__title"><?php the_title() ?></a>
                            <div class="blog__item__text">
                                <?php echo getPostExcerpt(get_the_ID()); ?>
                            </div>
                            <div class="blog__item__link"><a href="<?php the_permalink() ?>">Читать далее</a></div>
                            <div class="blog__item__info">
                                <div class="blog__item__date"><?php the_date( 'j F Y' ) ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php $count++; ?>
                <?php endwhile; ?>
            </div>
            <?php
            $perPage = (int) get_option( 'posts_per_page' );
            //$total = getTotalPostsFromCategory(0);
            $left = 0 - $perPage;
            if ($left > 0):?>
<!--                <div class="blog__count">еще --><?php //echo evotor_get_skl( (int) $left + 1, 'статья', 'статьи', 'статей' ) ?><!-- <br> до конца страницы</div>-->
                <div class="blog__more">
                    <div class="blog__more__button">Показать еще</div>
                </div>
                <input type="hidden" id="category-id" value="0">
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- main - end -->
<?php get_footer(); ?>
