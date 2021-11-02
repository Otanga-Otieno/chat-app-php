function searchUser(name) {
    fetchSearch(name);
}

function fetchSearch(name) {

    fetch('usearch.php', {
        method: 'POST',
        body: new URLSearchParams('name=' + name)
    })
    .then(res => res.json())
    .then(res => showUserList(res, name))
    .catch(e => console.error('Error: ' + e))

}

function showUserList(data, name) {

    const uList = document.getElementById("userList");
    uList.innerHTML = "";

    if(("".localeCompare(name)) == 0) {
        const sli = document.createElement("li");
        const shr = document.createElement("hr");
        uList.appendChild(sli);
        uList.appendChild(shr);
    }

    for(let i = 0; i < data.length; i++) {
        const li = document.createElement("li");
        const hr = document.createElement("hr");
        li.innerHTML = data[i];
        uList.appendChild(li);
        uList.appendChild(hr);
    }

}