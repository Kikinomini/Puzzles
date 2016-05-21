/**
 * Created by Silas on 10.10.2014.
 */
var flashMessenger = {

    messageCount: 0,
    messageTypeSuccess: 1,
    messageTypeError: 2,

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
    deleteMessage : function (idNummer) {
        $("#flashMessage" + idNummer).slideUp("slow");
    },

    addMessage: function(messageType, messageText)
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
        }
        flashMessage += "' id = 'flashMessage"+this.messageCount+"' onmouseout='flashMessenger.hideX("+this.messageCount+")' onmouseover='flashMessenger.showX("+this.messageCount+")'><b>"+messageText+"</b><span class = 'flashMessage' id = 'flashMessageX"+this.messageCount+"' onclick = 'flashMessenger.deleteMessage("+this.messageCount+")'>&#x2716;</span></div>";
        $("#flashMessageContainer").append(flashMessage);
        this.messageCount++;
    },

    setMessageCount: function(messageCount)
    {
        //this.messageCount = messageCount;
    }
}