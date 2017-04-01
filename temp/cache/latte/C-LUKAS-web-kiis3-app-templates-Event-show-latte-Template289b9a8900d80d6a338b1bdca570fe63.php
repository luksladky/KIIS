<?php
// source: C:\LUKAS\web\kiis3\app/templates/Event/show.latte

class Template289b9a8900d80d6a338b1bdca570fe63 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('7f338b9c33', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbc949c33d21_content')) { function _lbc949c33d21_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars())  ?>

    <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:default"), ENT_COMPAT) ?>
"><i class="glyphicon glyphicon-chevron-left mr10"></i>Seznam
        akcí</a>

    <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:calendar", array('calendar-month'=>$event->date_from->format('m'), 'calendar-year'=>$event->date_from->format('Y'),'do'=>'calendar-selection')), ENT_COMPAT) ?>
">
        Zobrazit v kalendáři
    </a>
<?php if ($userCanEdit) { ?>
        <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:edit", array($event->id)), ENT_COMPAT) ?>
">
            Upravit akci
        </a>

        <a class="btn btn-danger"
           onclick="return confirmDeleteEvent();" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("deleteEvent!", array($event->id)), ENT_COMPAT) ?>
">
            Smazat akci
        </a>
<?php } ?>
    <div class="pull-right mr10">
<?php if ($previous) { ?>        <a class="btn btn-default" title="Dřívější" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:show", array($previous->id)), ENT_COMPAT) ?>
"><i class="glyphicon glyphicon-arrow-left"></i></a>
<?php } if ($next) { ?>        <a class="btn btn-default" title="Pozdější akce" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:show", array($next->id)), ENT_COMPAT) ?>
"><i class="glyphicon glyphicon-arrow-right"></i></a>
<?php } ?>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-6">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong><?php echo Latte\Runtime\Filters::escapeHtml($template->czechdate($event->date_from, false), ENT_NOQUOTES) ?>
 – <?php echo Latte\Runtime\Filters::escapeHtml($template->czechdate($event->date_to), ENT_NOQUOTES) ?></strong>
                    <p class="pull-right">Vytvořil:
                        <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:show", array($event->user->id)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($event->user->nickname, ENT_NOQUOTES) ?></a></p>
                </div>
                <div class="panel-body">
                    <p><?php if ($event->location) { ?><strong class="mr10"><?php echo Latte\Runtime\Filters::escapeHtml($event->location, ENT_NOQUOTES) ?> </strong>
<?php } ?>
                        <span class="gray">
                            <?php echo Latte\Runtime\Filters::escapeHtml($template->date($event->date_from, 'j. n.'), ENT_NOQUOTES) ?>
 od <?php echo Latte\Runtime\Filters::escapeHtml($template->date($event->date_from, 'H:i'), ENT_NOQUOTES) ?>

                            <span class="ml5 mr5">–</span>
                            <?php echo Latte\Runtime\Filters::escapeHtml($template->date($event->date_to, 'j. n.'), ENT_NOQUOTES) ?>
 do <?php echo Latte\Runtime\Filters::escapeHtml($template->date($event->date_to, 'H:i'), ENT_NOQUOTES) ?>

                            <span class="ml10">(začíná <?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($event->date_from), ENT_NOQUOTES) ?>)</span>
                        </span>
                    </p>
                    <?php echo $event->description ?>

                </div>
            </div>

<?php $typeYes = \App\Model\SignEnum::YES ;$typeMaybe = \App\Model\SignEnum::MAYBE ;$typeNo = \App\Model\SignEnum::NO ?>

            <div class="btn-group mb10">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary sign-for-event-dropdown-toggle">
                        Rád bych jel <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu sign-for-event-dropdown" aria-labelledby="dropdownMenu">
<?php $_l->tmp = $_control->getComponent("signForEventForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
                    </div>
                </div>
                <a type="button" class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("sign!", array($event->id, $typeNo)), ENT_COMPAT) ?>
">Nevychází mi to</a>

            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Kdo pojede:</div>
                <div class="signs panel-body">

