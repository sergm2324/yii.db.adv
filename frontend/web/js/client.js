if (!window.WebSocket) {
    alert("Ваш браузер не поддерживает Веб-сокеты");
}

var webSocket = new WebSocket("ws://localhost:6380");

document.getElementById("chat_form")
    .addEventListener("submit", function (event) {
        var username = document.getElementById("username").textContent;
        var user_id = document.getElementById("user_id").textContent;
        var task_id = document.getElementById("task_id").textContent;
        var text = this.message.value;
        var arr = JSON.stringify({"username": username, "user_id": user_id, "task_id": task_id,"text": text});
        webSocket.send(arr);
        event.preventDefault();
        return false;
    });


webSocket.onmessage = function (event) {
    var data = event.data;
    var messageContainer = document.createElement('div');
    messageContainer.className = 'my-message';
    var textNode = document.createTextNode(data);
    messageContainer.appendChild(textNode);
    document.getElementById("chat").appendChild(messageContainer);

};