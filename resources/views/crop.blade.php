<div>
    <input type="file" id="fileInput">
    <input type="file" id="input">
    <img id="image" src="" style="max-width: 100%" alt="">
    <button id="cropButton">Crop & Upload</button>

    <script>
        let cropper;
        const image = document.getElementById('image');
        const input = document.getElementById('input');

        input.addEventListener('change', function(e) {
            let files = e.target.files;
            const done = function(url) {
                input.value = '';
                image.src = url;

            };
            let reader;
            let file;
            let url;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });




        // document.getElementById('fileInput').addEventListener('change', function(event) {
        //     const file = event.target.files[0];
        //     const url = URL.createObjectURL(file);
        //     const image = document.getElementById('image');
        //     image.onload = () => {
        //         if (cropper) {
        //             cropper.destroy();
        //         }
        //         cropper = new Cropper(image, {
        //             aspectRatio: 1
        //         });
        //     }
        // });
        // document.getElementById('cropButton').addEventListener('click', function() {
        //     const canvas = cropper.getCropperCanvas();
        //     canvas.toBlob(function(blob) {
        //         console.log(blob)
        //     })
        // })
    </script>
</div>
