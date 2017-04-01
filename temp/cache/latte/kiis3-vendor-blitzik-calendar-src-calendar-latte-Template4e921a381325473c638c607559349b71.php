<?php
// source: C:\LUKAS\web\kiis3\vendor\blitzik\calendar\src/calendar.latte

class Template4e921a381325473c638c607559349b71 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('0e00ce6281', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block _calendar
//
if (!function_exists($_b->blocks['_calendar'][] = '_lbe70f078a0c__calendar')) { function _lbe70f078a0c__calendar($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('calendar', FALSE)
;if (isset($calendarBlocksTemplate)) { ?>
    <?php ob_start(function () {}); $_g->includingBlock = isset($_g->includingBlock) ? ++$_g->includingBlock : 1; $_b->templates['0e00ce6281']->renderChildTemplate($calendarBlocksTemplate, get_defined_vars()); $_g->includingBlock--; echo rtrim(ob_get_clean()) ?>

<?php } ?>

<div class="calendar-control">
<?php ob_start(function () {}) ?>
        <?php if (isset($_b->blocks["cal-top"])) { Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'cal-top', $template->getParameters()) ;} ?>


        <table class="calendar">
        <?php if (isset($_b->blocks["cal-table-top"])) { Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'cal-table-top', $template->getParameters()) ;} ?>


<?php if ($areSelectionsActive and isset($control->monthSelection)) { Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'cal-month-selection', $template->getParameters()) ;} elseif ($areSelectionsActive and isset($control->yearSelection)) { Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'cal-year-selection', $template->getParameters()) ;} else { ?>

<?php for ($row = 0; $row < $rows; $row++) { ?>
                <tr>
<?php for ($col = 0; $col < $cols; $col++) { $cell = $getCell($row, $col) ;if ($cell->isForLabel()) { Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'cal-th', array('cell' => $cell) + $template->getParameters()) ;} else { Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'cal-week-day', array('cell' => $cell) + $template->getParameters()) ;} } ?>
                </tr>
<?php } } ?>

        <?php if (isset($_b->blocks["cal-table-bottom"])) { Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'cal-table-bottom', $template->getParameters()) ;} ?>

        </table>

        <?php if (isset($_b->blocks["cal-bottom"])) { Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'cal-table-bottom', $template->getParameters()) ;} ?>

    <?php echo $template->strip(ob_get_clean()) ?>

</div>

<?php
}}

//
// end of blocks
//

// template extending

$_l->extends = empty($_g->extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $_g->extended = TRUE;

if ($_l->extends) { ob_start(function () {});}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIRuntime::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
?>


<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); } ?>
<div id="<?php echo $_control->getSnippetId('calendar') ?>"><?php call_user_func(reset($_b->blocks['_calendar']), $_b, $template->getParameters()) ?>
</div><?php
}}