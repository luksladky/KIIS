<?php
// source: C:\LUKAS\web\kiis3\app/templates/Profile/edit.latte

class Template0e3fed3789ad21b44b7b1c480e1fe3a1 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('5621190f42', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb08a773231a_content')) { function _lb08a773231a_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <h1 class="page-header">Úprava údajů - <?php echo Latte\Runtime\Filters::escapeHtml($profile->nickname, ENT_NOQUOTES) ?></h1>
    <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:show", array($profile->id)), ENT_COMPAT) ?>
"><i class="glyphicon glyphicon-chevron-left mr10"></i>Zpět na profil bez uložení</a>
    <hr>


<div id="<?php echo $_control->getSnippetId('profilePhoto') ?>"><?php call_user_func(reset($_b->blocks['_profilePhoto']), $_b, $template->getParameters()) ?>
</div>
    <hr>
    <div class="row">

        <div class="col-md-6">
            <div id="editForm">
<?php $_l->tmp = $_control->getComponent("editForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>

            </div>
        </div>
    </div>


<?php
}}

//
// block _profilePhoto
//
if (!function_exists($_b->blocks['_profilePhoto'][] = '_lbf4dc6bd492__profilePhoto')) { function _lbf4dc6bd492__profilePhoto($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('profilePhoto', FALSE)
;if (isset($profile->photo)) { ?>                <a
                        onclick="return deletePhoto();" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("deleteProfilePicture!", array($profile->id)), ENT_COMPAT) ?>
"><span
                            class="btn btn-danger">smazat profilovku</span></a>
<?php } ?>

                <img class="img-rounded profile-photo mr10"
                     alt="Profile photo"<?php echo ' src="' . $imageStorage->get($profile->photo, 'x100','fill','noimage/profile-badge.jpg')->getLink() . '"' ?>>


                <div class="clearfix"></div>



<?php
}}

//
// block templateScripts
//
if (!function_exists($_b->blocks['templateScripts'][] = '_lb7554d00282_templateScripts')) { function _lb7554d00282_templateScripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <script type="text/javascript">
        function deletePhoto() {
            return confirm("Are you sure you want to delete your profile photo?");
        }
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
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; call_user_func(reset($_b->blocks['templateScripts']), $_b, get_defined_vars()) ; 
}}