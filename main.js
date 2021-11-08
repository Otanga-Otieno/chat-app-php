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

function sendText(text) {
    postMessage(text);
}

function postMessage(text) {

    fetch('messageapi.php', {
        method: 'POST',
        body: new URLSearchParams('message=' + text)
    })

}