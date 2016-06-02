/**
 * Created by Silas on 10.10.2014.
 */
var flashMessenger = {

    messageCount: 0,
    messageTypeSuccess: 1,
    messageTypeError: 2,
    messageTypeDefault: 3,
    messageTypeInfo: 4,
    messageTypeWarning: 5,
    defaultTimeToShow: 5000, //in milliseconds

    showX : function(idNummer)
    {
        $("#flashMessageX"+idNummer).stop();
        $("#flashMessageX"+idNummer).fadeIn();
    },

    hideX : function(idNummer)
    {
        $("#flashMessageX"+idNummer).stop();
        $("#flashMessageX"+idNummer).fadeOut();
    },
    deleteMessage : function (idNummer, delayInMilliSeconds) {
        if (typeof delayInMilliSeconds == 'undefined')
        {
            delayInMilliSeconds = 0;
        }
        if (delayInMilliSeconds <= 0)
        {
            $("#flashMessage" + idNummer).slideUp("slow");
        }
        else
        {
            $("#flashMessage" + idNummer).delay(delayInMilliSeconds).slideUp("slow");
        }
    },

    addMessage: function(messageType, messageText, timeToShow)
    {
        var flashMessage = "<div class = 'flashMessage";
        switch (messageType)
        {
            case this.messageTypeSuccess:
            {
                flashMessage += " success";
                break;
            }
            case this.messageTypeError:
            {
                flashMessage += " error";
                break;
            }
			case this.messageTypeDefault:
			{
				flashMessage += " default";
				break;
			}
			case this.messageTypeInfo:
			{
				flashMessage += " info";
				break;
			}
			case this.messageTypeWarning:
			{
				flashMessage += " warning";
				break;
			}
        }
        flashMessage += "' id = 'flashMessage"+this.messageCount+"' onmouseout='flashMessenger.hideX("+this.messageCount+")' onmouseover='flashMessenger.showX("+this.messageCount+")'><b>"+messageText+"</b><span class = 'flashMessage' id = 'flashMessageX"+this.messageCount+"' onclick = 'flashMessenger.deleteMessage("+this.messageCount+")'>&#x2716;</span></div>";
        $("#flashMessageContainer").append(flashMessage);

        if (typeof timeToShow == 'undefined')
        {
            timeToShow = this.defaultTimeToShow;
        }
        if (timeToShow > 0)
        {
            // this.deleteMessage(this.messageCount, timeToShow);
        }
        this.messageCount++;
    }
};