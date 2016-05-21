(function () {
    var saveCmd =
    {
        exec: function (editor) {
            var callback = CKEDITOR.customValues.saveCaller.callback;
            if (callback) {
                try {
                    editor.updateElement();
                    callback(editor);
                } catch (e) {
                    alert("Etwas ist schief gelaufen.");
                    console.log(e);
                }
            }
        }
    };
    var saveButtonStateSaved = true;
    var setSaveButtonUnsaved =
    {
        exec: function (editor) {
            console.log("Unsaved", saveButtonStateSaved);
            if (saveButtonStateSaved) {
                saveButtonStateSaved = false;
                $('.cke_button__save_icon').css('background-position', '0 0').css('background-image', 'url(' + settings.basePath + '/img/favicon.ico' + ')').css('background-repeat', 'no-repeat');
            }
        }
    };
    var setSaveButtonSaved =
    {
        exec: function (editor) {
            console.log("Saved", saveButtonStateSaved);
            if (!saveButtonStateSaved) {
                saveButtonStateSaved = true;
                $('.cke_button__save_icon').css('background-position', '0 0').css('background-image', 'url(' + settings.basePath + '/img/logo.ico' + ')').css('background-repeat', 'no-repeat');
            }
        }
    };
    var pluginName = 'saveCaller';
    var setSaveButtonUnsavedName = 'setSaveButtonUnsaved';
    var setSaveButtonSavedName = 'setSaveButtonSaved';
    CKEDITOR.plugins.add(pluginName,
        {
            icons: pluginName,
            init: function (editor) {
                var command = editor.addCommand(setSaveButtonUnsavedName, setSaveButtonUnsaved);
                command = editor.addCommand(pluginName, saveCmd);
                command = editor.addCommand(setSaveButtonSavedName, setSaveButtonSaved);
                ceditor.addCommand( 'sample', {
                    exec: function( editor ) {
                        alert( 'Executing a command for the editor name "' + editor.name + '"!' );
                    }
                } );

                editor.ui.addButton('Save',
                    {
                        label: editor.lang.save.toolbar,
                        command: pluginName,
                        toolbar: 'document,0'
                    });
            }
        });

})();