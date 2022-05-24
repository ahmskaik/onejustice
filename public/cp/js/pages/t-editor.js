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
            "advlist autolink link image lists charmap preview hr anchor pagebreak code  ",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager youtube facebookembed instagram twitter"
        ],
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
        filemanager_title: "Filemanager",
        filemanager_crossdomain: false,
        external_filemanager_path: _base + "cp/plugins/t-editor/plugins/responsive_filemanager/filemanager/",
        external_plugins: {
            "responsivefilemanager": "plugins/responsive_filemanager/plugin.min.js",
            "filemanager": "plugins/responsive_filemanager/filemanager/plugin.min.js"
        },
        toolbar1: "bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ltr rtl| styleselect| fontsizeselect | forecolor backcolor| table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol | code | preview || responsivefilemanager | image | media | link unlink | youtube | facebookembed | twitter  ",
        toolbar2: "",
        relative_urls: false,
        document_base_url: 'https://localhost/',
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
        external_filemanager_path: _base + "cp/plugins/t-editor/plugins/responsive_filemanager/filemanager/",
        external_plugins: {
            "responsivefilemanager": "plugins/responsive_filemanager/plugin.min.js",
            "filemanager": "plugins/responsive_filemanager/filemanager/plugin.min.js"
        },
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
