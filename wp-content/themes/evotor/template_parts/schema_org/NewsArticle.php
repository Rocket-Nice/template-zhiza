<?php

/**
 *
 */
if ( is_single() ):
    $main_thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'blog-full', true );
    $thumbnail = $main_thumb_url[0];
    $existedAuthors = postSchemaOrgAuthors( get_the_ID() ); ?>

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "headline": "<?php the_title(); ?>",
            "image": [
                "<?= $thumbnail ?>"
            ],
            "datePublished": "<?= get_the_date('c') ?>",
            "dateModified": "<?= get_the_modified_date('c') ?>",
            "author": <?= json_encode($existedAuthors, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?>
        }
    </script>
<?php endif; ?>
