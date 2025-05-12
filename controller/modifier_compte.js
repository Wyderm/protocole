let modifier_compte = document.getElementById("modifier_compte");
modifier_compte.addEventListener("submit", function(event) {
    event.preventDefault()
    let formData = new FormData(this);
    document.getElementById("response-container").style.display = "flex";
    fetch('../model/modifier_compte_bdd.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            console.log(data)
            document.getElementById('response-container').innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
        });
});