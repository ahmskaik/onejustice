function codepenDialog() {
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
           selectCodePen(true);
        });        
    });
}

function selectCodePen(mini) {
    if(mini !== undefined) {
        $('#preview').html(get_iframe(true));
    }else {
        $('#preview').html(get_iframe());
    }
}

function I_InsertHTML(sHTML) {
    if (getVideoId($('#inpURL').val()) == '') {
        return false;
    }
    parent.tinymce.activeEditor.insertContent(sHTML);
}

function I_Close() {
    parent.tinymce.activeEditor.windowManager.close();
}

function get_iframe(mini) {
    var width = 670;
    //var sEmbedUrl = '//codepen.io/team/WAW/embed/' + getVideoId($('#inpURL').val()) + '?height=565&theme-id=0&default-tab=html,result&embed-version=2';
    var sEmbedUrl =  $('#inpURL').val() ;
    if(mini !== undefined) {
        width = 600;
    }
    //codepen.io/codepen/embed/RaqmEW?height=300&theme-id=178&slug-hash=RaqmEW&default-tab=html%2Cresult&user=codepen&embed-version=2
    var sHTML = '<iframe  height="565" width="658" scrolling="no"  src="' + sEmbedUrl + '?height=565&theme-id=178&default-tab=result,result&embed-version=2"  frameborder="no" allowtransparency="true" allowfullscreen="true" ></iframe>';
    return sHTML;
}
function I_Insert() {    
    I_InsertHTML(get_iframe());
}

function getVideoId(url) {
    return url.replace(/^.*((v\/)|(embed\/)|(watch\?))\??v?=?([^\&\?]*).*/, '$5');
}

//Use jQuery's get method to retrieve the contents of our template file, then render the template.
$.get('template/form.html', function (template) {
    filled = Mustache.render(template);
    $('#template-container').append(filled); 
    codepenDialog();
});
