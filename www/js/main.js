$.nette.init();

function confirmDelete() {
    return confirm('Opravdu to chceš smazat?');
}

function confirmArchive() {
    return confirm('Archivovat?');
}

function initSelectizeData(url, objArr, callback) {
    $.ajax({
        url: url,
        type: 'GET',
        error: function (e) {
            console.log('error', e);
        },
        success: function (res) {
            $.each(res, function (index, object) {
                objArr.push(object);
            });
            if (typeof callback == 'function') callback();
        }
    });
}

function initSelectize(url, input, objArr, value, label, search) {
    initfunc = function () {
        input.selectize({
            maxItems: null,
            valueField: value,
            labelField: label,
            searchField: search,
            selectionOnTab: true,
            createOnBlur: true,
            delimiter: ',',
            options: objArr,
            create: true
        });
    };
    if (objArr.length > 0) {
        initfunc();
    } else {
        initSelectizeData(url, objArr, initfunc);
    }

}

$('input[name="upload[]"]').after('<div class="uploadedFiles"></div>');

var formTemplate = $('.form-template').clone();
formTemplate.find('textarea').attr('id', null);

var eventRoles = [];
var users = [];

var rolesInput = $('.rolesInput');
var usersInput = $('.usersInput');

if (rolesInput.length > 0) {
    // initSelectize('/api/getroles',rolesInput,eventRoles,'name','name','name');
    initSelectize('/?presenter=Api&action=getRoles', rolesInput, eventRoles, 'name', 'name', 'name');
}

if (usersInput.length > 0) {
    // initSelectize('/api/getusers',usersInput,users,'id','nickname',['name','nickname']);
    initSelectize('/?presenter=Api&action=getUsers', usersInput, users, 'id', 'nickname', ['name', 'nickname']);
}

function initMenuToggle() {
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
}

initMenuToggle();


var firstFocus = true;

function initTinymce() {
    tinymce.init({
        mode: 'none',
        height: 200,
        menubar: false,
        statusbar: false,
        entity_encoding: "raw",
        // forced_root_block : "",
        // force_br_newlines : false,
        // force_p_newlines : false,
        autosave_ask_before_unload: false,
        autosave_interval: "5s",
        default_link_target: "_blank",
        plugins: [
            'autosave autolink lists link hr',
            'searchreplace wordcount visualblocks ',
            'nonbreaking save  directionality',
            'paste textcolor colorpicker '
        ],
        toolbar1: 'undo redo | restoredraft | bold italic underline strikethrough | forecolor | alignleft aligncenter alignright | bullist numlist  | link image uploadFile',
        setup: function (editor) {
            editor.on('init', function (ed) {
                ed.target.editorCommands.execCommand("fontName", false, "Arial");
            });
            editor.on('focus', function (e) {
                if (firstFocus) {
                    firstFocus = false;
                    $('.add-comment-form').show();
                }
            });

            editor.ui.registry.addButton('uploadFile', {
                tooltip: 'Upload file',
                icon: 'upload',
                onAction: function () {
                    console.log($(editor.formElement).children('input[name="upload[]"]'));
                    $(editor.formElement).find('input[name="upload[]"]').click();
                }
            });
        }
    });
    tinyMCE.execCommand("mceAddEditor", false, "mceEditor");

    setTimeout(function () {
        $('.add-comment-form').show();
    }, 2000);
}

$(document).ready(initTinymce);

function resetEditorContent(id) {
    if (tinyMCE.get(id)) {
        tinyMCE.get(id).setContent('');
    }
}

function copyMceEditor(customizeFunc) {
    tinyMCE.execCommand("mceRemoveEditor", true, 'form-editor');
    $('.editor-form').remove();
    var form = formTemplate;
    var textareaId = 'form-editor';
    form.find('textarea').attr("id", textareaId);
    form.removeClass('template').addClass('editor-form');

    customizeFunc(form);

    tinyMCE.execCommand("mceAddEditor", true, 'form-editor');
    // setTimeout(function () {
    //     resetEditorContent('form-editor');
    // }, 0);

    tinymce.execCommand('mceFocus', false, 'form-editor');

    var $upload = $('input[name="upload[]"]');
    $upload.off('change');
    $upload.on('change', uploadChangeHandle);

    return form;
}


function likeAjaxHandler() {
    var ajaxFilter = $('.toggle-like-btn');
    ajaxFilter.off('click.likeAjax');
    ajaxFilter.on('click.likeAjax', function (e) {
        e.preventDefault();
        var $this = $(this);
        var url = $this.attr("href");

        $this.addClass('loading');
        $.nette.ajax(url).success(function () {
            likeAjaxHandler();
        });
    });
}

function initPostControls() {
    $('.reply').off('click.replyBtn');
    $('.read-later-toggle').off('click.readLaterBtn');
    $('.reply').on('click.replyBtn', function () {
        var that = $(this);
        copyMceEditor(function (form) {
            var id = that.data('replyId');
            form.find('input[name="parent"]').val(id);
            that.parent().parent().after(form);
        });

    });

    $('.read-later-toggle').on('click.readLaterBtn', function () {
        var $this = $(this);
        $this.addClass('loading');
        $this.closest('.post').toggleClass('read-later');
    });

    likeAjaxHandler()
}

$(document).ready(initPostControls);
$(document).ajaxComplete(initPostControls);


