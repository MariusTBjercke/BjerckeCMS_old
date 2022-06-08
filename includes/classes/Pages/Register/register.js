import {DOMReady} from "@assets/js/shared/domready";
import {ajaxPostJson} from '@assets/js/functions/ajax';

DOMReady(() => {
    const element = document.querySelector('.register-form');

    if (element) {
        const usernameField = element.querySelector(".register-form #username");
        const passwordField = element.querySelector(".register-form #password");
        const emailField = element.querySelector(".register-form #email");
        const registerBtn = element.querySelector(".register-form #submit");

        // Add listener for "enter" key.
        element.addEventListener("keydown", (e) => {
            if (e.keyCode === 13) {
                registerBtn.click();
            }
        });

        registerBtn.addEventListener('click', (e) => {
            let error = 0;

            // Form validation
            for (let item of [
                [usernameField, "Please fill inn a username."],
                [passwordField, "Please fill inn a password."],
                [emailField, "Please fill in a email address.", [/^(.+)@(.+)$/, "Please fill in a valid email address."]]
            ]) {
                if (!item[0].value) {
                    item[0].classList.add('register-form__input-error');

                    if (item[0].nextElementSibling && item[0].nextElementSibling.classList.contains('login-form__error-message')) {
                        item[0].nextElementSibling.remove();
                    }

                    const errorMessage = document.createElement('div');
                    errorMessage.setAttribute('class', 'login-form__error-message');
                    errorMessage.innerHTML = "*" + item[1];
                    item[0].parentNode.appendChild(errorMessage);

                    error++;
                } else {
                    if (item[0].classList.contains("register-form__input-error")) {
                        item[0].classList.remove("register-form__input-error");
                    }
                    if (item[0].nextElementSibling && item[0].nextElementSibling.classList.contains('login-form__error-message')) {
                        item[0].nextElementSibling.remove();
                    }

                    // If regex is set, check if the email is valid.
                    if (item[2]) {
                        if (!item[0].value.match(item[2][0])) {
                            item[0].classList.add('register-form__input-error');
                            const errorMessage = document.createElement('div');
                            errorMessage.setAttribute('class', 'login-form__error-message');
                            errorMessage.innerHTML = "*" + item[2][1];
                            item[0].parentNode.appendChild(errorMessage);
                            error++;
                        }
                    }
                }
            }

            if (error > 0) {
                return;
            }

            let formData = new FormData();
            formData.append('action', 'register');
            formData.append('username', usernameField.value);
            formData.append('password', passwordField.value);
            formData.append('email', emailField.value);

            function callback(response) {
                if (response['action'] === 'success') {
                    window.location = "home";
                } else if (response['action'] === "error") {
                    alert("Something went wrong, please try again.");
                } else {
                    alert("Something went wrong, please try again.");
                }
            }

            let inputArr = [usernameField, passwordField, emailField];

            ajaxPostJson(formData, inputArr, callback);
        });
    }
});