import {DOMReady} from "@assets/js/shared/domready";
import {ajaxPostJson} from "../functions/ajax";

DOMReady(() => {
    const element = document.querySelector('.new-page');

    if (element) {
        const nameInput = element.querySelector("#name");
        const titleInput = element.querySelector("#title");
        const descriptionInput = element.querySelector("#description");
        const iconInput = element.querySelector("#icon");
        const urlInput = element.querySelector("#url");
        const templateInput = element.querySelector("#template");
        const classInput = element.querySelector("#class");
        const navigationInput = element.querySelector("#navigation");
        const requiresLoginInput = element.querySelector("#requires-login");
        const submitBtn = element.querySelector("#submit");

        let inputArr = [nameInput, titleInput, descriptionInput, iconInput, urlInput, templateInput, classInput, navigationInput, requiresLoginInput];

        submitBtn.addEventListener('click', (e) => {
            e.preventDefault();

            let formData = new FormData();
            formData.append('action', 'new_page');
            formData.append('name', nameInput.value);
            formData.append('title', titleInput.value);
            formData.append('description', descriptionInput.value);
            formData.append('icon', iconInput.value);
            formData.append('url', urlInput.value);
            formData.append('template', templateInput.value);
            formData.append('class', classInput.value);
            formData.append('navigation', navigationInput.checked);
            formData.append('requires_login', requiresLoginInput.checked);

            function callback(response) {
                if (response['action'] === 'success') {
                    console.log(response);
                    // console.log('Page was added successfully!');
                } else {
                    console.log('Something went wrong!');
                }
            }

            ajaxPostJson(formData, inputArr, callback);
        });
    }
});