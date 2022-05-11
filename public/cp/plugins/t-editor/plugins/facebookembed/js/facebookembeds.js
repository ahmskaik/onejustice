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
    var iframeSrc = "https://www.facebook.com/plugins/post.php?href=" + getPostID($('#inpURL').val()) + "&width=auto";
    var fHTML = '<iframe class="facebook-frame" src="' + iframeSrc + '" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>';
    return fHTML;
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
