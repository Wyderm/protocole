let password = document.getElementById("password");
let submit = document.getElementById("submit");
let message = document.getElementById("message");

function verif() {
    let passwordValue = password.value;
    let passwordLength = passwordValue.length;

    if (passwordLength < 15) {
        return false;
    }

    if (!/[A-Z]/.test(passwordValue)) {
        return false;
    }

    if (!/[a-z]/.test(passwordValue)) {
        return false;
    }

    if (!/[0-9]/.test(passwordValue)) {
        return false;
    }

    return /[^A-Za-z0-9]/.test(passwordValue);
}

password.onkeyup = (e) => {
    if (verif()) {
        password.style.border = "2px solid green";
        submit.disabled = false;
        message.hidden = true;
    } else {
        password.style.border = "2px solid red";
        submit.disabled = true;
        message.hidden = false;
    }
}