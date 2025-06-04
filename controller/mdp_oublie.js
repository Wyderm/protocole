let mdp_oublie = document.getElementById("mdp_oublie");
mdp_oublie.addEventListener("submit", function(event) {
    event.preventDefault()
    let formData = new FormData(this);

    fetch('../model/envoyer_reset_mdp.php', {
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