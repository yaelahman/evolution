<!DOCTYPE html>
<html lang="en">

<?php

include './config/base.php';
include './layouts/header.php';

?>

<body>
    <input type="hidden" name="ip_address">
    <main class="h-full">
        <?php
        include './layouts/nav.php';
        ?>
        <div class="grid grid-cols-8 h-full">
            <div class="col-span-2 bg-gray h-full px-6 py-12 lg:block hidden">
                <?php
                include './layouts/nav2.php';
                ?>
            </div>
            <?php

            $step = $_GET['step'] ?? 1;
            if ($step >= 1 && $step <= 4) {
                include './pages/step' . $step . '.php';
            }

            ?>
        </div>
    </main>

    <script>
        let ipAddress = null
        let uploadedFiles = []
        let removedFiles = []
        let index = 0

        if (document.getElementById('btnUploadStepOne'))
            document.getElementById('btnUploadStepOne').addEventListener('click', function() {
                document.getElementById('uploadStepOne').click();
            });

        function imagesTemplate(file, defaultUrl = null) {
            console.log(defaultUrl)
            const fileURL = defaultUrl ?? URL.createObjectURL(file);

            return `
                    <div id="uploadedFile-${index}" class="bg-gray flex justify-between p-2 rounded-xl w-full">
                        <div class="flex gap-2">
                            <div>
                                <img src="${file.type.startsWith('image/') || defaultUrl != null ? fileURL : './assets/images/sample.png'}" alt="" class="w-12 h-12 object-cover rounded">
                            </div>
                            <div class="text-start">
                                <h6 class="text-secondary">${file.name}</h6>
                                <small class="text-muted">${(file.size / 1024).toFixed(2)} KB</small>
                            </div>
                        </div>
                        <button class="text-muted mr-4" onclick="deleteUploadedFile(${index})" data-index="${index}" >
                            <i class="far fa-trash-can"></i>
                        </button>
                    </div>
                `
        }

        if (document.getElementById('uploadStepOne'))
            document.getElementById('uploadStepOne').addEventListener('change', function(event) {
                const files = event.target.files;
                const listUploaded = document.getElementById('listUploadedStepOne');

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    const validExtensions = ['png', 'jpeg', 'jpg', 'pdf'];

                    if (validExtensions.includes(fileExtension)) {
                        const listItem = document.createElement('div');

                        // Create a URL for the file to use as a thumbnail
                        listItem.innerHTML = imagesTemplate(file);
                        listUploaded.appendChild(listItem);
                        uploadedFiles[index] = file;
                        index++;
                    } else {
                        alert("Invalid file format. Please upload only PNG, JPEG, or PDF files.");
                    }
                }
            });

        function deleteUploadedFile(index) {
            const listItem = document.getElementById('uploadedFile-' + index);
            if (listItem) {
                listItem.remove();
            }

            const file = uploadedFiles.filter((row, i) => i == index)
            console.log(file)
            if (file[0] && file[0].id) {
                removedFiles.push(file[0].id)
            }

            uploadedFiles = uploadedFiles.filter((row, i) => i != index)
        }

        function updateProgress(percent) {
            const progressBar = document.getElementById('progressBar');
            const progressPercent = document.getElementById('progressPercent');
            progressBar.style.width = percent + '%';
            progressPercent.textContent = percent + '%';
        }

        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData();
            const files = Object?.values(uploadedFiles);
            const stage = document.querySelector('input[name="stage"]')?.value;
            const scope_of_work = document.querySelector('textarea[name="scope_of_work"]')?.value;
            const floor_plan = document.querySelector('input[name="floor_plan"]');
            const trust = document.querySelector('input[name="trust"]');
            const name = document.querySelector('input[name="name"]')?.value;
            const phone = document.querySelector('input[name="phone"]')?.value;
            const email = document.querySelector('input[name="email"]')?.value;
            formData.append('stage', stage);
            formData.append('ip_address', ipAddress)

            if (stage == 1) {
                if (!scope_of_work) {
                    alert("Please fill Scope of Work")
                    return false;
                }
                formData.append('scope_of_work', scope_of_work)
            }

            if (stage == 2) {
                formData.append('floor_plan', floor_plan.checked ? 1 : 0);
            }

            if (stage == 3) {
                formData.append('trust', trust.checked ? 1 : 0);
            }

            if (stage == 4) {
                formData.append('name', name)
                formData.append('phone', phone)
                formData.append('email', email)
            }

            // Append files to the FormData object
            files.forEach(file => {
                formData.append('files[]', file);
            });

            formData.append('removed_files', JSON.stringify(removedFiles))

            // Add any additional form data here if needed
            // formData.append('scope_of_work', document.querySelector('textarea')?.value);

            // Send the form data using fetch
            fetch("<?= BASE_URL ?>app/controller.php", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const currentStage = "<?= $step ?>"
                    alert(data.message); // Send alert with the response from the server
                    if (data.status && parseInt(currentStage) < 4) {
                        window.location.href = data.nextStage
                    }
                })
                .catch(error => {
                    console.error('Error:', error); // Handle any errors
                });
        });


        function getData() {
            const listUploaded = document.getElementById('listUploadedStepOne');
            fetch(`<?= BASE_URL ?>app/controller.php?ip_address=${ipAddress}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        const result = data[0]
                        const currentStage = "<?= $step ?>"
                        if (currentStage > 0) updateProgress(25)
                        if (currentStage > 1) updateProgress(50)
                        if (currentStage > 2) updateProgress(75)
                        if (currentStage > 3) updateProgress(99)

                        if (document.querySelector('textarea[name="scope_of_work"]'))
                            document.querySelector('textarea[name="scope_of_work"]').value = result.scope_of_work

                        if (document.querySelector('input[name="floor_plan"]'))
                            if (result.floor_plan == 1) {
                                document.querySelector('input[name="floor_plan"]').checked = result.floor_plan == 1;
                            }

                        if (document.querySelector('input[name="trust"]'))
                            if (result.trust == 1) {
                                document.querySelector('input[name="trust"]').checked = result.trust == 1;
                            }


                        if (document.querySelector('input[name="name"]'))
                            document.querySelector('input[name="name"]').value = result.name

                        if (document.querySelector('input[name="email"]'))
                            document.querySelector('input[name="email"]').value = result.email

                        if (document.querySelector('input[name="phone"]'))
                            document.querySelector('input[name="phone"]').value = result.phone

                        result?.files?.map((row) => {

                            if (parseInt(currentStage) === row.stage) {
                                const listItem = document.createElement('div');
                                uploadedFiles.push({
                                    id: row.id
                                })

                                // Create a URL for the file to use as a thumbnail

                                listItem.innerHTML = imagesTemplate({
                                    name: row.file,
                                    type: 'images/',
                                    size: 1000
                                }, "<?= BASE_URL ?>app/uploads/" + row.file)

                                listUploaded.appendChild(listItem);
                            }
                        })


                    } else {
                        console.log('No data found for this IP address.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error); // Handle any errors
                });
        }


        fetch('https://api.ipify.org?format=json')
            .then(response => response.json())
            .then(data => {
                const userIp = data.ip; // Get the user's IP address
                ipAddress = userIp
                getData()
            })
            .catch(error => {
                console.error('Error fetching IP:', error); // Handle any errors
            });
    </script>
</body>

</html>