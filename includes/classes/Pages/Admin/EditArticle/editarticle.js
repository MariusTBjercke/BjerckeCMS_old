import {DOMReady} from "@assets/js/shared/domready";
import {initFroala} from "@assets/js/functions/froala";

DOMReady(() => {
    const element = document.querySelector('.edit-article');

    if (element) {
        const content = element.querySelector('#content');
        const submitBtn = element.querySelector('.edit-article__submit');

        // Initialize Froala editor.
        const froala = initFroala(content);

        submitBtn.addEventListener('click', function (e) {
            const titleInput = element.querySelector('#title');
            const contentInput = element.querySelector('#content');
            const articleId = element.querySelector('.edit-article__form').getAttribute('data-article-id');
            const backgroundCheck = element.querySelector('#background-image-checkbox');
            const backgroundImage = element.querySelector('#background-image');
            const background_file = backgroundImage.files[0];

            let formData = new FormData();
            formData.append('action', 'edit_article');
            formData.append('title', titleInput.value);
            formData.append('content', contentInput.value);
            formData.append('background_check', backgroundCheck.checked);
            formData.append("background_file", background_file);
        });
    }
});