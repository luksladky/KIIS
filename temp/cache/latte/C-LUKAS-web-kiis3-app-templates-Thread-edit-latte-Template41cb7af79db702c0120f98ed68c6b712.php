<?php
// source: C:\LUKAS\web\kiis3\app/templates/Thread/edit.latte

class Template41cb7af79db702c0120f98ed68c6b712 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('badb63c354', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb86220154bc_content')) { function _lb86220154bc_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>   <h1 class="page-header">Upravit diskusi</h1>

   <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:show", array($threadId)), ENT_COMPAT) ?>
">Zpět na diskusi</a>

   <hr>
<?php $_l->tmp = $_control->getComponent("editThreadForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>

<?php
}}

//
// block templateScripts
//
if (!function_exists($_b->blocks['templateScripts'][] = '_lb11dc1516cf_templateScripts')) { function _lb11dc1516cf_templateScripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
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

<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>


<?php call_user_func(reset($_b->blocks['templateScripts']), $_b, get_defined_vars()) ; 
}}