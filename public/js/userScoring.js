function checkIfUserHasPlayedTheGame(userId, gameId) {
    fetch('/user/score/' + userId + '/' + gameId)
        .then(function (data) {
            return data.json()
        })
        .then(function (score) {
            console.log(score)
        })
}