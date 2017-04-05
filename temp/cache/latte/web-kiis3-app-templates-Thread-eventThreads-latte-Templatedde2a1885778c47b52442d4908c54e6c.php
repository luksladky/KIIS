<?php
// source: C:\LUKAS\web\kiis3\app/templates/Thread/eventThreads.latte

class Templatedde2a1885778c47b52442d4908c54e6c extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('89488b73ad', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb8ceaf7378d_content')) { function _lb8ceaf7378d_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars())  ?>

<?php if ($user->isInRole('add-event')) { ?>
        <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:create"), ENT_COMPAT) ?>
"><i class="glyphicon glyphicon-plus mr10"></i>Přidat akci</a>
<?php } if ($all) { ?>
        <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('all'=>false)), ENT_COMPAT) ?>
">Skrýt odmítnuté akce</a>
<?php } else { ?>
        <a class="btn btn-default" title="Včetně těch, kde jsem zamítl účast." href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('all'=>true)), ENT_COMPAT) ?>
">Zobrazit i odmítnuté</a>
<?php } if ($unreadFirst) { ?>
        <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('unreadFirst'=>false)), ENT_COMPAT) ?>
">Zobrazit chronologicky</a>
<?php } else { ?>
        <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("this", array('unreadFirst'=>true)), ENT_COMPAT) ?>
">Nepřečtené první</a>
<?php } ?>
    <hr>

<?php $iterations = 0; foreach ($futureEvents as $event) { ?>
        <div class="event-thread" id="event-<?php echo Latte\Runtime\Filters::escapeHtml($event->id, ENT_COMPAT) ?>">
            <h3 class="mb10">
                <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:show", array($event->id)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($event->title, ENT_NOQUOTES) ?></a>
                <span class="small"><?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($event->date_from), ENT_NOQUOTES) ?></span>
<?php if ($user->isInRole('add-thread')) { ?>                <button class="btn btn-default btn-sm add-event-thread"
                                                             data-event-id="<?php echo Latte\Runtime\Filters::escapeHtml($event->id, ENT_COMPAT) ?>"><i
                            class="glyphicon glyphicon-plus"></i>
                </button>
<?php } ?>
            </h3>
            <div class="row" id="event-<?php echo Latte\Runtime\Filters::escapeHtml($event->id, ENT_COMPAT) ?>-threads">
<?php $iterations = 0; foreach ($threads[$event->id] as $thread) { ?>
                    <div class="col-md-4">
                        <a class="thread-link" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:show", array($thread->id)), ENT_COMPAT) ?>
">
                            <div class="thread thread-compact panel panel-default">
                                <div class="panel-body">
<?php if ($unreadCounts[$thread->id] > 0) { ?>                                    <span
                                            class="badge red pull-left"><?php echo Latte\Runtime\Filters::escapeHtml($unreadCounts[$thread->id], ENT_NOQUOTES) ?></span>
<?php } ?>
                                    <?php echo $thread->title ?>

                                </div>
                            </div>
                        </a>
                    </div>
<?php $iterations++; } ?>
                <div class="col-md-4 form-container hidden"></div>
            </div>
        </div>
        <hr>
<?php $iterations++; } ?>





    <div class="add-event-thread-form template form-template">
        <form class=form-horizontal<?php echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $_control["addThreadForm"], array (
  'class' => NULL,
), FALSE) ?>>
            <div class="form-group">
                <div class="col-sm-12"><textarea size=20<?php $_input = $_form["title"]; echo $_input->{method_exists($_input, 'getControlPart')?'getControlPart':'getControl'}()->addAttributes(array (
  'size' => NULL,
))->attributes() ?>><?php echo $_input->getControl()->getHtml() ?></textarea></div>
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
            <?php echo $_form["event_id"]->getControl() ?>

        <?php echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd($_form, FALSE) ?></form>
    </div>

<?php
}}

//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lbcfe550d095_title')) { function _lbcfe550d095_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <h1 class="page-header">Diskuse k akcím <?php if ($all) { ?><span class="small">včetně odmítnutých</span><?php } ?>
</h1>
<?php
}}

//
// block templateScripts
//
if (!function_exists($_b->blocks['templateScripts'][] = '_lb93e8bf1174_templateScripts')) { function _lb93e8bf1174_templateScripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
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