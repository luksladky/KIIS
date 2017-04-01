<?php
// source: C:\LUKAS\web\kiis3\app/templates/Homepage/default.latte

class Templatecaa48fae0f88a2319c2ed364cbbd2cb9 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('7193af5055', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbc1d31922ed_content')) { function _lbc1d31922ed_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><h1 class="page-header"><span title="Klubový internetový (nebo interní, kdo ví) informační systém">KIIS</span><sup class="small">3</sup></h1>
<?php if ($user->isInRole('modify-homepage')) { ?>

    <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Homepage:edit"), ENT_COMPAT) ?>
">Upravit hlavní stránku</a>

    <hr>

<?php } if (isset($homepage->content)) { echo $homepage->content ;} ?>

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