import {ajaxPostJson} from '../functions/ajax.js';

up.compiler('.login-form', (element) => {
    const usernameField = element.querySelector(".login-form #username");
    const passwordField = element.querySelector(".login-form #password");
    const loginBtn = element.querySelector(".login-form #submit");

    // Add listener for "enter" key.
    element.addEventListener("keydown", (e) => {
        if (e.keyCode === 13) {
            loginBtn.click();
        }
    });

    loginBtn.addEventListener('click', (e) => {
        let error = 0;

        // Form validation
        for (let item of [
            [usernameField, "Please fill in a username."],
            [passwordField, "Please fill in a password."]
        ]) {
            if (!item[0].value) {
                item[0].classList.add('login-form__input-error');

                if (item[0].nextElementSibling && item[0].nextElementSibling.classList.contains('login-form__error-message')) {
                    item[0].nextElementSibling.remove();
                }

                const errorMessage = document.createElement('div');
                errorMessage.setAttribute('class', 'login-form__error-message');
                errorMessage.innerHTML = "*" + item[1];
                item[0].parentNode.appendChild(errorMessage);

                error++;
            } else {
                if (item[0].classList.contains("login-form__input-error")) {
                    item[0].classList.remove("login-form__input-error");
                }
                if (item[0].nextElementSibling && item[0].nextElementSibling.classList.contains('login-form__error-message')) {
                    item[0].nextElementSibling.remove();
                }
            }
        }

        if (error > 0) {
            return;
        }

        let data = {
            action: 'login',
            username: usernameField.value,
            password: passwordField.value
        };

        let formData = new FormData();
        formData.append('action', 'login');
        formData.append('username', usernameField.value);
        formData.append('password', passwordField.value);

        function callback(response) {
            if (response['action'] === "success") {
                window.location = "profile";
            } else {
                alert("Wrong username or password, please try again.");
            }
        }

        let inputArr = [usernameField, passwordField];

        ajaxPostJson(formData, inputArr, callback);
    });
});