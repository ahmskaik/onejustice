function popDialog() {
    $(function () {
        $('#insert').click(function () {
            I_Insert();
            I_Close();
            return false;
        });
        $('#cancel').click(function () {
            I_Close();
            return false;
        });
        $('#inpURL').keyup(function () {
            selectAudio(true);
        });
    });
}

function selectAudio(mini) {
    if (mini !== undefined) {
        $('#preview').html(get_iframe(true));
    } else {
        $('#preview').html(get_iframe());
    }
}

function I_InsertHTML(sHTML) {
    if (getPostID($('#inpURL').val()) == '') {
        return false;
    }
    parent.tinymce.activeEditor.insertContent(sHTML);
}

function I_Close() {
    parent.tinymce.activeEditor.windowManager.close();
}

function get_iframe(mini) {
    var width = 500;
    var cont = '<blockquote class="twitter-tweet" data-lang="en">' +
        '<p lang="en" dir="ltr"><h3>{{tweet}}</h3>' +
        '<a href="' + getPostID($('#inpURL').val()) + '">{{date}}</a>' +
        '</blockquote> ' +
        '<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
    return cont;
}
function I_Insert() {
    I_InsertHTML(get_iframe());
}

function getPostID(url) {
    return url.replace(/^.*((v\/)|(embed\/)|(watch\?))\??v?=?([^\&\?]*).*/, '$5');
}

//Use jQuery's get method to retrieve the contents of our template file, then render the template.
$.get('template/form.html', function (template) {
    filled = Mustache.render(template);
    $('#template-container').append(filled);

    popDialog();
});
