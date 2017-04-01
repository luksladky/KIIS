<?php
// source: C:\LUKAS\web\kiis3\app/templates/Event/edit.latte

class Template920052ecb9e866befe1b2bf881bb174a extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('495d370f04', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbac945679d1_content')) { function _lbac945679d1_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <h1 class="page-header">Upravit akci - <?php echo Latte\Runtime\Filters::escapeHtml($event->title, ENT_NOQUOTES) ?></h1>
<?php $_l->tmp = $_control->getComponent("addEventForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;
}}

//
// block templateScripts
//
if (!function_exists($_b->blocks['templateScripts'][] = '_lb71cc74d54c_templateScripts')) { function _lb71cc74d54c_templateScripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <script>
        $(document).ready(function () {

            var options = {
                datetime: {
                    dateFormat: 'd.m.yy',
                    timeFormat: 'H:mm',
                    options: { // options for type=datetime
                        changeYear: true,
                        timeInput: true,
                        hourGrid: 6,
                        minuteGrid: 15,
                        hour: 17
                    }
                },
                'datetime-local': {
                    dateFormat: 'd.m.yy',
                    timeFormat: 'H:mm'
                },
                date: {
                    dateFormat: 'd.m.yy'
                },
                time: {
                    timeFormat: 'H:mm'
                },
                options: { // global options
                    closeText: "Zavřít",
                    showSecond: false
                }
            };
            var dateTimeInputs = $('input[data-dateinput-type]').dateinput(options);
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
if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>



<?php call_user_func(reset($_b->blocks['templateScripts']), $_b, get_defined_vars()) ; 
}}