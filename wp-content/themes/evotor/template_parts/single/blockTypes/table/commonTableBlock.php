<?php
/**
 * Общий компонент, определяющий стиль отображения текста и наличие баннера в боковой части.
 * @var $args
 */
[
    /** @var boolean $hideAd Скрыть всю рекламу в статье */
    'hideAd' => $hideAd,
    /** @var array $block Текстовый элемент конструктора */
    'block'  => $block,
] = $args;

[
    /** @var text $pageTable */
    'page_table' => $pageTable,
    /** @var boollean $tableWidth */
    'page_table_width' => $tableWidth,
] = $block;

preg_match_all( '@<h2.*?>(.*?)<\/h2>@', $pageTable, $matches );
foreach ( $matches[0] as $match ) {
    $pageTable = str_replace( $match, '<p><a name="' . $GLOBALS['titleCounter'] . '"></a></p>' . $matches[0][0], $pageTable );
    $GLOBALS['titleCounter']++;
}
preg_match_all( '@<h3.*?>(.*?)<\/h3>@', $pageTable, $matches );
foreach ( $matches[0] as $match ) {
    $pageTable = str_replace( $match, '<p><a name="' . $GLOBALS['titleCounter'] . '"></a></p>' . $matches[0][0], $pageTable );
    $GLOBALS['titleCounter']++;
}
?>

<div class="common-text box">
   <div class="table-wrapper <?php echo ($tableWidth === "small") ? 'table-small' : '' ?>">
        <div class="table">
            <div class="scroll-container">
                <?= $pageTable; ?>
            </div>
        </div>
   </div>
</div>
