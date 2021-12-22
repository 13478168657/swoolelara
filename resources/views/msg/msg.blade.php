<html>

<head>
    <title>blog</title>
    <meta charset="utf-8">
</head>
<body>
<div><span>欢迎，</span><span id="name"></span></div>
<textarea id="msg"></textarea>
<button id="send">发送</button>
<div style="width:200px;height:500px;margin-left:300px;border-color:red;">
    <div class="left"></div>
    <div class="right"></div>
</div>
</body>
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
        websocket.send(msg);
    });
</script>
</html>