<?php $iterations = 0; foreach ($signs as $sign) { if (isset($sign['main'])) { if ($_l->ifs[] = ($sign['main'])) { ?>
                        <strong><?php } echo Latte\Runtime\Filters::escapeHtml($sign['name'], ENT_NOQUOTES) ;if (array_pop($_l->ifs)) { ?></strong>
<?php } } ?>
                        <?php if (!count($sign['persons'])) { ?><br><br><?php } ?>

                        <ul class="list-inline"">
<?php $iterations = 0; foreach ($sign['persons'] as $person) { ?>                        <li>
                            <div class="relative">
                                <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:show", array($person->user->id)), ENT_COMPAT) ?>
">
                                    <div class="profile-badge mb5 sign-type-<?php echo Latte\Runtime\Filters::escapeHtml($person->type, ENT_COMPAT) ?>">

                                        <img class="img-circle profile"
                                             alt="Profile photo"<?php echo ' src="' . $imageStorage->get($person->user->photo, '30x30','exact','noimage/profile-badge.jpg')->getLink() . '"' ?>>
                                        <span class="name"><?php echo Latte\Runtime\Filters::escapeHtml($person->user->nickname, ENT_NOQUOTES) ?></span>

<?php if ($person->date_from || $person->date_to) { ?>                                        <span class="popover-toggle icon">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                        <div class="popover bottom">
                                            <div class="arrow"></div>
                                            <h3 class="popover-title">Příjezd a odjezd</h3>
                                            <div class="popover-content">
<?php if ($person->date_from) { ?>
                                                    <p>
                                                        <strong>Příjezd:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($template->date($person->date_from, 'j. n. Y, H:m'), ENT_NOQUOTES) ?>

                                                    </p>
<?php } if ($person->date_to) { ?>
                                                    <p><strong>Odjezd:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($template->date($person->date_to, 'j. n. Y, H:m'), ENT_NOQUOTES) ?>

                                                    </p>
<?php } ?>
                                            </div>
                                        </div>
                                    </span>
<?php } if ($person->note) { ?>                                        <span class="popover-toggle icon">
                                        <i class="glyphicon glyphicon-comment"></i>
                                        <div class="popover bottom">
                                            <div class="arrow"></div>
                                            <h3 class="popover-title">Poznámka</h3>
                                            <div class="popover-content">
                                                <?php echo Latte\Runtime\Filters::escapeHtml($person->note, ENT_NOQUOTES) ?>

                                            </div>
                                        </div>
                                    </span>
<?php } ?>
                                    </div>
                                </a>
<?php if ($person->user->id == $user->id) { ?>                                <a
                                        class="profile-badge-remove" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("removeSign!", array($event->id, $user->id)), ENT_COMPAT) ?>
"><i
                                            class="glyphicon glyphicon-remove"></i></a>
<?php } ?>
                            </div>
                        </li>
<?php $iterations++; } ?>
                        </ul>

<?php $iterations++; } ?>
                </div>

            </div>
        </div>
    </div>

    <hr>

    <div class="row">

        <div class="hidden col-md-4" id="addThreadFormContainer">
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
<?php $iterations = 0; foreach ($threads as $thread) { ?>
            <div class="col-md-4">
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
<?php if ($unreadCounts[$thread->id] > 0) { ?>                                <span class="badge red pull-left"
                                      title="<?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($thread->last_post), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($unreadCounts[$thread->id], ENT_NOQUOTES) ?></span>
<?php } ?>
                                <?php echo $thread->title ?>

                            </div>
                        </div>
                    </a>

                    <div class="actions">
                        <div class="hiding">
<?php if ($user->id == $thread->user_id || $user->isInRole('manage-threads')) { ?>
                                <a class="btn btn-default" title="Upravit" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:edit", array($thread->id)), ENT_COMPAT) ?>
">
                                    <i class="glyphicon glyphicon-pencil"></i></a>
<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
<?php $iterations++; } ?>


    </div>
    <hr>
    <button id="addThreadShowButton" class="btn btn-default">Přidat téma</button>
    <hr>

<?php
}}

//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lb5040e799ad_title')) { function _lb5040e799ad_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <h1 class="page-header"><?php echo Latte\Runtime\Filters::escapeHtml($event->title, ENT_NOQUOTES) ?></h1>
<?php
}}

//
// block templateScripts
//
if (!function_exists($_b->blocks['templateScripts'][] = '_lbc5033b6cfc_templateScripts')) { function _lbc5033b6cfc_templateScripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <script type="text/javascript">
        $('#addThreadShowButton').click(function () {
            $('#addThreadFormContainer').toggleClass('hidden');
        })

        var dropdown = $('.sign-for-event-dropdown');
        $('.sign-for-event-dropdown-toggle').click(function () {
            dropdown.toggleClass('show');
        })


        $('.select-first-null').find("option").eq(0).prop('disabled', true).prop('hidden', true);


    </script>

    <script>
        function confirmDeleteEvent() {
            return confirm('Opravdu chceš akci smazat?');
        }


        $(document).ready(function () {
            $('input[data-dateinput-type]').each(function () {
                initDatePicker($(this));
            })
        });
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