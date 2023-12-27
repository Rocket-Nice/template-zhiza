<?php


//обработка произвольных полей плагина ACF begin
function yturbo_acf_template( $content ) {

    //обрабатываем только нужные нам поля (остальные обработает плагин RSS for Yandex Turbo)
    if (preg_match_all("/%%(.*?)%%/i", $content, $res)) {
        foreach ($res[0] as $r) {
            //обрабатываем поле %%myimage%% (заменяем его на результат работы функции ct_get_myimage)
            if ($r == '%%mycontent%%') {
                $content = str_replace($r, ct_get_myimage(), $content);
            }
        }
    }

    return $content;
}
add_filter( 'yturbo_the_template', 'yturbo_acf_template' );
//обработка произвольных полей плагина ACF end

function ct_get_myimage() {
    return load_template_part('template_parts/amp-template');
}
