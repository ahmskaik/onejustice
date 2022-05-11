jQuery(document).ready(function () {

    initTinyEditor();
});

function initTinyEditor() {
    var _base = $("base").attr("href");
    tinymce.init({
        selector: ".tinymce",
        menubar: false,
        theme: "modern",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak code  ",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager youtube facebookembed instagram twitter"
        ],
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        filemanager_title: "Filemanager",
        filemanager_crossdomain: false,
        external_filemanager_path: _base + "cp/plugins/t-editor/plugins/responsivefilemanager/filemanager/",
        external_plugins: {"filemanager": "plugins/responsivefilemanager/plugin.min.js"},

        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect| fontsizeselect | code | print preview   ",
        toolbar2: "| responsivefilemanager | image | media | link unlink anchor | youtube | facebookembed | instagram | twitter",
        relative_urls: true,
        document_base_url: _base,
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
    tinymce.init({
        selector: ".tinymce-rtl",
        menubar: false,
        theme: "modern",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak code  ",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager youtube facebookembed instagram twitter"
        ],
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        filemanager_title: "Filemanager",
        filemanager_crossdomain: false,
        external_filemanager_path: _base + "cp/plugins/t-editor/plugins/responsivefilemanager/filemanager/",
        external_plugins: {"filemanager": "plugins/responsivefilemanager/plugin.min.js"},

        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect| fontsizeselect | code | print preview   ",
        toolbar2: "| responsivefilemanager | image | media | link unlink anchor | youtube | facebookembed | instagram | twitter",
        relative_urls: true,
        directionality: "rtl",
        document_base_url: _base,
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
    tinymce.init({
        selector: ".tinymce-basics",
        menubar: false,
        theme: "modern",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor "
        ],
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect| link unlink anchor | print preview |  fontsizeselect",
        relative_urls: true,
        document_base_url: _base,
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
    tinymce.init({
        selector: ".tinymce-basics-rtl",
        menubar: false,
        theme: "modern",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor "
        ],
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect| link unlink anchor | print preview |  fontsizeselect",
        relative_urls: true,
        document_base_url: _base,
        directionality: "rtl",
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
}
