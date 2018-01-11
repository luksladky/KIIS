<?php
// source: C:\LUKAS\web\kiis3\app/templates/Thread/show.latte

class Templateafadce99d191a382f782e88d258f9783 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('dd7c98d108', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block title
//
if (!function_exists($_b->blocks['title'][] = '_lba107925052_title')) { function _lba107925052_title($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <?php echo Latte\Runtime\Filters::escapeHtml(strip_tags($thread->title), ENT_NOQUOTES) ?>

<?php
}}

//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbaaf77034ca_content')) { function _lbaaf77034ca_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <?php if (!$thread->event_id) { ?><a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:default"), ENT_COMPAT) ?>
">
            <i class="glyphicon glyphicon-chevron-left mr10"></i> Nástěnka</a>
    <?php } else { ?><a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:eventThreads#event-$thread->event_id"), ENT_COMPAT) ?>
">
            <i class="glyphicon glyphicon-chevron-left mr10"></i> Diskuse k akcím</a>
        <a class="btn btn-default" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Event:show", array($thread->event_id)), ENT_COMPAT) ?>
">Přejít na akci</a>
<?php } ?>
    <a href="#addPostForm" class="btn btn-default" title="Přidat komentář">
        <i class="glyphicon glyphicon-comment"></i></a>

<?php if ($userCanEdit) { ?>    <a class="btn btn-danger"
                                                              onclick="return confirmDelete();" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("deleteThread!", array($thread->id)), ENT_COMPAT) ?>
">
        <i class="glyphicon glyphicon-trash"></i> Smazat diskusi
    </a>
<?php } if ($userCanEdit) { ?>    <a class="btn btn-primary" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:edit", array($thread->id  )), ENT_COMPAT) ?>
">
        Upravit téma a viditelnost
    </a>
<?php } ?>

    <div class="pull-right mr10">

<?php $activityIcon = array('seen' => 'eye-open', 'created' => 'bullhorn', 'commented' => 'comment') ?>

        <i class="glyphicon glyphicon-flash large popover-toggle popover-icon">
            <div class="popover left">
                <div class="arrow"></div>
                <h3 class="popover-title">Aktivita</h3>
                <div class="popover-content">
                    <ul class="list-unstyled">
<?php $iterations = 0; foreach ($allActivity as $activity) { ?>
                            <li>
                                <i class="glyphicon glyphicon-<?php echo Latte\Runtime\Filters::escapeHtml($activityIcon[$activity->activity_type], ENT_COMPAT) ?>"></i>
                                <?php echo Latte\Runtime\Filters::escapeHtml($activity->user->nickname, ENT_NOQUOTES) ?>
 - <?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($activity->last_activity), ENT_NOQUOTES) ?>

                            </li>
<?php $iterations++; } ?>
                    </ul>
                </div>
            </div>

        </i>


<?php if ($restrictions->count() >0) { ?>        <i
                class="glyphicon glyphicon-eye-close large popover-toggle popover-icon ml10">
            <div class="popover left">
                <div class="arrow"></div>
                <h3 class="popover-title">Skryté pro</h3>
                <div class="popover-content">
                    <ul class="list-unstyled mb0">
<?php $iterations = 0; foreach ($restrictions as $person) { ?>
                            <li>
                                <div class="profile-badge mt10">
                                    <img class="img-circle profile"
                                         alt="Profile photo"<?php echo ' src="' . $imageStorage->get($person->user->photo, '30x30','exact','noimage/profile-badge.jpg')->getLink() . '"' ?>>
                                    <span class="name"><?php echo Latte\Runtime\Filters::escapeHtml($person->user->nickname, ENT_NOQUOTES) ?></span>
                                </div>
                            </li>
<?php $iterations++; } ?>
                    </ul>
                </div>
            </div>
        </i>
<?php } ?>


    </div>
    <div class="clearfix"></div>
    <div class="row">
    <div class="col-lg-8 col-lg-push-2 col-md-8">

    <div class="thread panel panel-default">
        <div class="panel-heading">
            Přidal
            <img
                    class="img-circle"<?php echo ' src="' . $imageStorage->get($thread->user->photo, '20x20', 'exact', 'noimage/profile-badge.jpg')->getLink() . '"' ?>>
            <a class="thread-author-link" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:show", array($thread->user->id)), ENT_COMPAT) ?>
