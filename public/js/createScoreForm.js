function createScoreForm() {
    fetch('/games')
        .then(function (data) {
            return data.json()
        })
        .then(function (games) {
            var newSelectElem = document.createElement ("select");
            newSelectElem.classList.add('selectDropdown')
            var container = document.getElementById ("modal");
            container.style.display = 'block'
            container.appendChild(newSelectElem);
            games.data.games.forEach(function (game) {
                var newElem = document.createElement ("option");
                newElem.innerHTML = game.name;
                newElem.setAttribute('value', game.id)
                let selectDropdown = document.querySelector('.selectDropdown')
                selectDropdown.appendChild(newElem);
            })
            
        })
        .then(function () {
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
            
        })
}