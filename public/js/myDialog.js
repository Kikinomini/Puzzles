/**
 * Created by Silas on 26.03.2015.
 */

var myDialog =
{
    lastDialog: null,
    id: 0,

    confirmDialog: function (title, question, confirmButtonText, cancelButtonText, callack) {
        var dialog = this.getDivElement(title, question);
        $(dialog).dialog({
            modal: true,
            buttons: [
                {
                    text: confirmButtonText,
                    icons: {
                        primary: "ui-icon-heart"
                    },
                    click: function () {
                        $(this).dialog("close");
                        callack(true);
                    }
                },
                {
                    text: cancelButtonText,
                    icons: {
                        primary: "ui-icon-heart"
                    },
                    click: function () {
                        $(this).dialog("close");
                        callack(false);
                    }
                }
            ]
        });
    },

    confirmDialogWithUrl: function(title, question, url, confirmButtonText, cancelButtonText)
    {
        myDialog.confirmDialog(title, question, confirmButtonText, cancelButtonText, function (confirm) {
            if (confirm)
            {
                $(location).attr("href", url);
            }
        })
    },

    customDialog: function (title, content, settings, buttons, extraClasses) {
        predefinedSettings = {
            modal: true,
            height: 'auto',
            width: 'auto',
            maxHeight: '90%',
            maxWidth: '90%'
        };
        settings = $.extend(predefinedSettings, settings);
        settings.buttons = buttons;
        console.log(settings);
        var dialog = this.getDivElement(title, content, extraClasses);
        $(dialog).dialog(settings).parent().find('div.ui-dialog-titlebar').addClass(extraClasses);
    },

    modalDialog: function (title, content, closeButtonText) {
        var dialog = this.getDivElement(title, content);
        $(dialog).dialog({
            modal: true,
            height: 'auto',
            width: 'auto',
            minHeight: '20%',
            minWidth: 500,
            maxHeight: '90%',
            maxWidth: '90%',
            buttons: [
                {
                    text: closeButtonText,
                    icons: {
                        primary: "ui-icon-heart"
                    },
                    click: function () {
                        $(myDialog.lastDialog).dialog("close");
                    }
                }
            ]
        });
    },

    getDivElement: function (title, content, extraClasses) {
        extraClasses = (typeof extraClasses !== 'undefined') ? extraClasses : "";

        this.id++;
        this.lastDialog = $("<div id = 'modalDialog_" + this.id + "' class = 'myModalDialog " + extraClasses + "' title = '" + title + "'>" + content + "</div>");
        return this.lastDialog
    },

    ajaxDialog: function (title, url, closeButtonText, postParams) {
        this.modalDialog(title, '<img src="' + settings.basePath + '/image/loading.gif"></img>', closeButtonText);

        $.ajax(url, {}).done(function (data, textStatus, jqXHR) {
            $(myDialog.lastDialog).html(data);
            //console.log($("#modalDialog_"+myDialog.id).children('.ui-dialog').innerWidth(), $("#modalDialog_"+myDialog.id).children('.ui-dialog'))
        }).fail(function (xhr, textStatus, errorThrown) {
            $(myDialog.lastDialog).html(xhr.responseText);
            //$("#mocalDialog_"+myDialog.id).dialog("option", "appendTo", xhr.responseText);
        });
    }
}