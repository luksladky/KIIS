<?php
// source: C:\LUKAS\web\kiis3\app\presenters\..\templates\calendarBlocks.latte

class Template6a87d702dc82538a8ada55f1318f868e extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('8e8fc580d5', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block cal-top
//
if (!function_exists($_b->blocks['cal-top'][] = '_lbf142626276_cal_top')) { function _lbf142626276_cal_top($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// block cal-table-top
//
if (!function_exists($_b->blocks['cal-table-top'][] = '_lb16b117838b_cal_table_top')) { function _lb16b117838b_cal_table_top($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <div class="btn-group  mr10">
        <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("previousMonth"), ENT_COMPAT) ?>" class="ajax btn btn-default cal-prev-month"><i class="glyphicon glyphicon-arrow-left"></i></a>
        <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("nextMonth"), ENT_COMPAT) ?>" class="ajax  btn btn-default cal-next-month"><i class="glyphicon glyphicon-arrow-right"></i></a>
    </div>




    <div class="btn-group">
<?php if ($_l->ifs[] = ($areSelectionsActive)) { ?>        <button 
                                           class="ajax btn btn-default dropdown-toggle" data-toggle="dropdown">
<?php } ?>
            <?php echo Latte\Runtime\Filters::escapeHtml($template->translate($getMonthName($month)), ENT_NOQUOTES) ?> <span class="caret"></span>
<?php if (array_pop($_l->ifs)) { ?>        </button>
<?php } ?>

        <ul class="dropdown-menu">
<?php for ($m = 1; $m <= 12; $m++) { ?>
                <li>
                    <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("selection", array('year' => $year, 'month' => $m)), ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('ajax', $m == date('n') ? 'current-month' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>
><?php echo Latte\Runtime\Filters::escapeHtml($template->translate($getMonthName($m)), ENT_NOQUOTES) ?></a>
                </li>
<?php } ?>
        </ul>
    </div>



    <div class="btn-group">

<?php if ($_l->ifs[] = ($areSelectionsActive)) { ?>        <button  class="ajax btn btn-default dropdown-toggle" data-toggle="dropdown">
<?php } ?>
            <?php echo Latte\Runtime\Filters::escapeHtml($year, ENT_NOQUOTES) ?> <span class="caret"></span>
<?php if (array_pop($_l->ifs)) { ?>        </button>
<?php } ?>

        <ul class="dropdown-menu years-list">
<?php for ($y = $year - 3; $y <= $year + 3; $y++) { ?>
                <li>
                    <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("selection", array('year' => $y, 'month' => $month)), ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('ajax', $y == date('Y') ? 'current-year' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>
><?php echo Latte\Runtime\Filters::escapeHtml($y, ENT_NOQUOTES) ?></a>
                </li>
<?php } ?>
        </ul>
    </div>

    <hr>
<?php
}}

//
// block cal-month-selection
//
if (!function_exists($_b->blocks['cal-month-selection'][] = '_lb0aae21b06a_cal_month_selection')) { function _lb0aae21b06a_cal_month_selection($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <tr>
        <td class="months-selection">
            <ul class="months-list">
<?php for ($m = 1; $m <= 12; $m++) { ?>
                    <li>
                        <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("selection", array('year' => $year, 'month' => $m)), ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('ajax', $m == date('n') ? 'current-month' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>
><?php echo Latte\Runtime\Filters::escapeHtml($template->translate($getMonthName($m)), ENT_NOQUOTES) ?></a>
                    </li>
<?php } ?>
            </ul>
        </td>
    </tr>
<?php
}}

//
// block cal-year-selection
//
if (!function_exists($_b->blocks['cal-year-selection'][] = '_lb89fe3fb575_cal_year_selection')) { function _lb89fe3fb575_cal_year_selection($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <tr>
        <td class="years-selection">
<?php $currentYear = date('Y') ?>
            <ul class="years-list">
<?php for ($y = $currentYear - 10; $y <= $currentYear + 10; $y++) { ?>
                    <li>
                        <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("selection", array('year' => $y, 'month' => $month)), ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('ajax', $y == date('Y') ? 'current-year' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>
><?php echo Latte\Runtime\Filters::escapeHtml($y, ENT_NOQUOTES) ?></a>
                    </li>
<?php } ?>
            </ul>
        </td>
    </tr>
<?php
}}

//
// block cal-th
//
if (!function_exists($_b->blocks['cal-th'][] = '_lbfbc7d803ab_cal_th')) { function _lbfbc7d803ab_cal_th($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <th><?php echo Latte\Runtime\Filters::escapeHtml($template->substr($template->translate($cell->getLabel()), 0, $charsToShortTo), ENT_NOQUOTES) ?></th>
<?php
}}

//
// block cal-week-day
//
if (!function_exists($_b->blocks['cal-week-day'][] = '_lb34e9593970_cal_week_day')) { function _lb34e9593970_cal_week_day($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;$day = $cell->getDay() ?>
    <td<?php if ($_l->tmp = array_filter(array('day', ($day->isCurrent() and $cell->getMonth() === $day->getMonth()) ? 'current-day' : NULL, $cell->getNumber() <= 0 ? 'prev-month-day' : NULL, $cell->getNumber() > $cell->getNumberOfDaysInMonth() ? 'next-month-day' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>>
        <?php echo Latte\Runtime\Filters::escapeHtml($day, ENT_NOQUOTES) ?>. <span class="gray"><?php echo Latte\Runtime\Filters::escapeHtml($day->getMonth(), ENT_NOQUOTES) ?>.</span>
        <div class="events">
<?php $iterations = 0; foreach ($day->events as $event) { ?>
            <a class="event <?php echo Latte\Runtime\Filters::escapeHtml($event->color, ENT_COMPAT) ?>
" href="<?php echo Latte\Runtime\Filters::escapeHtml($_presenter->link("Event:show", array($event->id)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($event->title, ENT_NOQUOTES) ?></a>
<?php $iterations++; } ?>
        </div>
    </td>
<?php
}}

//
// block cal-table-bottom
//
if (!function_exists($_b->blocks['cal-table-bottom'][] = '_lbdfc2bd0b3f_cal_table_bottom')) { function _lbdfc2bd0b3f_cal_table_bottom($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// block cal-bottom
//
if (!function_exists($_b->blocks['cal-bottom'][] = '_lbf5dc95ff05_cal_bottom')) { function _lbf5dc95ff05_cal_bottom($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
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





















<?php
}}