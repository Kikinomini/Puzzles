var MyJsonAjax =
{
    requestUrl: function(url, callbackSuccess, callbackError)
    {
        $.ajax({
            dataType: "json",
            url: url,
            success: function(data)
            {
                callbackSuccess(data)
            },
            error: function()
            {
                callbackError();
            }
        });
    }
};