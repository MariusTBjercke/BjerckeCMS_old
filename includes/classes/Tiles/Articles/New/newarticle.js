import {DOMReady} from "@assets/js/shared/domready";
import {initFroala} from "@assets/js/functions/froala";
import {ajaxPostJson} from "@assets/js/functions/ajax";

DOMReady(() => {
    const element = document.querySelector('.new-article');

    if (element) {
        const titleInput = element.querySelector('#title');
        const contentInput = element.querySelector('#content');
        const submitBtn = element.querySelector('#submit');
        const inputArr = [titleInput, contentInput];

        // Initialize Froala editor.
        const froala = initFroala(contentInput);

        submitBtn.addEventListener('click', (e) => {
            const backgroundCheck = element.querySelector('#background-image-checkbox');
            const backgroundImage = element.querySelector('#background-image');
            const background_file = backgroundImage.files[0];

            let formData = new FormData();
            formData.append('action', 'new_article');
            formData.append('title', titleInput.value);
            formData.append('content', contentInput.value);
            formData.append('background_check', backgroundCheck.checked);
            formData.append("background_file", background_file);

            function callback(response) {
                console.log(response);

                // Clear editor.
                froala.html.set('');
            }

            ajaxPostJson(formData, inputArr, callback);
        });
    }
});