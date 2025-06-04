let reset_password = document.getElementById("reset_password");
reset_password.addEventListener("submit", function(event) {
    event.preventDefault()
    let formData = new FormData(this);

    fetch('../model/changer_mdp.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            console.log("Response status:", response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            console.log("Response data:", data);
            document.getElementById('response-container').innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
        });
});