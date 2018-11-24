let userSubmitButton = document.getElementById('submitUser')

userSubmitButton.addEventListener('click', function () {
    let newUser = document.getElementById('addUser').value
    if (newUser !== null && newUser !== ''){
        let data = {
            "user": newUser
        }
        fetch('/api/addUser', {
            credentials: "same-origin",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            method: "POST",
            body: JSON.stringify(data)
        }).then(function () {
            clearUsers()
            getUsers()
            document.getElementById('addUser').value = ''
        })
    }
})