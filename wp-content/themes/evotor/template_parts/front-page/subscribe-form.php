<div class="front-page-subscribe-form">
    <div class="new-wrapper">
        <section id="new_sub_main" class="modal new_sub new_sub--padding" data-form="new_sub_form_article"
                 data-location="Форма подписки в статье">
            <div class="wrapper new_sub--black">
                <?php $dataLayerPlacement = 'блок подписки в статье'; ?>
                <?php get_template_part( 'template_parts/subscribe_form', null, [ 'dataLayerPlacement' => $dataLayerPlacement ] ) ?>
            </div>
        </section>
    </div>
</div>
