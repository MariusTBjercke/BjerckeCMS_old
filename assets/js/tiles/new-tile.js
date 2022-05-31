import {DOMReady} from "@assets/js/shared/domready";
import {ajaxPostJson, ajaxPostHtml} from '../functions/ajax';

DOMReady(() => {
    const element = document.querySelector('.new-tile');

    if (element) {
        /**
         * Render the existing tiles with AJAX.
         */
        const existingTiles = element.querySelector('.new-tile__existing-tiles');
        const spinner = element.querySelector('.new-tile__spinner');

        let existingTilesData = new FormData();
        existingTilesData.append('action', 'render_tile_list');

        function renderExistingTiles(data) {
            const tileDataDiv = document.createElement('div');
            tileDataDiv.innerHTML = data;

            spinner.classList.add('hidden');

            existingTiles.innerHTML = '';
            existingTiles.appendChild(tileDataDiv);
        }

        ajaxPostHtml(existingTilesData, [], renderExistingTiles);

        /**
         * New tile form
         */
        const submitBtn = element.querySelector('#submit');

        submitBtn.addEventListener('click', (e) => {
            const titleInput = element.querySelector('#title');
            const templateInput = element.querySelector('#template');
            const classNameInput = element.querySelector('#class-name');

            const inputArr = [titleInput, templateInput, classNameInput];

            let formData = new FormData();
            formData.append('action', 'new_tile');
            formData.append('title', titleInput.value);
            formData.append('template_path', templateInput.value);
            formData.append('class_name', classNameInput.value);

            function callback(response) {
                if (response['action'] === 'success') {
                    console.log('Success!');
                    ajaxPostHtml(existingTilesData, [], renderExistingTiles);
                } else {
                    console.log('Error!');
                }
            }

            spinner.classList.remove('hidden');

            ajaxPostJson(formData, inputArr, callback);
        });
    }
});