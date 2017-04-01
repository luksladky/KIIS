<?php
// source: C:\LUKAS\web\kiis3\app/templates/Thread/default.latte

class Templated5861bb18a58ca98ce5b6ac4ef041b66 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('500360d38c', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb9534b87408_content')) { function _lb9534b87408_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars())  ?>

<?php if ($user->isInRole('add-thread')) { ?>
        <button id="addThreadShowButton" class="btn btn-default"><i class="glyphicon glyphicon-plus mr10"></i>Přidat
            téma
        </button>

<?php } ?>
    <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:archive"), ENT_COMPAT) ?>
">Zobrazit archiv</a>
    <hr>
<?php if ($user->isInRole('add-thread')) { ?>
        <div class="row">
            <div class="col-md-6">

                <div class="hidden" id="addThreadFormContainer">
                    <form class=form-horizontal<?php echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $_control["addThreadForm"], array (
  'class' => NULL,
), FALSE) ?>>
                        <div class="form-group">
                            <div class="col-sm-12"><input size=20<?php $_input = $_form["title"]; echo $_input->{method_exists($_input, 'getControlPart')?'getControlPart':'getControl'}()->addAttributes(array (
  'size' => NULL,
))->attributes() ?>></div>
                        </div>
                        <div class="form-group">

                            <div class="col-sm-4 control-label"><label<?php $_input = $_form["restrict_users"]; echo $_input->{method_exists($_input, 'getLabelPart')?'getLabelPart':'getLabel'}()->attributes() ?>>Skrýt pro
                                    uživatele:</label></div>
                            <div class="col-sm-8"><input<?php $_input = $_form["restrict_users"]; echo $_input->{method_exists($_input, 'getControlPart')?'getControlPart':'getControl'}()->attributes() ?>></div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12"><input class="btn btn-primary"<?php $_input = $_form["send"]; echo $_input->{method_exists($_input, 'getControlPart')?'getControlPart':'getControl'}()->addAttributes(array (
  'class' => NULL,
))->attributes() ?>></div>
                        </div>

                    <?php echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd($_form, FALSE) ?></form>

                </div>

            </div>
        </div>
<?php } ?>

<?php if ($threadsPinned->count() > 0) { $iterations = 0; foreach ($threadsPinned as $thread) { ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="thread-container">
                        <a class="thread-link" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:show", array($thread->id)), ENT_COMPAT) ?>
">
                            <div class="thread thread-compact panel panel-default">
                                <div class="panel-heading">
                                    <?php echo Latte\Runtime\Filters::escapeHtml($thread->user->nickname, ENT_NOQUOTES) ?>

                                    <?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($thread->created_at), ENT_NOQUOTES) ?>

                                </div>
                                <div class="panel-body">
<?php if ($unreadCounts[$thread->id] > 0) { ?>                                    <span
                                            class="badge red pull-left"><?php echo Latte\Runtime\Filters::escapeHtml($unreadCounts[$thread->id], ENT_NOQUOTES) ?></span>
<?php } ?>
                                    <?php echo $thread->title ?>

                                </div>
                            </div>
                        </a>
                        <div class="actions">
                        <span class="hiding">
<?php if ($user->id == $thread->user_id || $user->isInRole('manage-threads')) { ?>
                                <a class="btn btn-default" title="Upravit" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:edit", array($thread->id)), ENT_COMPAT) ?>
">
                                    <i class="glyphicon glyphicon-pencil"></i></a>

                                <a class="btn btn-default" title="Archivovat" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("archiveThread!", array($thread->id)), ENT_COMPAT) ?>
">
                                    <i class="glyphicon glyphicon-ok"></i></a>
<?php } ?>
                        </span>
<?php if ($user->isInRole('manage-threads')) { ?>
                                <a class="btn btn-default" title="Odepnout" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("togglePinned!", array($thread->id)), ENT_COMPAT) ?>
