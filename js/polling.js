function Chatter(){
    this.getMessage = function(callback, lastTime){
        var that = this;
        var latest = null;

        $.ajax({
            'url': 'get.php',
            'type': 'POST',
            'dataType': 'json',
            'data': {mode: 'get', numberOfMessages: MessageBoard.messages.length, lastTime: lastTime},
            'timeout': 30000,
            'cache': false,
            'success': function(data){
                if(data.result){
                    callback(data.message);
                    latest = data.latest;
                }
            },

            'complete': function(){
                that.getMessage(callback, latest);
            },
            'error': function(xhr, text)
            {
                console.log(xhr);
            }
        });
    };



    this.postMessage = function(user, message){
        console.log("inne i postmessage");
        $.ajax({
            url: 'get.php',
            type: 'POST',
            dataType: 'json',
            data: {
                mode: 'post',
                user: user,
                message: message,
                token: $('#token').val()
            },
            success: function(data){
                if(data.result == false)
                    alert(data.output);
            },
        });
    };
};

var chatter  = new Chatter();