function checkIfUserHasPlayedTheGame(userId, gameId) {
    fetch('/user/score/' + userId + '/' + gameId)
        .then(function (data) {
            return data.json()
        })
        .then(function (score) {
            console.log(score)
            let result = score.data.scores[0].scores
            if(result == 1){
                let currentScore = score.data.scores[0].score
                let newScore = parseInt(currentScore) + 1
                fetch('/addToExistingScore/' + userId + '/' + gameId + '/' + newScore)
            } else {
                fetch('/addNewScore/' + userId + '/' + gameId)
            }
        })
}