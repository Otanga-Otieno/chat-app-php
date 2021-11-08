function searchUser(name) {
    fetchSearch(name);
}

function fetchSearch(name) {

    fetch('usearch.php', {
        method: 'POST',
        body: new URLSearchParams('name=' + name)
    })
    .then(res => res.json())
    .then(res => showUserList(res))
    .catch(e => console.error('Error: ' + e))

}

function showUserList(data) {

    const uList = document.getElementById("userList");
    uList.innerHTML = "";

    const sli = document.createElement("li");
    const shr = document.createElement("hr");
    uList.appendChild(sli);
    uList.appendChild(shr);

    for(let i = 0; i < data.length; i++) {
        const li = document.createElement("li");
        const hr = document.createElement("hr");
        const a = document.createElement("a");

        a.innerHTML = data[i];
        a.href = "chat/?to=" + data[i];
        uList.appendChild(li);
        li.appendChild(a);
        uList.appendChild(hr);
    }

}

function sendText() {

    const message = document.getElementById('msg').value;
    const receiver = document.getElementById('rec').value;
    const sender = document.getElementById('sen').value
    postMessage(sender, receiver, message);

}

function postMessage(sender, receiver, message) {

    var bodyParams = new URLSearchParams('message=' + message);
    bodyParams.append("sender", sender);
    bodyParams.append("receiver", receiver);

    fetch('messageapi.php', {
        method: 'POST',
        body: bodyParams
    })
    .then(res => updateMessage())
    .catch(e => console.error('Error: ' + e))

}

function updateMessage() {

    const textbox = document.getElementById("msg");
    msg.value = "";

}