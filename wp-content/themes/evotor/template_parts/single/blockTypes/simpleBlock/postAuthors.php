<?php
$author_text = ( get_post_meta( get_the_ID(), 'author_text', true ) ) ?: 'Автор';
$author      = postNewSinglePeople( get_the_ID(), 'author', $author_text );

$expert_text = ( get_post_meta( get_the_ID(), 'expert_text', true ) ) ?: 'Эксперт';
$expert      = postNewSinglePeople( get_the_ID(), 'expert', $expert_text, ( $author ) );

$editor_text = ( get_post_meta( get_the_ID(), 'editor_text', true ) ) ?: 'Редактор';
$editor      = postNewSinglePeople( get_the_ID(), 'editor', $editor_text );

$illustrator = postNewSinglePeople( get_the_ID(), 'illustrator', '', ( $author && ! $expert ) );
?>

<ul class="text-info__post-authors">
    <?= $author ?>
    <?= $editor ?>
    <?= $illustrator ?>
    <?= $expert ?>
</ul>
