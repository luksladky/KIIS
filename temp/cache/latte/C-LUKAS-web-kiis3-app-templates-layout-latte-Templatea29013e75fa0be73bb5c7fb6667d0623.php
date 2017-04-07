<?php
// source: C:\LUKAS\web\kiis3\app/templates/@layout.latte

class Templatea29013e75fa0be73bb5c7fb6667d0623 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('88028d0dc6', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block head
//
if (!function_exists($_b->blocks['head'][] = '_lbbd1da1ef94_head')) { function _lbbd1da1ef94_head($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
}}

//
// block _menu
//
if (!function_exists($_b->blocks['_menu'][] = '_lb090218ef52__menu')) { function _lb090218ef52__menu($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('menu', FALSE)
?>            <li class="sidebar-brand"><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Homepage:default"), ENT_COMPAT) ?>
">
                    <img src="/images/logo.jpg" alt="DDM Trebic logo">
                </a></li>
<?php if ($user->isInRole('member')) { ?>
                <li<?php if ($_l->tmp = array_filter(array($presenter->isLinkCurrent('Event:default') ? 'active' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>
><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:default"), ENT_COMPAT) ?>
">
                        <i class="glyphicon glyphicon-tower mr10"></i>Akce
<?php if ($newEventsCount > 0) { ?>                        <span class="badge"><?php echo Latte\Runtime\Filters::escapeHtml($newEventsCount, ENT_NOQUOTES) ?></span>
<?php } ?>
                    </a></li>
                <li<?php if ($_l->tmp = array_filter(array($presenter->isLinkCurrent('Event:calendar') ? 'active' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>
><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:calendar"), ENT_COMPAT) ?>
">
                        <i class="glyphicon glyphicon-calendar mr10"></i>Kalendář</a></li>

                <li class="separator"></li>
                <li<?php if ($_l->tmp = array_filter(array($presenter->isLinkCurrent('Thread:eventThreads') ? 'active' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>
><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:eventThreads"), ENT_COMPAT) ?>
">
                        <i class="glyphicon glyphicon-comment mr10"></i>Diskuse k akcím
                        <span<?php echo ' id="' . $_control->getSnippetId('badgeEventThreads') . '"' ?>>
<?php call_user_func(reset($_b->blocks['_badgeEventThreads']), $_b, $template->getParameters()) ?>
                        </span>
                    </a></li>
                <li<?php if ($_l->tmp = array_filter(array($presenter->isLinkCurrent('Thread:default') ? 'active' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>
><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:default"), ENT_COMPAT) ?>
">
                        <i class="glyphicon glyphicon-bullhorn mr10"></i>Nástěnka
                        <span<?php echo ' id="' . $_control->getSnippetId('badgeDashboard') . '"' ?>>
<?php call_user_func(reset($_b->blocks['_badgeDashboard']), $_b, $template->getParameters()) ?>
                        </span>
                    </a></li>
                <li class="separator"></li>
                <li class="separator"></li>
                <li<?php if ($_l->tmp = array_filter(array($presenter->isLinkCurrent('Profile:default') ? 'active' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>
><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:default"), ENT_COMPAT) ?>
">
                        <i class="glyphicon glyphicon-user mr10"></i>Lidi</a></li>
<?php if ($user->isInRole('modify-user')) { ?>                <li<?php if ($_l->tmp = array_filter(array($presenter->isLinkCurrent('Profile:editAllPermissions') ? 'active' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>>
                    <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:editAllPermissions"), ENT_COMPAT) ?>
">
                        <i class="glyphicon glyphicon-certificate mr10"></i>Oprávnění
<?php if ($awaitingApprovalCount > 0) { ?>                        <span class="badge"><?php echo Latte\Runtime\Filters::escapeHtml($awaitingApprovalCount, ENT_NOQUOTES) ?></span>
<?php } ?>
                    </a>
                </li>
<?php } ?>

<?php } ?>

<?php if (!$isHttpError && $user->isLoggedIn()) { ?>
                <li<?php if ($_l->tmp = array_filter(array($presenter->isLinkCurrent('Profile:show',$user->id) ? 'active' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>>
                    <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:show", array($user->id)), ENT_COMPAT) ?>
">
                        <img class="img-circle profile"
                             alt="Profile photo"<?php echo ' src="' . $imageStorage->get($user->identity->photo, '20x20','exact','noimage/profile-badge.jpg')->getLink() . '"' ?>>
                        <span class="name"><?php echo Latte\Runtime\Filters::escapeHtml($user->identity->data['nickname'], ENT_NOQUOTES) ?></span>
                    </a>
                </li>
                <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Sign:out"), ENT_COMPAT) ?>
">Odhlásit se</a></li>
<?php } else { ?>
                <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Sign:"), ENT_COMPAT) ?>
">Přihlásit</a></li>
                <li><a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link(":Sign:up"), ENT_COMPAT) ?>
">Registrovat</a></li>

<?php } 
}}

//
// block _badgeEventThreads
//
if (!function_exists($_b->blocks['_badgeEventThreads'][] = '_lb9a7979bb7d__badgeEventThreads')) { function _lb9a7979bb7d__badgeEventThreads($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('badgeEventThreads', FALSE)
;if ($unreadEventThreadsCount > 0) { ?>                        <span class="badge"><?php echo Latte\Runtime\Filters::escapeHtml($unreadEventThreadsCount, ENT_NOQUOTES) ?></span>
<?php } if ($readLaterEventThreadsCount > 0) { ?>                        <span class="badge orange"><?php echo Latte\Runtime\Filters::escapeHtml($readLaterEventThreadsCount, ENT_NOQUOTES) ?></span>
<?php } 
}}

//
// block _badgeDashboard
//
if (!function_exists($_b->blocks['_badgeDashboard'][] = '_lbc7d0fa8261__badgeDashboard')) { function _lbc7d0fa8261__badgeDashboard($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('badgeDashboard', FALSE)
;if ($unreadThreadsCount > 0) { ?>                        <span class="badge"><?php echo Latte\Runtime\Filters::escapeHtml($unreadThreadsCount, ENT_NOQUOTES) ?></span>
<?php } if ($readLaterThreadsCount > 0) { ?>                        <span class="badge orange"><?php echo Latte\Runtime\Filters::escapeHtml($readLaterThreadsCount, ENT_NOQUOTES) ?></span>
<?php } 
}}

//
// block _flashes
//
if (!function_exists($_b->blocks['_flashes'][] = '_lba4b52281b3__flashes')) { function _lba4b52281b3__flashes($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('flashes', FALSE)
;$iterations = 0; foreach ($flashes as $flash) { ?>                            <div<?php if ($_l->tmp = array_filter(array('flash', 'alert', 'alert-'.$flash->type))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>
><?php echo Latte\Runtime\Filters::escapeHtml($flash->message, ENT_NOQUOTES) ?></div>
<?php $iterations++; } 
}}

//
// block scripts
//
if (!function_exists($_b->blocks['scripts'][] = '_lb56c7cf9afe_scripts')) { function _lb56c7cf9afe_scripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>        <script src="/js/vendor/jquery-2.1.0.min.js"></script>
        <script src="/js/vendor/netteForms.min.js"></script>
        <script src="/js/vendor/nette.ajax.js"></script>
        <script src="/js/vendor/history.nette.ajax.js"></script>
        <script src="/js/vendor/jquery-ui.min.js"></script>
        <script src="/js/vendor/jquery-ui-timepicker-addon.js"></script>
        <script src="/js/vendor/dateInput.js"></script>
        <script src="/js/vendor/selectize.min.js"></script>
        <script src="/js/vendor/bootstrap.min.js"></script>
        <script src="/js/main.js?version=3"></script>

        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<?php
}}

//
// block templateScripts
//
if (!function_exists($_b->blocks['templateScripts'][] = '_lbb62985ea9d_templateScripts')) { function _lbb62985ea9d_templateScripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
;
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
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">

    <title><?php if (isset($_b->blocks["title"])) { ob_start(function () {}); Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'title', $template->getParameters()); echo $template->striptags(ob_get_clean()) ?>
 | <?php } ?>KIIS 3</title>

    <!--  Bootstrap start  -->
    <!--  Bootstrap end  -->

    <script type="text/javascript">document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/, 'js');</script>
    <link rel="stylesheet" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/css/main.min.css?version=9">
    <link rel="shortcut icon" href="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/icon.png">
    <meta name="viewport" content="width=device-width">
    <?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['head']), $_b, get_defined_vars())  ?>

</head>
<body>

<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">

        <ul class="sidebar-nav"<?php echo ' id="' . $_control->getSnippetId('menu') . '"' ?>>
<?php call_user_func(reset($_b->blocks['_menu']), $_b, $template->getParameters()) ?>
        </ul>


    </div>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="container main-content">
<?php $newCount = $newEventsCount + $unreadThreadsCount + $unreadEventThreadsCount + $awaitingApprovalCount ?>
                        <button id="menu-toggle" type="button" class="btn btn-default visible-xs">
<?php if ($newCount > 0) { ?>
                                <span class="badge red"><?php echo Latte\Runtime\Filters::escapeHtml($newCount, ENT_NOQUOTES) ?></span>
<?php } else { ?>
                                <i class="glyphicon glyphicon-menu-hamburger"></i>
<?php } ?>
                            MENU
                        </button>


<div id="<?php echo $_control->getSnippetId('flashes') ?>"><?php call_user_func(reset($_b->blocks['_flashes']), $_b, $template->getParameters()) ?>
</div><?php Latte\Macros\BlockMacrosRuntime::callBlock($_b, 'content', $template->getParameters()) ?>


                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>


<?php call_user_func(reset($_b->blocks['scripts']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['templateScripts']), $_b, get_defined_vars())  ?>
</div>
</body>
</html>
<?php
}}