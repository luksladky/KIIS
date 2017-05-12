<?php
// source: C:\LUKAS\web\kiis3\app/templates/Event/calendar.latte

class Template62afd53bb3a2759dfc7f35d1711e8784 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('b516eed8ad', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb0bcb7c9a95_content')) { function _lb0bcb7c9a95_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars())  ?>

    <a class="pull-right btn btn-link" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:exportCalendar"), ENT_COMPAT) ?>
">Přidat akce do Google Kalendáře</a>
    <div class="large-table-container">
<?php $_l->tmp = $_control->getComponent("calendar"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
    </div>
<?php
}}

//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lb3a3b24117a_title')) { function _lb3a3b24117a_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <h1 class="page-header">Kalendář akcí</h1>
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
if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}