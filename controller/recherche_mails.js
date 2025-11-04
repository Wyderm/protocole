let email_recherche = document.getElementById('email_recherche');
let result_email = document.getElementById('result_email');

email_recherche.onkeyup = (e) => {
    let userData = e.target.value;
    if (userData) {
        result_email.hidden = false;
        fetch('../model/get_all_emails.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ query: userData })
        })
            .then(response => response.json())
            .then(data => {
                let suggestions = data.map((item) => {
                    return `<li>${item}</li>`;
                });
                result_email.classList.add('active');
                showSuggestions(result_email, suggestions);
                let allNom = document.querySelectorAll('#result_email li');
                for (element in allNom) {
                    element.setAttribute('onclick', 'selectNom(this)');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        result_email.classList.remove('active');
        result_email.hidden = true;
        showSuggestions(result_email, []);
    }
}

function selectNom(element) {
    email_recherche.value = element.textContent;
    result_email.classList.remove('active');
    result_email.innerHTML = '';
}

function showSuggestions(element, list) {
    let listData;
    if (list.length) {
        listData = list.join('');
    } else {
        let userValue = element.previousElementSibling.value;
        listData = '<li>' + userValue + '</li>';
    }
    element.innerHTML = listData;
}
