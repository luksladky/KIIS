<?php
// source: C:\LUKAS\web\kiis3\app/templates/Profile/default.latte

class Templatea22a10791c6f218debfecf3f09ed617a extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('98bd737f67', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbbca1d663a1_content')) { function _lbbca1d663a1_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars())  ?>

<?php if ($user->isInRole('modify-user')) { ?>
        <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:editAllPermissions"), ENT_COMPAT) ?>
"><i
                    class="glyphicon glyphicon-certificate mr10"></i>Spravovat oprávnění</a>
<?php } ?>
    <hr>

    <div class="large-table-container">

        <table class="table table-hover">

            <thead>
            <tr>
                <th><?php if ($_l->ifs[] = (!($order=='nickname'))) { ?><a  href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:default", array('order'=>'nickname')), ENT_COMPAT) ?>
">
<?php } if ($order=='nickname') { ?>                        <span class="caret caret-reversed"></span><?php } ?>
 Přezdívka<?php if (array_pop($_l->ifs)) { ?></a><?php } ?>
</th>
                <th><?php if ($_l->ifs[] = (!($order=='name'))) { ?><a  href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:default", array('order'=>'name')), ENT_COMPAT) ?>
">
<?php } if ($order=='name') { ?>                        <span class="caret caret-reversed"></span><?php } ?>
 Celé jméno<?php if (array_pop($_l->ifs)) { ?></a><?php } ?>
</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Město</th>
                <th><?php if ($_l->ifs[] = (!($order=='last_activity'))) { ?><a  href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:default", array('order'=>'last_activity')), ENT_COMPAT) ?>
">
<?php } if ($order=='last_activity') { ?>                        <span class="caret caret-reversed"></span><?php } ?>
 Poslední aktivita<?php if (array_pop($_l->ifs)) { ?></a><?php } ?>
</th>
<?php if ($user->isInRole('modify-user')) { ?>                <th>Oprávnění</th>
<?php } ?>
            </tr>
            </thead>
            <tbody>


<?php $iterations = 0; foreach ($iterator = $_l->its[] = new Latte\Runtime\CachingIterator($profiles) as $profile) { $phones = explode(',',$profile->phone) ?>
                <tr>
                    <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:show", array($profile->id)), ENT_COMPAT) ?>
">
                            <img class="img-circle profile in-table"
                                 alt="Profile photo"<?php echo ' src="' . $imageStorage->get($profile->photo, '30x30','exact','noimage/profile-badge.jpg')->getLink() . '"' ?>
><?php echo Latte\Runtime\Filters::escapeHtml($profile->nickname, ENT_NOQUOTES) ?>

                        </a></td>
                    <td><?php echo Latte\Runtime\Filters::escapeHtml($profile->name, ENT_NOQUOTES) ?></td>
                    <td><?php echo Latte\Runtime\Filters::escapeHtml($profile->email, ENT_NOQUOTES) ?></td>
                    <td><?php $iterations = 0; foreach ($iterator = $_l->its[] = new Latte\Runtime\CachingIterator($phones) as $phone) { echo Latte\Runtime\Filters::escapeHtml($phone, ENT_NOQUOTES) ;if (!$iterator->last) { ?>
<br><?php } $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?></td>
                    <td><?php echo Latte\Runtime\Filters::escapeHtml($profile->city, ENT_NOQUOTES) ?></td>
                    <td><?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($profile->last_activity), ENT_NOQUOTES) ?></td>
<?php if ($user->isInRole('modify-user')) { ?>                    <td><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:editPermissions", array($profile->id)), ENT_COMPAT) ?>
">Spravovat
                            oprávnění</a></td>
<?php } ?>
                </tr>
                </tr>
<?php $iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>
            </tbody>
        </table>

    </div>
<?php
}}

//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lbef91589f74_title')) { function _lbef91589f74_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <h1 class="page-header">Členové klubu</h1>
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

<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}