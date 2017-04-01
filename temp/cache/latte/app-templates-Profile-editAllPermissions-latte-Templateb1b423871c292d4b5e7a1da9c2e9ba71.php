<?php
// source: C:\LUKAS\web\kiis3\app/templates/Profile/editAllPermissions.latte

class Templateb1b423871c292d4b5e7a1da9c2e9ba71 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('bbcfd03bf0', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb5c0eb4f91a_content')) { function _lb5c0eb4f91a_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars())  ?>
    <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:default"), ENT_COMPAT) ?>
"><i class="glyphicon glyphicon-user mr10"></i>Seznam kontaktů</a>
    <hr>

<?php if ($awaitingApproval->count() > 0) { ?>
        <h2>Noví uživatelé čekající na milost</h2>

        <table class="table table-hover table-condensed center-vertical">
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
<?php $iterations = 0; foreach ($awaitingApproval as $profile) { ?>
            <tr>
                <td><?php echo Latte\Runtime\Filters::escapeHtml($profile->name, ENT_NOQUOTES) ?>
 (<?php echo Latte\Runtime\Filters::escapeHtml($profile->nickname, ENT_NOQUOTES) ?>)</td>
                <td><?php echo Latte\Runtime\Filters::escapeHtml($profile->email, ENT_NOQUOTES) ?></td>
                <td>
                    <a class="btn btn-success" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("approveUser!", array($profile->id)), ENT_COMPAT) ?>
">Schválit</a>
                    <a class="btn btn-default" onclick="return confirmDelete();" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("deleteUser!", array($profile->id)), ENT_COMPAT) ?>
">Smazat nadobro</a>
                </td>
            </tr>

<?php $iterations++; } ?>

            </tbody>
        </table>

        <h2>Práva všech uživatelů</h2>
<?php } ?>

<?php call_user_func(reset($_b->blocks['_permissions']), $_b, $template->getParameters()) ; 
}}

//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lb155f5c09ce_title')) { function _lb155f5c09ce_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <h1 class="page-header">Správa oprávnění</h1>
<?php
}}

//
// block _permissions
//
if (!function_exists($_b->blocks['_permissions'][] = '_lb33216db3de__permissions')) { function _lb33216db3de__permissions($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('permissions', FALSE)
?>        <table class="table table-hover table-responsive text-center center-vertical">

            <thead>
            <tr>
                <th>Jméno</th>
<?php $iterations = 0; foreach ($allRoles as $role) { ?>
                    <th class="text-center"><span data-toggle="tooltip" data-placement="top"
                                                  title="<?php echo Latte\Runtime\Filters::escapeHtml($role->description, ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($role->slug, ENT_NOQUOTES) ?></span></th>
<?php $iterations++; } ?>
                <th></th>
            </tr>
            </thead>
            <tbody>

<?php $iterations = 0; foreach ($profiles as $profile) { ?>
                <tr<?php echo ' id="' . ($_l->dynSnippetId = $_control->getSnippetId("permissions-$profile->id")) . '"' ?>>
<?php ob_start() ?>                    <td><span data-toggle="tooltip" data-placement="top"
                              title="<?php echo Latte\Runtime\Filters::escapeHtml($profile->name, ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($profile->nickname, ENT_NOQUOTES) ?></span></td>
<?php $iterations = 0; foreach ($allRoles as $role) { ?>                    <td>
                        <div class="btn-group" role="group">
<?php if (in_array($role->slug,$assignedRoles[$profile->id])) { ?>
                                <span class="btn btn-primary btn-sm active disabled">
                            <i class="glyphicon glyphicon-ok"></i>
                        </span>
                                <a
                                        class="ajax btn btn-default btn-sm btn-square" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("removePermission!", array($profile->id, $role->slug, 'multiview'=>true)), ENT_COMPAT) ?>
">
                                    &nbsp;
                                </a>
<?php } else { ?>
                                <a
                                        class="ajax btn btn-default btn-sm btn-square" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("addPermission!", array($profile->id, $role->slug, 'multiview'=>true)), ENT_COMPAT) ?>
">
                                    &nbsp;
                                </a>
                                <span class="btn btn-danger btn-sm active disabled">
                            <i class="glyphicon glyphicon-remove"></i>
                        </span>
<?php } ?>
                        </div>

                    </td>
<?php $iterations++; } ?>
                    <td>
                        <a class="btn btn-default"
                                                                                        data-toggle="tooltip"
                                                                                        data-placement="top"
                                                                                        title="Zablokovat uživatele. Nedostane se sem, ale jeho příspěvky zůstanou." href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("deleteAllPermissions!", array($profile->id, 'multiview'=>true)), ENT_COMPAT) ?>
"><i
                                    class="glyphicon glyphicon-ban-circle"></i></a></td>
<?php $_l->dynSnippets[$_l->dynSnippetId] = ob_get_flush() ?>                </tr>
<?php $iterations++; } ?>


            </tbody>
        </table>
    <?php if (isset($_l->dynSnippets)) return $_l->dynSnippets; return FALSE; 
}}

//
// block templateScripts
//
if (!function_exists($_b->blocks['templateScripts'][] = '_lbe93bd9a054_templateScripts')) { function _lbe93bd9a054_templateScripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
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
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['templateScripts']), $_b, get_defined_vars()) ; 
}}