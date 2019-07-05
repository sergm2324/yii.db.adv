if (!window.WebSocket) {
    alert("Ваш браузер не поддерживает веб-сокеты!!");
}

var webSocket = new WebSocket("ws://front.site.local:6380?channel=" + channel);

document.getElementById("chat_form")
    .addEventListener("submit", function (event) {
        event.preventDefault();
        var data = {
            message : this.message.value,
            user_id : this.user_id.value,
            channel : +this.channel.value
        };

        webSocket.send(JSON.stringify(data));
        return false;
    });

webSocket.onmessage = function (event) {
    var data = event.data;
    var messageContainer = document.createElement('div');
    var textNode = document.createTextNode(data);
    messageContainer.appendChild(textNode);
    document.getElementById("chat")
        .appendChild(messageContainer);
};