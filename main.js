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
    console.log(data.length);
    console.log(data[0]);

    for(let i = 0; i < data.length; i++) {
        const li = document.createElement("li");
        li.innerHTML = data[i]["uemail"];
        uList.appendChild(li);
    }

}