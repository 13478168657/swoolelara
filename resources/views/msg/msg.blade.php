<html>

<head>
    <title>blog</title>
    <meta charset="utf-8">
</head>
<body>
<div><span>欢迎，</span><span id="name"></span></div>
<textarea id="msg"></textarea>
<button id="send">发送</button>
<div class="frame">
    <div class="clear">
        <div class="left">
            <span></span>
        </div>
        <div class="right">
            <span></span>
        </div>

    </div>
</div>
</body>
<style>
    .frame{
        float:right;
        width:200px;
        height:500px;
        margin-right:300px;
        border:1px solid red;
    }
    .clear{
        clear: both;
    }
    .left{
        border:1px solid red;
        height:15px;
        width:100%;
    }
    .right{
        border:1px solid red;
        height:15px;
        width:80px;
        margin-right:10px;
    }

</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.12.1.min.js"></script>
<script>
    var nameArr = ["小王","小杨","小鸭","小鸡","李四"];
    var key = Math.floor((Math.random()*5));
    var name = nameArr[key];
    $("#name").text(name);
    var wsServer = 'ws://blgself.com/ws';
    var websocket = new WebSocket(wsServer);
    websocket.onopen = function (evt) {
        console.log("Connected to WebSocket server.");
    };

    websocket.onclose = function (evt) {
        console.log("Disconnected");
    };

    websocket.onmessage = function (evt) {
        console.log('Retrieved data from server: ' + evt.data);
    };

    websocket.onerror = function (evt, e) {
        console.log('Error occured: ' + evt.data);
    };

    $("#send").click(function(){
        var msg = $("#msg").val();
        var info = {name:name, msg:msg};
        websocket.send(JSON.stringify(info));
    });
</script>
</html>