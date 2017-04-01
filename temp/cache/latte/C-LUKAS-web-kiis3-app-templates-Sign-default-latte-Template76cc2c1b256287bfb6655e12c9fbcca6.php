<?php
// source: C:\LUKAS\web\kiis3\app/templates/Sign/default.latte

class Template76cc2c1b256287bfb6655e12c9fbcca6 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('f8e610eb90', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lb9fe0472982_title')) { function _lb9fe0472982_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    Přihlásit se
<?php
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb7982326f6a_content')) { function _lb7982326f6a_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><h1 class="page-header">Přihlásit se</h1>
<a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Sign:up"), ENT_COMPAT) ?>
">Jsi tu poprvé?</a>
<a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Sign:passwordRecovery"), ENT_COMPAT) ?>
">Zapomněl jsi heslo?</a>
<hr>
<div class="row">
    <div class="div col-sm-6">

<?php $_l->tmp = $_control->getComponent("signInForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>

    </div>
</div>
<?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>

<?php
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb4be105b29d_scripts')) { function _lb4be105b29d_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;Latte\Macros\BlockMacrosRuntime::callBlockParent($_b, 'scripts', get_defined_vars()) ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
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
call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}