function searchUser(name) {
    fetchSearch(name);
}

function searchUsername(name) {
    fetchUsername(name);
}

function verifyUsername(b) {

    var unameWarning = document.getElementById("usernameWarning");
    var signupButton = document.getElementById("signupBtn");

    if(b == 1) {
        unameWarning.removeAttribute("hidden");
        signupButton.disabled = true;
    } else {
        unameWarning.setAttribute("hidden", true);
        signupButton.disabled = false;
    }

}

function fetchUsername(name) {

    fetch('https://otanga.co.ke/Projects/Chat-App-PHP/unameverify.php', {
        method: 'POST',
        body: new URLSearchParams('name=' + name)
    })
    .then(res => res.json())
    .then(res => verifyUsername(res))
    .catch(e => console.error('Error: ' + e))

}

function fetchSearch(name) {

    fetch('https://otanga.co.ke/Projects/Chat-App-PHP/usearch.php', {
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

    for(let i = 0; i < data.length; i++) {

        const div = document.createElement("div");
        const messageDiv = document.createElement("div");
        const span = document.createElement("span");
        const a = document.createElement("a");
        const b = document.createElement("b");
        const br = document.createElement("br");

        div.classList.add("card", "py-3", "m-1");
        a.classList.add("btn", "mainbg", "white");
        span.style.color = "black";
        messageDiv.style.width = "100%";
        messageDiv.style.textAlign = "center";

        b.innerHTML = data[i];
        span.appendChild(b);
        a.innerHTML = "Message";
        a.href = "chat/?to=" + data[i];
        div.appendChild(span);
        div.appendChild(br);
        messageDiv.appendChild(a);
        div.appendChild(messageDiv);
        uList.appendChild(div);
        
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

function receiveMessage(message, id) {
    var latestChat = document.getElementById("lcid");

    if(message.length < 1) {
        return;
    }

    //if latest chat is already received skip this function
    if(latestChat.textContent == id) {
        return;
    }

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
    latestChat.textContent = id;

}

async function livereceiver(user, receiver) {

    const delay = ms => new Promise(res => setTimeout(res, ms));
    await delay(1000);

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

        var data = response.json();

        data
        .then(res => receiveMessage(res[0], res[1]))

        await livereceiver(user, receiver);

    }
    
}

function livereceiving(user, receiver) {
    livereceiver(user, receiver);
}