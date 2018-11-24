function getScoresByGame(gameId, name) {
    fetch('/games/score/' + gameId)
        .then(function (data) {
            return data.json()
        })
        .then(function (scores) {
            document.getElementById('modal').style.display = 'block'
            var newElem = document.createElement ("div");
            newElem.innerHTML = name + ' scores:';
            newElem.classList.add('gameName')
            var container = document.getElementById ("modal");
            container.appendChild (newElem);

            scores.data.scores.forEach(function (player) {
                var newElem = document.createElement ("div");
                newElem.innerHTML = player.name + ": " + player.score;
                newElem.setAttribute('data-id', player.id)
                newElem.classList.add('userScore')
                newElem.classList.add('infoBox')
                var container = document.getElementById ("modal");
                container.appendChild (newElem);
            })
        })
}