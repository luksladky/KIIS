<?php
// source: C:\LUKAS\web\kiis3\app/templates/Event/default.latte

class Template1c4caaf4ee4433ca923eceb84f866cbb extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('93ae96ed1a', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbe22d49545e_content')) { function _lbe22d49545e_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars()) ; if ($user->isInRole('add-event')) { ?>
        <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:create"), ENT_COMPAT) ?>
"><i class="glyphicon glyphicon-plus mr10"></i>Přidat akci</a>
<?php } ?>

    <a
            class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:default", array($showLinkType)), ENT_COMPAT) ?>
">Zobrazit <?php echo Latte\Runtime\Filters::escapeHtml($showLinkType ? 'všechny' : 'jen budoucí', ENT_NOQUOTES) ?></a>
    <a class="btn btn-link pull-right" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:exportCalendar"), ENT_COMPAT) ?>
">Přidat akce do Google Kalendáře</a>
    <hr>

    <div class="row">
        <div class="col-md-6">
<?php $iterations = 0; foreach ($events as $event) { $type = array_key_exists($event->id,$signedFor) ? $signedFor[$event->id] : 'none' ?>
                <div class="event-block">
                <a class="event-link" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:show", array($event->id)), ENT_COMPAT) ?>
">
                    <div class="event panel panel-default sign-type-<?php echo Latte\Runtime\Filters::escapeHtml($type, ENT_COMPAT) ?>">
                        <div class="panel-body">
                            <h3><?php echo $event->title ?></h3>
                            <p><?php echo Latte\Runtime\Filters::escapeHtml($template->czechdate($event->date_from, false), ENT_NOQUOTES) ?>
 – <?php echo Latte\Runtime\Filters::escapeHtml($template->czechdate($event->date_to), ENT_NOQUOTES) ?></p>
                        </div>
                    </div>
                </a>

<?php if ($eventSigns) { ?>                    <aside class="event-thumb">
                        <div class="panel panel-default">
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



<?php $iterations = 0; foreach ($eventSigns[$event->id] as $sign) { ?>

<?php if (isset($sign['main'])) { if ($_l->ifs[] = ($sign['main'])) { ?>                                    <strong><?php } echo Latte\Runtime\Filters::escapeHtml($sign['name'], ENT_NOQUOTES) ;if (array_pop($_l->ifs)) { ?></strong>
<?php } } ?>
                                    <?php if (!count($sign['persons'])) { ?><br><br><?php } ?>

                                    <ul class="list-inline"">
<?php $iterations = 0; foreach ($sign['persons'] as $person) { ?>                                    <li>
                                        <div class="relative">
                                            <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:show", array($person->user->id)), ENT_COMPAT) ?>
">
                                                <div class="profile-badge mb5 sign-type-<?php echo Latte\Runtime\Filters::escapeHtml($person->type, ENT_COMPAT) ?>">

                                                    <img class="img-circle profile"
                                                         alt="Profile photo"<?php echo ' src="' . $imageStorage->get($person->user->photo, '30x30','exact','noimage/profile-badge.jpg')->getLink() . '"' ?>>
                                                    <span class="name"><?php echo Latte\Runtime\Filters::escapeHtml($person->user->nickname, ENT_NOQUOTES) ?></span>

<?php if ($person->date_from || $person->date_to) { ?>                                                    <span class="popover-toggle icon">
                                        <i class="glyphicon glyphicon-calendar"></i>

                                    </span>
<?php } if ($person->note) { ?>                                                    <span class="popover-toggle icon">
                                        <i class="glyphicon glyphicon-comment"></i>

                                    </span>
<?php } ?>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
<?php $iterations++; } ?>
                                    </ul>

<?php $iterations++; } ?>
                            </div>
                        </div>

                    </aside>
<?php } ?>

                </div>




<?php $iterations++; } ?>
        </div>
    </div>



<?php
}}

//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lba5dc03aea3_title')) { function _lba5dc03aea3_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <h1 class="page-header">Seznam akcí</h1>
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