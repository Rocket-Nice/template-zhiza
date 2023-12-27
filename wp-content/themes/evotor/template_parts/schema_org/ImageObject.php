<?php
/**
 * @var $args - входящие параметры частичного шаблона
 */
$img = $args['imgObj'];
$title = $args['title'];
?>


<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ImageObject",
        "width": "<?= $img['width'] ?>px",
        "height": "<?= $img['height'] ?>px",
        "contentUrl": "<?= $img['url'] ?>",
        "datePublished": "<?= date('Y-m-d', strtotime($img['date'])) ?>",
        "description": "<?= $img['alt'] ?>",
        "name": "<?= $title ?>",
        "author": "<?= $args['postAuthor']['name'] ?>"
    }
</script>
