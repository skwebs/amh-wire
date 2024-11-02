<div wire:ignore>

    @php
        $ratio = 4 / 5;
        $scale = 1.5;
        $width = 200 * $scale;
        $height = $width / $ratio;
    @endphp



    <div class="bg-gray-200 rounded-md p-5 max-w-80">

    </div>


    <input type="file" id="input">

    <div class="bg-green-600" style="width: {{ $width }}px; height:{{ $height }}px">
        <img id="image" src="" class="max-w-full" alt="">
    </div>

    <button id="crop">Crop & Upload</button>

    <div style="width: {{ $width }}px; height: {{ $height }}px" class="bg-green-600">
        <img id="avatar" src="" class="max-w-full" alt="">
    </div>


    {{-- <button id="cropButton">Crop & Upload</button> --}}

    <script>
        let cropper;
        const image = document.getElementById('image');
        const input = document.getElementById('input');
        const avatar = document.getElementById('avatar');

        let mimeType = 'image/jpeg'; // Default MIME type

        input.addEventListener('change', function(e) {
            let files = e.target.files;
            if (files && files.length > 0) {
                const file = files[0];
                mimeType = file.type; // Capture the file's MIME type
                const url = URL.createObjectURL(file);
                image.src = url;
                initCropper();
            }
        });

        function initCropper() {
            if (cropper) {
                cropper.destroy();
            }
            cropper = new Cropper(image, {
                // aspectRatio: 4 / 5,
                // autoCropArea: 1,
                // viewMode: 3

                aspectRatio: 4 / 5,
                dragMode: 'move',
                // preview: '.croppingPreview',
                autoCropArea: 1,
                // restore: !1,
                // modal: !1,
                // highlight: !1,
                cropBoxMovable: !1,
                cropBoxResizable: !1,
                // toggleDragModeOnDblclick: !1,
                viewMode: 3

            });
        }

        document.getElementById('crop').addEventListener('click', function() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({
                    width: {{ $width }},
                    height: {{ $height }}
                });
                avatar.src = canvas.toDataURL();
                // Use the captured MIME type dynamically
                canvas.toBlob(function(blob) {
                    const reader = new FileReader();
                    reader.onloadend = function() {
                        const base64data = reader.result;
                        @this.call('uploadCroppedImage', base64data); // Call Livewire function
                    };
                    reader.readAsDataURL(blob);
                }, mimeType); // Pass dynamic MIME type
            }
        });
    </script>
</div>
