<?php
    $collections = get_field('collections_on_main_page');
?>

<div class="collection-main-page">
    <div class="new-wrapper content-padding">
        <h2 class="section-title">
            Подборки
        </h2>

        <ul class="collection-list">
            <?php foreach ($collections as $elem): ?>
                <li class="item">
                    <a href="<?= get_permalink($elem['collection_obj']->ID) ?>">
                        <?= $elem['collection_obj']->post_title ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="btn-row">
            <div class="btn--wrapper btn--wrapper--outline-orange">
                <a href="/collections/" class="btn btn-outline-orange" title="Больше подборок">
                    Больше подборок
                </a>
            </div>
        </div>
    </div>
</div>
