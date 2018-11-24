function createScoreForm(userId, userName) {
    fetch('/games')
        .then(function (data) {
            return data.json()
        })
        .then(function (games) {
            var newSelectElem = document.createElement ("select");
            var newButton = document.createElement ("button");
            var userData = document.createElement ("div");
            userData.classList.add('userData')
            userData.setAttribute('data-id', userId)
            userData.innerHTML = 'Add a win for ' + userName
            newButton.innerHTML = "+1 to your score!"
            newButton.classList.add('submitNewScoreButton')
            newSelectElem.classList.add('selectDropdown')
            var container = document.getElementById ("modal");
            container.style.display = 'block'
            container.appendChild(userData);
            container.appendChild(newSelectElem);
            container.appendChild(newButton);
            games.data.games.forEach(function (game) {
                var newElem = document.createElement ("option");
                newElem.innerHTML = game.name;
                newElem.setAttribute('value', game.id)
                let selectDropdown = document.querySelector('.selectDropdown')
                selectDropdown.appendChild(newElem);
            })
            var close = document.createElement ("div");
            close.innerHTML = '<button id="closeModal">Close</button>';
            close.classList.add('closeModalBox')
            container.appendChild (close);

            let closeBox = document.querySelector('.closeModalBox')
            closeBox.addEventListener('click', function () {
                document.getElementById('modal').innerHTML = ''
                document.getElementById('modal').style.display = 'none'
            })
            
        })
        .then(function () {
            let submitButton = document.querySelector('.submitNewScoreButton')
            submitButton.addEventListener('click', function (e) {
                let dropdown = document.querySelector('.selectDropdown')
                let gameId = dropdown.value
                checkIfUserHasPlayedTheGame(userId, gameId)
            })
        })
}