"><?php echo Latte\Runtime\Filters::escapeHtml($thread->user->nickname, ENT_NOQUOTES) ?></a>
            <div class="pull-right">
                <?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($thread->created_at), ENT_NOQUOTES) ?>

            </div>
        </div>
        <div class="panel-body">
            <?php echo $thread->title ?>

        </div>
    </div>



<?php call_user_func(reset($_b->blocks['_postWrapper']), $_b, $template->getParameters())  ?>

    <div class="row" id="addPostForm">
        <div class="col-xs-12">

            <div class="add-comment-form template form-template">
                <form class="form-hoizontal"<?php echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin($form = $_form = $_control["addPostForm"], array (
  'class' => NULL,
), FALSE) ?>>
                    <div class="form-group">
                        <?php echo $_form["content"]->getControl() ?>

                    </div>
                    <div class="form-group">
                        <?php echo $_form["send"]->getControl() ?>


                    </div>


                    <?php echo $_form["thread_id"]->getControl() ?>

                    <?php echo $_form["parent"]->getControl() ?>

                <?php echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd($_form, FALSE) ?></form>
            </div>

        </div>
    </div>

    </div>
    </div>


<?php
}}

//
// block _postWrapper
//
if (!function_exists($_b->blocks['_postWrapper'][] = '_lbd0844d8d29__postWrapper')) { function _lbd0844d8d29__postWrapper($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v; $_control->redrawControl('postWrapper', FALSE)
;if ($lastReadPostId != -1) { ?>
            <div class="collapse" id="collapseRead">
<?php } ?>

<?php $endingsDebt = 0 ;$lastLevel = 0 ;$iterations = 0; foreach ($iterator = $_l->its[] = new Latte\Runtime\CachingIterator($posts) as $post) { if (!$iterator->first) { if ($lastLevel >= $post->depth) { for ($i = 0; $i <= $lastLevel - $post->depth; $i++) { ?>
                        </div>
<?php } } } ?>

<?php if ($post->id == $lastReadPostId) { ?>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary show-all-posts" type="button" data-toggle="collapse"
                            data-target="#collapseRead"
                            aria-expanded="false" aria-controls="collapseRead">
                        Zobrait starší příspěvky <span class="badge"><?php echo Latte\Runtime\Filters::escapeHtml($readPostsCount, ENT_NOQUOTES) ?></span>
                    </button>

                    <hr>
                </div>

<?php } ?>

<?php $isNew = $lastActivity < $post->created_at ;$isReadLater = in_array($post->id,$readLaterIds) ?>
        <div id="post-<?php echo Latte\Runtime\Filters::escapeHtml($post->id, ENT_COMPAT) ?>
"<?php if ($_l->tmp = array_filter(array('post', $isNew ? 'new' : NULL, $isReadLater ? 'read-later' : NULL))) echo ' class="', Latte\Runtime\Filters::escapeHtml(implode(" ", array_unique($_l->tmp)), ENT_COMPAT), '"' ?>>
<?php $author = $post->ref('user','user_id') ;$userCanEdit = ($user->id == $post->user_id || $user->isInRole('manage-threads')) ?>

            <a class="pull-left photo" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:show", array($author->id)), ENT_COMPAT) ?>
">
                <img
                        class="img-circle profile-photo"<?php echo ' src="' . $imageStorage->get($author->photo, '50x50', 'exact', 'noimage/profile-badge.jpg')->getLink() . '"' ?>>
            </a>

            <div class="post-inner">

                <div class="content">
                    <a class="pull-left mr10" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Profile:show", array($author->id)), ENT_COMPAT) ?>
"><strong><?php echo Latte\Runtime\Filters::escapeHtml($author->nickname, ENT_NOQUOTES) ?></strong></a>

                    <span class="date lightgray gray visible-xs">
                            <?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($post->created_at), ENT_NOQUOTES) ?>

                        <br>
                    </span>
<?php if ($post->deleted) { ?>
                        <em>Příspěvek byl smazán.</em>
<?php } else { ?>
                        <?php echo $post->content ?>

<?php } ?>
                </div>
                <div class="reply-form"></div>

<?php $postId = $post->id ?>
                <div class="tools"      >
                <span class="like-count" title="Počkej si..."
                                                     data-post-id="<?php echo Latte\Runtime\Filters::escapeHtml($post->id, ENT_COMPAT) ?>
"<?php echo ' id="' . ($_l->dynSnippetId = $_control->getSnippetId("post-likes-$postId")) . '"' ?>>
<?php ob_start() ?>                    <?php if ($post->like_count > 0) { ?><i class="glyphicon glyphicon-thumbs-up"></i> <?php echo Latte\Runtime\Filters::escapeHtml($post->like_count, ENT_NOQUOTES) ;} ?>

<?php $_l->dynSnippets[$_l->dynSnippetId] = ob_get_flush() ?>                </span>

                    <div class="controls">

                    <span<?php echo ' id="' . ($_l->dynSnippetId = $_control->getSnippetId("post-control-$postId")) . '"' ?>>
<?php ob_start() ?>                        <a class="toggle-like-btn ml10" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("toggleLike!", array($post->id)), ENT_COMPAT) ?>
">
                            <?php echo Latte\Runtime\Filters::escapeHtml(array_key_exists($post->id,$userLikes) ? 'Už zas nevím' : 'Tak určitě', ENT_NOQUOTES) ?>


                        </a>

                        <button class="ml10 btn-link reply" data-reply-id="<?php echo Latte\Runtime\Filters::escapeHtml($post->id, ENT_COMPAT) ?>">Odpovědět</button>

                        <a class="ajax read-later-toggle ml10" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("toggleReadLater!", array($post->id)), ENT_COMPAT) ?>
