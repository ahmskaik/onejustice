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
    parent.tinymce.activeEditor.insertContent(sHTML+"<p></p><br>");
}

function I_Close() {
    parent.tinymce.activeEditor.windowManager.close();
}

function get_iframe(mini) {
    var width = 500;
     var cont = '<blockquote class="instagram-media" data-instgrm-captioned data-instgrm-version="7"' +
        ' style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);"><div style="padding:8px;"> <div style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:37.5% 0; text-align:center; width:100%;"> <div style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAMUExURczMzPf399fX1+bm5mzY9AMAAADiSURBVDjLvZXbEsMgCES5/P8/t9FuRVCRmU73JWlzosgSIIZURCjo/ad+EQJJB4Hv8BFt+IDpQoCx1wjOSBFhh2XssxEIYn3ulI/6MNReE07UIWJEv8UEOWDS88LY97kqyTliJKKtuYBbruAyVh5wOHiXmpi5we58Ek028czwyuQdLKPG1Bkb4NnM+VeAnfHqn1k4+GPT6uGQcvu2h2OVuIf/gWUFyy8OWEpdyZSa3aVCqpVoVvzZZ2VTnn2wU8qzVjDDetO90GSy9mVLqtgYSy231MxrY6I2gGqjrTY0L8fxCxfCBbhWrsYYAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;"></div></div> ' +
        '<p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="'+ getPostID($('#inpURL').val())+'"' +
        ' style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_blank">{{ post title}}</a></p> <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">{{ caption}} on <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="2016-09-01T21:42:22+00:00">{{ date}}</time></p></div>' +
        '</blockquote> <script async defer src="//platform.instagram.com/en_US/embeds.js"></script><p></p><br>';

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
