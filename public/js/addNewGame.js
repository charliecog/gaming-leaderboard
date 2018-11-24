let gameSubmitButton = document.getElementById('submitGame')

gameSubmitButton.addEventListener('click', function () {
    let newGame = document.getElementById('addGame').value
    if (newGame !== null && newGame !== ''){
        console.log(newGame)
        let data = {
            "game": newGame
        }
        fetch('/api/addGame', {
            credentials: "same-origin",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            method: "POST",
            body: JSON.stringify(data)
        }).then(function () {
            clearGames()
            getGames()
            document.getElementById('addGame').value = ''
        })
    }
})