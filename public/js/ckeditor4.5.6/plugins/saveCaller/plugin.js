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
    var pluginName = 'saveCaller';
    CKEDITOR.plugins.add(pluginName,
        {
            icons: pluginName,
            init: function (editor) {
                var command = editor.addCommand(pluginName, saveCmd);

                editor.ui.addButton('saveButton',
                    {
                        label: editor.lang.save.toolbar,
                        command: pluginName,
                        toolbar: 'document,0',
                        icon: settings.basePath+'/images/saveButton.png'
                    });
            }
        });

})();