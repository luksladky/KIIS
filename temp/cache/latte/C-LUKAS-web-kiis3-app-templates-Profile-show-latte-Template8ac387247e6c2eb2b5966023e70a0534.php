<?php
// source: C:\LUKAS\web\kiis3\app/templates/Profile/show.latte

class Template8ac387247e6c2eb2b5966023e70a0534 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('6b4e56dc7c', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbf78a0b74a7_content')) { function _lbf78a0b74a7_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars())  ?>

    <img class="img-thumbnail mr10 main-profile pull-left"
         alt="Profile photo"<?php echo ' src="' . $imageStorage->get($profile->photo, '300x400','exact','noimage/profile-badge.jpg')->getLink() . '"' ?>>

<?php if ($profile->email) { ?>    <p><strong>Email: </strong><?php echo Latte\Runtime\Filters::escapeHtml($profile->email, ENT_NOQUOTES) ?></p>
<?php } if ($profile->phone) { ?>    <p><strong>Telefon: </strong><?php echo Latte\Runtime\Filters::escapeHtml($profile->phone, ENT_NOQUOTES) ?></p>
<?php } if ($profile->city) { ?>    <p><strong>Bydlím tady: </strong><?php echo Latte\Runtime\Filters::escapeHtml($profile->city, ENT_NOQUOTES) ?></p>
<?php } ?>


<?php if (count($eventSigns)> 0) { ?>
        <h3>Pojedu na akce:</h3>

        <ul class="list-unstyled">
<?php $iterations = 0; foreach ($eventSigns as $sign) { if ($sign->type != 'no') { ?>
                    <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:show", array($sign->event_id)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($sign->event->title, ENT_NOQUOTES) ?></a></li>
<?php } $iterations++; } ?>

        </ul>
<?php } ?>



<?php if ($userCanEdit) { ?>    <a class="btn btn-primary" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:edit", array($profile->id)), ENT_COMPAT) ?>
">Upravit údaje</a>
<?php } if ($userCanEdit) { ?>    <a class="btn btn-primary" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:changePassword"), ENT_COMPAT) ?>
">Změnit heslo</a>
<?php } if ($user->isInRole('modify-user')) { ?>    <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:editPermissions", array($profile->id)), ENT_COMPAT) ?>
">Spravovat
        oprávnění</a>
<?php } 
}}

//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lbd47a404c8b_title')) { function _lbd47a404c8b_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <h1 class="page-header"><?php echo Latte\Runtime\Filters::escapeHtml($profile->nickname, ENT_NOQUOTES) ?>
 (<?php echo Latte\Runtime\Filters::escapeHtml($profile->name, ENT_NOQUOTES) ?>)</h1>
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