">
                            <?php echo Latte\Runtime\Filters::escapeHtml($isReadLater ? 'Vyřízeno' : 'Nechat na později', ENT_NOQUOTES) ?>

                        </a>
<?php $_l->dynSnippets[$_l->dynSnippetId] = ob_get_flush() ?>                    </span>
<?php if ($userCanEdit) { ?>                        <div class="btn-group">
                            <i class="glyphicon glyphicon-option-horizontal btn dropdown-toggle"
                               data-toggle="dropdown"></i>
                            <ul class="dropdown-menu">
<?php if ($user->id == $post->user_id) { ?>                                <li>
                                    <a href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("Thread:editPost", array($post->id)), ENT_COMPAT) ?>
">
                                        Upravit
                                    </a>
                                </li>
<?php } ?>
                                <li>
                                    <a
                                            onclick="return confirmDelete();" href="<?php echo Latte\Runtime\Filters::escapeHtml($_control->link("deletePost!", array($post->id)), ENT_COMPAT) ?>
">
                                        Smazat příspěvek
                                    </a>
                                </li>
                            </ul>
                        </div>
<?php } ?>

                    </div>
                    <span class="date lightgray gray hidden-xs">
                            <?php echo Latte\Runtime\Filters::escapeHtml($template->timeagoinwords($post->created_at), ENT_NOQUOTES) ?>

                    </span>
                </div>
            </div>


<?php if ($iterator->last) { for ($i = 0; $i < $post->depth; $i++) { ?>
                    </div>
<?php } } $lastLevel = $post->depth ;$iterations++; } array_pop($_l->its); $iterator = end($_l->its) ?>

    <?php if (isset($_l->dynSnippets)) return $_l->dynSnippets; return FALSE; 
}}

//
// block templateScripts
//
if (!function_exists($_b->blocks['templateScripts'][] = '_lb2d7e1c3266_templateScripts')) { function _lb2d7e1c3266_templateScripts($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?>    <script>
        setTimeout(function () {
            resetEditorContent('mceEditor');
        }, 0);
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
call_user_func(reset($_b->blocks['title']), $_b, get_defined_vars()) ; call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars())  ?>

<?php call_user_func(reset($_b->blocks['templateScripts']), $_b, get_defined_vars()) ; 
}}