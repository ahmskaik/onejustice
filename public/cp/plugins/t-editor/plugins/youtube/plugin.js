/**
 * Youtube search - a TinyMCE youtube search and place plugin
 * youtube/plugin.js
 *
 * This is not free softwaer
 *
 * Plugin info: http://www.cfconsultancy.nl/
 * Author: Ceasar Feijen
 *
 * Version: 1.2 released 29/08/2013
 */

tinymce.PluginManager.add('youtube', function(editor) {

    function openmanager() {
        var title="Choose YouTube Video";
        if (typeof tinymce.settings.youtube_title !== "undefined" && tinymce.settings.youtube_title) {
            title=tinymce.settings.youtube_title;
        }
        win = editor.windowManager.open({
            title: title,
            file: tinyMCE.baseURL + '/plugins/youtube/youtube.html',
            filetype: 'video',
	    	width: 785,
            height: 590,
            inline: 1,
            buttons: [{
                text: 'cancel',
                onclick: function() {
                    this.parent()
                        .parent()
                        .close();
                }
            }]
        });

    }
	editor.addButton('youtube', {
		icon: true,
        text: 'Embed Youtube',
        context: "toolbar",
        image: tinyMCE.baseURL + '/plugins/youtube/icon.png',
		tooltip: 'Insert/edit Youtube video',
		shortcut: 'Ctrl+Q',
		onclick: openmanager
	});

	editor.addShortcut('Ctrl+Q', '', openmanager);

	editor.addMenuItem('youtube', {
		icon:'media',
		text: 'Insert Youtube video',
		shortcut: 'Ctrl+Q',
		onclick: openmanager,
		context: 'insert'
	});
});
