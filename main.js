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
    .then(res => updateMessage(message))
    .then(res => livereceiving(sender, receiver))
    .catch(e => console.error('Error: ' + e))

}

function updateMessage(message) {

    const textbox = document.getElementById("msg");
    textbox.value = "";

    const chatbox = document.getElementById("chatbox");
    const span = document.createElement("span");
    const br = document.createElement("br");

    span.innerHTML = message;
    span.classList.add("rounded");
    span.classList.add("p-1");
    span.style.display = "block";
    span.style.width = "fit-content";
    span.style.marginLeft = "auto";
    span.style.marginRight = "0";
    span.style.backgroundColor = "#dcf8c6";

    chatbox.appendChild(span);
    chatbox.appendChild(br);

}

function receiveMessage(message) {

    const chatbox = document.getElementById("chatbox");
    const span = document.createElement("span");
    const br = document.createElement("br");

    span.innerHTML = message;
    span.classList.add("rounded");
    span.classList.add("p-1");
    span.style.display = "block";
    span.style.width = "fit-content";
    span.style.marginLeft = "0";
    span.style.marginRight = "auto";
    span.style.backgroundColor = "#fff5c4";

    chatbox.appendChild(span);
    chatbox.appendChild(br);

}

async function livereceiver(user, receiver) {
    
    var latestChat = document.getElementById("lcid");
    var lcid = latestChat.textContent;
    var bodyParams = new URLSearchParams('user=' + user);
    bodyParams.append("receiver", receiver);
    bodyParams.append("lcid", lcid);

    let response = await fetch("livereceiverapi.php", {
        method: 'POST',
        body: bodyParams
    })

    if(response.status == 500) {

        await livereceiver(user, receiver);

    } else if(response.status != 200) {

        await new Promise(resolve => setTimeout(resolve, 1000));
        await livereceiver(user, receiver);

    } else {

        var dataText = response.text();

        if((await dataText).length > 0) {
            var data = response.json();
            
            data
            .then(res => receiveMessage(res[0]))
            .then(latestChat.textContent = res[1]);
        }
        await livereceiver(user, receiver);

    }
    
}

function livereceiving(user, receiver) {
    livereceiver(user, receiver);
}