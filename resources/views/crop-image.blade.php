<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <style>
        .frame {
            width: 300px;
            height: 300px;
            margin-right: 20px;
            border: 1px solid #ccc;
            padding: 2px;
            margin-bottom: 20px;
            border-radius: 5px;
            position: relative;
        }

        .image-box {
            display: flex;
            float: left;
        }

        .frame img {
            width: 100%;
        }

        .cropper-container {
            margin-bottom: 20px;
        }

        #imageCropperContainer {
            position: relative;
            width: 300px;
            /* Adjust size as needed */
            height: 300px;
            /* Adjust size as needed */
            border: 1px solid #ccc;
            overflow: hidden;
        }

        .frame1 .image-wrapper {
            position: absolute;
            width: 116px;
            top: 11px;
            left: 15px;
            z-index: -1;
        }

        .frame2 .image-wrapper {
            position: absolute;
            width: 270px;
            top: 30px;
            left: 17px;
            z-index: -1;
        }

        #croppedImage1,
        #croppedImage2 {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <form id="imageForm" action="/save-image" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="image-box">
                <div class="frame frame1">
                    <img id="imageFrame1" src="/uploads/frames/Atendee-kit-LinkedIn-landscape.png" alt="Frame 1">
                    <div class="image-wrapper">
                        <img id="croppedImage1" src="" alt="Cropped Image 1">
                    </div>
                </div>
                <div class="frame frame2">
                    <img id="imageFrame2" src="/uploads/frames/Attendee-Kit-frame-Instagarm-post.png" alt="Frame 2">
                    <div class="image-wrapper">
                        <img id="croppedImage2" src="" alt="Cropped Image 2">
                    </div>
                </div>
            </div>
            <div class="cropper-container">
                <div id="imageCropperContainer">
                    <img id="imageToCrop" src="" alt="Image to Crop">
                </div>
                <button class="text-white bg-blue-600" id="cropImageButton" type="button">Crop Image</button>
            </div>
        </div>

        <input type="radio" id="frame1" value="Atendee-kit-LinkedIn-landscape" name="selected_frame" checked>Select
        Frame 1<br>
        <input type="radio" id="frame2" value="Attendee-Kit-frame-Instagarm-post" name="selected_frame">Select
        Frame
        2<br>

        <input type="file" id="imageUpload" name="imageUpload">
        <button type="submit" id="saveImage">Save Image</button>
    </form>

    <script>
        let cropper;
        const imageToCrop = document.getElementById('imageToCrop');
        const imageUpload = document.getElementById('imageUpload');
        const croppedImage1 = document.getElementById('croppedImage1');
        const croppedImage2 = document.getElementById('croppedImage2');

        // Handle image upload
        imageUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const reader = new FileReader();

            reader.onload = function(event) {
                imageToCrop.src = event.target.result;

                // Destroy old cropper instance if it exists
                if (cropper) cropper.destroy();

                // Initialize Cropper.js
                cropper = new Cropper(imageToCrop, {
                    aspectRatio: 1,
                    viewMode: 1,
                    movable: true,
                    zoomable: true,
                    scalable: true,
                    rotatable: false,
                });
            };

            reader.readAsDataURL(file);
        });

        // Crop image and place into frames
        document.getElementById('cropImageButton').addEventListener('click', function() {
            if (!cropper) return;

            const croppedCanvas = cropper.getCroppedCanvas();
            const croppedDataURL = croppedCanvas.toDataURL();

            croppedImage1.src = croppedDataURL;
            croppedImage2.src = croppedDataURL;
        });

        // Save cropped image on form submission
        document.getElementById('saveImage').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission

            const form = document.getElementById('imageForm');
            if (!cropper) return;

            const canvas = cropper.getCroppedCanvas();
            canvas.toBlob(function(blob) {
                const formData = new FormData(form);
                formData.append('cropped_image', blob);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Image saved:', data.path);
                    });
            });
        });
    </script>
</body>

</html>
