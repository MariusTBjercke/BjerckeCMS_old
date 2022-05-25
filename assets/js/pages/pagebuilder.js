import {DOMReady} from "@assets/js/shared/domready";
import {Sortable} from 'sortablejs';
import {ajaxPostJson, renderTile} from "../functions/ajax";

DOMReady(() => {
    const element = document.querySelector('.pagebuilder');

    if (element) {
        const builder = element.querySelector('.pagebuilder__builder');

        // Render page builder
        renderTile(12, builder, builderScript);

        function builderScript() {
            const tileGrid = element.querySelector('.pagebuilder__form-tile-grid');
            const form = element.querySelector('.pagebuilder__form');
            const submit = element.querySelector('#submit');
            const pageId = form.getAttribute('data-page-id');
            const removeBtns = element.querySelectorAll('.pagebuilder__remove-btn');
            let tempOrder = getTileOrder();

            function emptyCheck() {
                // Check if tile grid has any children
                if (tileGrid.children.length <= 0) {
                    const emptyMessage = document.createElement('div');
                    emptyMessage.classList.add('pagebuilder__empty-message');
                    emptyMessage.innerHTML = '<p>You have not added any tiles yet. Start by dragging a tile here from the toolbox underneath.</p>';
                    tileGrid.appendChild(emptyMessage);
                    tempOrder = [];
                } else {
                    // If tile grid has any children with the empty class, remove it
                    if (tileGrid.querySelector('.pagebuilder__empty-message')) {
                        tileGrid.removeChild(tileGrid.querySelector('.pagebuilder__empty-message'));
                    }
                }
            }

            emptyCheck();

            removeBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    removeTile(btn);
                });
            });

            function getTileOrder() {
                const tempArray = [];
                const childrenArray = Array.from(tileGrid.children);
                childrenArray.forEach((child) => {
                    tempArray.push(child.getAttribute('data-tile-id'));
                });

                return tempArray;
            }

            function removeTile(btn) {
                btn.parentNode.parentNode.remove();

                emptyCheck();

                // Update tile order
                tempOrder = getTileOrder();
            }

            function dropTile(item) {
                const droppedTileId = item.getAttribute('data-tile-id');

                // Only add buttons if they don't already exist and is dropped in the correct grid
                if (!item.querySelector('.pagebuilder__edit-btns') && !item.parentNode.classList.contains('pagebuilder__form-toolbox-list')) {
                    // Add trash and edit icon
                    const btnsParent = document.createElement('div');
                    btnsParent.classList.add('pagebuilder__edit-btns');

                    const removeDiv = document.createElement('div');
                    removeDiv.classList.add('pagebuilder__remove-btn');

                    const trashIcon = document.createElement('i');
                    trashIcon.setAttribute('class', 'bi bi-x-circle-fill');
                    removeDiv.appendChild(trashIcon);

                    const editDiv = document.createElement('div');
                    editDiv.classList.add('pagebuilder__edit-btn');
                    editDiv.setAttribute('data-tile-id', droppedTileId);
                    const editIcon = document.createElement('i');
                    editIcon.setAttribute('class', 'bi bi-pencil-square');
                    editDiv.appendChild(editIcon);

                    btnsParent.appendChild(editDiv);
                    btnsParent.appendChild(removeDiv);

                    item.appendChild(btnsParent);

                    removeDiv.addEventListener('click', (e) => {
                        removeTile(removeDiv);
                    });
                }

                emptyCheck();

                // Update tile order
                tempOrder = getTileOrder();

                // Add edit functionality
                editTiles();
            }

            const sortableTiles = new Sortable(tileGrid, {
                group: {
                    name: 'pagebuilder',
                    pull: false,
                },
                animation: 150,
                onEnd: (e) => {
                    dropTile(e.item);
                },
            });

            const toolboxList = form.querySelector('.pagebuilder__form-toolbox-list');

            const sortableToolbox = new Sortable(toolboxList, {
                group: {
                    name: 'pagebuilder',
                    pull: 'clone',
                },
                sort: false,
                animation: 150,
                onEnd: (e) => {
                    dropTile(e.item);
                },
            });

            submit.addEventListener('click', (e) => {
                e.preventDefault();
                const formData = new FormData();
                formData.append('action', 'pagebuilder_save_page');
                formData.append('page_id', pageId);
                formData.append('order', tempOrder);

                ajaxPostJson(formData, [], (response) => {
                    if (response['action'] === 'success') {
                        const successAlert = document.createElement('div');
                        successAlert.classList.add('alert', 'alert-success');
                        successAlert.setAttribute('role', 'alert');
                        successAlert.style.animation = 'fadeOut 0.6s ease-in-out 2.5s forwards';
                        successAlert.innerHTML = 'Page saved!';

                        tileGrid.prepend(successAlert);
                        setTimeout(() => {
                            successAlert.remove();
                        }, 3000);
                    } else {
                        const errorAlert = document.createElement('div');
                        errorAlert.classList.add('alert', 'alert-danger');
                        errorAlert.setAttribute('role', 'alert');
                        errorAlert.innerHTML = 'Error: Something went wrong!';

                        tileGrid.prepend(errorAlert);
                        setTimeout(() => {
                            errorAlert.remove();
                        }, 6000);
                    }
                });
            });

            /**
             * Change page modal.
             */
            const changePageBtn = element.querySelector('.pagebuilder__form-title span');
            const closeModalBtn = element.querySelector('.pagebuilder__modal-close');
            const modal = element.querySelector('#modal');

            changePageBtn.addEventListener('click', (e) => {
                modal.showModal();
            });

            closeModalBtn.addEventListener('click', (e) => {
                modal.close();
            });

            editTiles();

            function editTiles() {
                /**
                 * Edit tile modal.
                 */
                const editTileBtns = element.querySelectorAll('.pagebuilder__edit-btn');
                const editTileDiv = element.querySelector('.pagebuilder__edit-tile-content');
                const editModal = element.querySelector('#modal-edit');
                let tileToEditId;

                editTileBtns.forEach((btn) => {
                    // If the button has no event listener, add one.
                    if (btn.getAttribute('listener') !== 'true') {
                        btn.addEventListener('click', (e) => {
                            btn.setAttribute('listener', 'true');
                            tileToEditId = btn.getAttribute('data-tile-id');
                            renderTile(16, editTileDiv, editTileScript, {
                                tileId: tileToEditId,
                            });
                            editModal.showModal();
                        });
                    }
                });

                function editTileScript() {
                    const closeEditModalBtn = element.querySelector('#pagebuilder__modal-edit-close');
                    const editSubmit = element.querySelector('#edit-submit');
                    const articleId = element.querySelector('#article-id');

                    const editFormData = new FormData();
                    editFormData.append('action', 'pagebuilder_save_tile');
                    editFormData.append('tile_id', tileToEditId);

                    editSubmit.addEventListener('click', (e) => {
                        editFormData.append('article_id', articleId.value);

                        ajaxPostJson(editFormData, [], (response) => {
                            if (response['action'] === 'success') {
                                editModal.close();

                                const successAlert = document.createElement('div');
                                successAlert.classList.add('alert', 'alert-success');
                                successAlert.setAttribute('role', 'alert');
                                successAlert.style.animation = 'fadeOut 0.6s ease-in-out 2.5s forwards';
                                successAlert.innerHTML = 'Tile saved!';
                                tileGrid.prepend(successAlert);
                                setTimeout(() => {
                                    successAlert.remove();
                                }, 3000);
                            }
                        });
                    });

                    closeEditModalBtn.addEventListener('click', (e) => {
                        editModal.close();
                    });
                }
            }
        }
    }
});