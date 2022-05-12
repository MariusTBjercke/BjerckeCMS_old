up.compiler('.profile', (element) => {
    /**
     * File upload.
     */
    const submit = element.querySelector('#file-submit');

    submit.addEventListener('click', uploadFile);

    async function uploadFile() {
        const fileInput = element.querySelector('#image-file');
        const file = fileInput.files[0];

        const formData = new FormData();
        formData.append("file", file);
        formData.append("action", "profile_upload");

        const xhttp = new XMLHttpRequest();

        xhttp.open("POST", "xmlhttprequest.php", true);

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                const response = this.responseText;

                switch (response) {
                    case '1':
                        console.log('File uploaded successfully.');
                        break;
                    case '-1':
                        console.log('Error: File is not an image.');
                        break;
                    case '-2':
                        console.log('Error: File is too large.');
                        break;
                    case '-3':
                        console.log('Error: File upload error.');
                        break;
                    default:
                        console.log('Error: Unknown error.');
                        break;
                }
            }

            // Clear the file input.
            fileInput.value = '';
        };

        xhttp.send(formData);
    }
});