function getGames() {
    fetch('/games')
        .then(function (data) {
            return data.json()
        })
        .then(function (games) {
            games.data.games.forEach(function (game) {
                var newElem = document.createElement ("div");
                newElem.innerHTML = game.name;
                newElem.setAttribute('data-id', game.id)
                newElem.setAttribute('data-name', game.name)
                newElem.classList.add('game')
                newElem.classList.add('infoBox')
                var container = document.getElementById ("games");
                container.appendChild (newElem);
            })
        })
        .then(function () {
            let gameList = document.querySelectorAll('.game')
            gameList.forEach(function (game) {
                game.addEventListener('click',function (e) {
                    let id = e.target.getAttribute('data-id')
                    let name = e.target.getAttribute('data-name')
                    getScoresByGame(id, name)
                })
            })
        })
}

function clearGames() {
    document.getElementById('games').innerHTML = ""
}

function getUsers() {
    fetch('/users')
        .then(function (data) {
            return data.json()
        })
        .then(function (users) {
            users.data.users.forEach(function (user) {
                var newElem = document.createElement ("div");
                newElem.innerHTML = user.name;
                newElem.setAttribute('data-id', user.id)
                newElem.classList.add('user')
                newElem.classList.add('infoBox')
                var container = document.getElementById ("users");
                container.appendChild (newElem);
            })
        })
        .then(function () {
            let userList = document.querySelectorAll('.user')
            userList.forEach(function (user) {
                user.addEventListener('click',function (e) {
                    console.log(e.target)
                    let id = e.target.getAttribute('data-id')
                    createScoreForm()
                })
            })
        })
}

function clearUsers() {
    document.getElementById('users').innerHTML = ""
}

getGames()
getUsers()