var addEventThreadBtn = $('.add-event-thread');
addEventThreadBtn.on('click', function () {
    var that = $(this);
    var active = that.hasClass('active');
    addEventThreadBtn.removeClass('active');

    var id = that.data('eventId');
    var eventRowId = 'event-' + id + '-threads';
    var eventRow = $(document.getElementById(eventRowId));

    if (active) {
        eventRow.find('.form-container').addClass('hidden');
    } else {
        that.addClass('active');
        var form = copyMceEditor(function (form) {
            form.find('input[name="event_id"]').val(id);
            eventRow.find('.form-container').removeClass('hidden').append(form);
        });
        var selectizeInput = form.find('.usersInput');

        initSelectize('/api/getusers', selectizeInput, users, 'id', 'nickname', ['name', 'nickname']);
    }


});


//ACTIVATE ANCHOR LINKS
$(function () {
    var anchorLinksUnfiltered = $('a[href*="#"]:not([href="#"])');
    var anchorLinks = anchorLinksUnfiltered.filter(function () {
        return $(this).data('toggle') != 'collapse';
    });

    anchorLinks.click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 500, 'swing');
                return false;
            }
        }
    });
});

$('.reply-to').click(function () {
    var href = $(this).attr('href');
    var targetDiv = $(href);

    targetDiv.addClass('targeted');
    setTimeout(function () {
        targetDiv.removeClass('targeted');
    }, 100)
});

$('button.show-all-posts').click(function () {
    $(this).hide();
})


var dateFormat = 'd.m.yy';
var timeFormat = 'H:mm';

var options = {
    datetime: {
        dateFormat: dateFormat,
        timeFormat: timeFormat,
        options: { // options for type=datetime
            changeYear: true,
            timeInput: true,
            hourGrid: 6,
            minuteGrid: 15,
            hourText: 'Hodiny',
            minuteText: 'Minuty',
            hour: 17,
            second: 1
        }
    },
    'datetime-local': {
        dateFormat: dateFormat,
        timeFormat: timeFormat
    },

    date: {
        dateFormat: dateFormat
    },
    time: {
        timeFormat: timeFormat
    },
    options: { // global options
        closeText: "Zavřít",
        currentText: "Teď",
        monthNames: ['Leden', 'Únor', 'Březen', 'Duben', 'Květe', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'], // set month names
        monthNamesShort: ['Led', 'Úno', 'Bře', 'Dub', 'Kvě', 'Čer', 'Čnc', 'Srp', 'Zář', 'Říj', 'Lis', 'Pro'], // set short month names
        dayNames: ['Neděle', 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota'], // set days names
        dayNamesShort: ['Ned', 'Pon', 'Úte', 'Stř', 'Čtv', 'Pát', 'Sob'], // set short day names
        dayNamesMin: ['Ne', 'Po', 'Út', 'St', 'Čt', 'Pá', 'So'], // set more short days names
        showSecond: false,
        firstDay: 1,
        defaultTime: '01:00'
    }
};


function initDatePicker(input) {
    options.options.defaultDate = input.data('defaultDate');
    options.options.minDate = input.data('minDate');
    options.options.maxDate = input.data('maxDate');
    options.datetime.options.hour = input.data('defaultHour');
    options.datetime.options.minute = input.data('defaultMinute');

    input.dateinput(options);

    options.options.defaultDate = null;
    options.options.minDate = null;
    options.options.maxDate = null;
}


$('.like-count').mouseenter(function () {

    var that = $(this);
    var postId = that.data('postId');
    if (!that.data('haveNames')) {
        that.tooltip({placement: 'bottom'});
        $.ajax({
            url: '/?presenter=Api&action=getPostLikes&postId=' + postId,
            type: 'GET',
            error: function (e) {
                console.log('error', e);
            },
            success: function (res) {
                // console.log(res);
                that.attr('title', res).tooltip('fixTitle').tooltip('show');
                that.data('haveNames', true);
            }
        });
    }
});


function handleVisibilityChange() {
    if (document.hidden) {
        clearTimeout(refreshMenuTimeout);
        // console.log('tab hidden');
    } else {
        refreshMenu();
        // console.log('tab visible');
    }
}

document.addEventListener("visibilitychange", handleVisibilityChange, false);

var refreshMenuInterval = 15 * 1000; //ms
var refreshMenuTimeout;

function refreshMenu() {
    $.nette.ajax('/?presenter=Api&action=refreshMenu').success(function () {
        if (!document.hidden)
            refreshMenuTimeout = setTimeout(refreshMenu, refreshMenuInterval);
        initMenuToggle();
    });
}

$(document).ready(function () {
    setTimeout(refreshMenu, 1000)
});


function addFileList(files, fileList) {
    if (files.length == 0)
        return;
    // Process files one by one
    fileList.empty();

    for (var i = 0; i < files.length; ++i) {
        if (files[i].type.match(/image.*/)) {
            (function(file) {
                var reader = new FileReader();
                reader.addEventListener("load", function () {
                    fileList.append('<img class="img-rounded" src="' + reader.result + '">')
                });

                reader.readAsDataURL(files[i]);
            })(files[i]);
        } else {
            fileList.append('<div class="general_file">\n' +
                '                  <span class="filename">' + files[i].name + '</span>\n' +
                '            </div>');
        }
    }

}


// Handle file input.

function uploadChangeHandle(ev) {
    addFileList(ev.currentTarget.files, $(ev.currentTarget).siblings('.uploadedFiles'));
}

$('input[name="upload[]"]').change(uploadChangeHandle);