">
                                    <i class="glyphicon glyphicon-pushpin green"></i></a>

<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
<?php $iterations++; } } ?>

<?php $iterations = 0; foreach ($threadsNotSeen as $thread) { ?>
        <div class="row">
            <div class="col-md-6">
                <div class="thread-container">
                    <a class="thread-link" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:show", array($thread->id)), ENT_COMPAT) ?>
">
                        <div class="thread thread-compact panel panel-default">
                            <div class="panel-heading">
                                přidal
                                <?php echo Latte\Runtime\Filters::escapeHtml($thread->user->nickname, ENT_NOQUOTES) ?>

                                <?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($thread->created_at), ENT_NOQUOTES) ?>

                            </div>
                            <div class="panel-body">
                                <span class="badge red pull-left"
                                      title="<?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($thread->last_post), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($unreadCounts[$thread->id], ENT_NOQUOTES) ?></span>
                                <?php echo $thread->title ?>

                            </div>
                        </div>
                    </a>

                    <div class="actions">
<?php if ($user->id == $thread->user_id || $user->isInRole('manage-threads')) { ?>
                            <a class="btn btn-default" title="Upravit" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:edit", array($thread->id)), ENT_COMPAT) ?>
">
                                <i class="glyphicon glyphicon-pencil"></i></a>

                            <a class="btn btn-default" title="Archivovat" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("archiveThread!", array($thread->id)), ENT_COMPAT) ?>
">
                                <i class="glyphicon glyphicon-ok"></i></a>
<?php } if ($user->isInRole('manage-threads')) { ?>
                            <a class="btn btn-default" title="Připnout" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("togglePinned!", array($thread->id)), ENT_COMPAT) ?>
">
                                <i class="glyphicon glyphicon-pushpin"></i></a>
<?php } ?>
                    </div>
                </div>
            </div>
        </div>
<?php $iterations++; } ?>

<?php $iterations = 0; foreach ($threadsSeen as $thread) { ?>
        <div class="row">
            <div class="col-md-6">
                <div class="thread-container">
                    <a class="thread-link" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:show", array($thread->id)), ENT_COMPAT) ?>
">
                        <div class="thread thread-compact panel panel-default">
                            <div class="panel-heading">
                                <?php echo Latte\Runtime\Filters::escapeHtml($thread->user->nickname, ENT_NOQUOTES) ?>

                                <?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($thread->created_at), ENT_NOQUOTES) ?>

                            </div>
                            <div class="panel-body">
                                <?php echo $thread->title ?>

                            </div>
                        </div>
                    </a>
                    <div class="actions">
                        <span class="hiding">
<?php if ($user->id == $thread->user_id || $user->isInRole('manage-threads')) { ?>
                                <a class="btn btn-default" title="Upravit" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:edit", array($thread->id)), ENT_COMPAT) ?>
">
                                    <i class="glyphicon glyphicon-pencil"></i></a>

                                <a class="btn btn-default" title="Archivovat" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("archiveThread!", array($thread->id)), ENT_COMPAT) ?>
">
                                    <i class="glyphicon glyphicon-ok"></i></a>
<?php } ?>

<?php if ($user->isInRole('manage-threads')) { ?>
                                <a class="btn btn-default" title="Připnout" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("togglePinned!", array($thread->id)), ENT_COMPAT) ?>
">
                                    <i class="glyphicon glyphicon-pushpin"></i></a>
<?php } ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
<?php $iterations++; } ?>

    </div>

<?php
}}

//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lbfa66693b99_title')) { function _lbfa66693b99_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <h1 class="page-header">Nástěnka</h1>
<?php
}}

//
// block templateScripts
//
if (!function_exists($_b->blocks['templateScripts'][] = '_lb7f376685b4_templateScripts')) { function _lb7f376685b4_templateScripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <script type="text/javascript">
        $('#addThreadShowButton').click(function () {
            $('#addThreadFormContainer').toggleClass('hidden');
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