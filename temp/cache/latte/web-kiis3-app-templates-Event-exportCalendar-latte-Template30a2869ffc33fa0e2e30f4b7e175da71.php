<?php
// source: C:\LUKAS\web\kiis3\app/templates/Event/exportCalendar.latte

class Template30a2869ffc33fa0e2e30f4b7e175da71 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('46eacd597d', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb06c8f463eb_content')) { function _lb06c8f463eb_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <h1 class="page-header">Kalendář akcí</h1>
    <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:default"), ENT_COMPAT) ?>
"><i class="glyphicon glyphicon-chevron-left mr10"></i>Zpět na
        seznam akcí</a>
    <hr>

    <p>Zde jsou odkazy na kalendáře generované KIISem:</p>

    <div class="large-table-container">

        <table class="table">
            <tbody>
            <tr>
                <td><strong>Kde jsem přihlášený:</strong></td>
                <td><code><?php echo Latte\Runtime\Filters::escapeHtml($baseUrl, ENT_NOQUOTES) ;echo Latte\Runtime\Filters::escapeHtml($calendarLink, ENT_NOQUOTES) ?></code></td>
            </tr>
            <tr>
                <td><strong>Všechny akce:</strong></td>
                <td><code><?php echo Latte\Runtime\Filters::escapeHtml($baseUrl, ENT_NOQUOTES) ;echo Latte\Runtime\Filters::escapeHtml($calendarAllLink, ENT_NOQUOTES) ?></code></td>
            </tr>
            <tr>
                <td><strong>Všechny bez odmítnutých:</strong></td>
                <td><code><?php echo Latte\Runtime\Filters::escapeHtml($baseUrl, ENT_NOQUOTES) ;echo Latte\Runtime\Filters::escapeHtml($calendarAllNotRejectedLink, ENT_NOQUOTES) ?></code></td>
            </tr>
            </tbody>
        </table>
    </div>

    <br>
    <p>Adresy vede na soubor .ical, kde jsou všechny akce, <a
                href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($calendarLink), ENT_COMPAT) ?>">na které jsem přihlášený</a> (případně na <a
                href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($baseUrl), ENT_COMPAT) ;echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($calendarAllLink), ENT_COMPAT) ?>">úplně všechny</a> či jen ty, které jsem
        <a href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($calendarAllNotRejectedLink), ENT_COMPAT) ?>">vysloveně neodmítl</a>). Můžu si soubor stáhnout kamkoli importovat, nebo to
        můžu nechat importovat pravidelně
        například
        Google Kalendářem nebo Outlook Kalendářem ve Windows. Synchronizovat se budou každých pár hodin, takže když se
        na akci přihlásím, další den už ji budu mít v kalendáři na mobilu.</p>

    <p>Návod na přidání do: <a href="https://support.google.com/calendar/answer/37100?co=GENIE.Platform%3DDesktop&hl=cs">Kalendáře
    Google</a>,
    <a href="https://support.office.com/en-us/article/Import-or-subscribe-to-a-calendar-in-Outlook-com-or-Outlook-on-the-web-cff1429c-5af6-41ec-a5b4-74f2c278e98c?ui=en-US&rs=en-US&ad=US#bkmk_newodcimport">Outlook
        Calendar</a></p>
    
    <p>Pro Google Calendar možná bude potřeba <a href="https://calendar.google.com/calendar/syncselect">povolit synchronizaci do externích aplikací</a>.</p>

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