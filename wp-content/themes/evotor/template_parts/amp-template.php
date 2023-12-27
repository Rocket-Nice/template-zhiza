<?php
/**
 * @var $args - аргументы частичного шаблона
 */

$main_thumb_id  = get_post_thumbnail_id();
$main_thumb_url = wp_get_attachment_image_src( $main_thumb_id, 'blog-full', true );
?>
<div data-source="zhiza">
    <?php
    /**
     * Поле Дополнительная информация
     */
    if (get_field( 'subheadline' )): ?>
        <div>
            <?php the_field( 'subheadline' ) ?>
        </div>
    <?php
    endif;
    $author_text = ( get_post_meta( get_the_ID(), 'author_text', true ) ) ?: 'Автор';
    $author = postNewSinglePeople( get_the_ID(), 'author', $author_text );
    //
    $expert_text = ( get_post_meta( get_the_ID(), 'expert_text', true ) ) ?: 'Эксперт';
    $expert = postNewSinglePeople( get_the_ID(), 'expert', $expert_text, ( $author ) );
    //
    $editor_text = ( get_post_meta( get_the_ID(), 'editor_text', true ) ) ?: 'Редактор';
    $editor = postNewSinglePeople( get_the_ID(), 'editor', $editor_text);
    //
    $illustrator = postNewSinglePeople( get_the_ID(), 'illustrator', '', ( $author && ! $expert ) );
    //
    ?>

    <br>

    <div>
        <ul>
            <?= $author ?>
            <?= $expert // Беседовала ?>
            <?= $illustrator // Фотограф ?>
            <?= $editor ?>
        </ul>
    </div>

    <?php

    if (get_field( 'flexible_content' )):
        while(have_rows( 'flexible_content' )):
            the_row();
            // Текстовая часть
            if (get_row_layout() === 'page_text_block'):
                the_sub_field( 'page_text' ); // ACF макет - Текст, без вариации на деление белый \ не белый
            endif;

            // Таблицы
            if (get_row_layout() === 'page_table_block'): // В таблице не вывожу классы определения размерами таблицы ?>
                <div class="post_white_block">
                    <?php the_sub_field( 'page_table' ); ?>
                </div>
            <?php endif;

            // Галерея
            if (get_row_layout() === 'page_galery_block'):
                $images = get_sub_field( 'page_galery_block_gal' );
                foreach( $images as $image ): ?>
                    <figure>
                        <img src="<?= $image['sizes']['large'] ?>" alt="" loading='lazy'>
                        <figcaption>
                            <?= $image['description'] ?>
                        </figcaption>
                    </figure>
                <?php endforeach;
            endif;
        endwhile;
    endif;
    ?>

</div>
