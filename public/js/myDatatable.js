var myDatatable =
{
    confirmDialog: function (title, question, url, confirmButtonText, cancelButtonText)
    {
        myDialog.confirmDialog(title, question, confirmButtonText, cancelButtonText, function (confirm) {
            if (confirm)
            {
                $(location).attr("href", url);
            }
        })
    }
};

jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "date-german-pre": function(date)
    {
        if (date.search(" ") > 0)
        {
            var datetime = date.split(' ');
            var date = datetime[0].split('.');
            var time = datetime[1].split(':');

            if (date[2].length%2 == 1)
            {
                date[2] = date[2].substr(0,date[2].length-1);
            }

            return (date[2] + date[1] + date[0] + time[0] + time[1] + time[2])*1;//sorgt dafür, dass es ne Zahl wird
        } else
        {
            var date = date.split('.');
            return (date[2] + date[1] + date[0])*1; //sorgt dafür, dass es ne Zahl wird
        }
    },
    "date-german-asc": function ( a, b ) {
        console.log((a < b) ? -1 : ((a > b) ? 1 : 0));
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "date-german-desc": function ( a, b ) {
        console.log((a < b) ? 1 : ((a > b) ? -1 : 0));
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
});