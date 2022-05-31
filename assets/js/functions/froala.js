import FroalaEditor from "froala-editor";
import 'froala-editor/js/froala_editor.pkgd.min.js';
import 'froala-editor/js/plugins.pkgd.min.js';

function initFroala(contentInput) {
    return new FroalaEditor(contentInput, {
        theme: 'gray',
        height: 300,
        toolbarButtons: {
            moreText: {
                // List of buttons used in the  group.
                buttons: ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', 'textColor', 'backgroundColor', 'inlineClass', 'inlineStyle', 'clearFormatting'],

                // Alignment of the group in the toolbar.
                align: 'left',

                // By default, 3 buttons are shown in the main toolbar. The rest of them are available when using the more button.
                buttonsVisible: 3
            },


            moreParagraph: {
                buttons: ['alignLeft', 'alignCenter', 'formatOLSimple', 'alignRight', 'alignJustify', 'formatOL', 'formatUL', 'paragraphFormat', 'paragraphStyle', 'lineHeight', 'outdent', 'indent', 'quote'],
                align: 'left',
                buttonsVisible: 3
            },

            moreRich: {
                buttons: ['insertLink', 'insertImage', 'insertVideo', 'insertTable', 'emoticons', 'fontAwesome', 'specialCharacters', 'embedly', 'insertFile', 'insertHR'],
                align: 'left',
                buttonsVisible: 3
            },

            moreMisc: {
                buttons: ['undo', 'redo', 'fullscreen', 'print', 'getPDF', 'spellChecker', 'selectAll', 'html', 'help'],
                align: 'right',
                buttonsVisible: 2
            }
        },
        imageUploadURL: '/xmlhttprequest.php',
        imageUploadParams: {
            'action': 'upload_image',
        },
        imageManagerLoadURL: '/xmlhttprequest.php',
        imageManagerLoadParams: {
            'action': 'load_images',
        },
        imageManagerDeleteURL: '/xmlhttprequest.php',
        imageManagerDeleteParams: {
            'action': 'delete_image',
        },
    });
}

export {initFroala};