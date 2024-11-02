<div x-data="imageCropper()" wire:ignore>
    @php
        $ratio = 4 / 5;
        $scale = 1.5;
        $width = 200 * $scale;
        $height = $width / $ratio;
    @endphp

    <input type="file" id="input" @change="onFileChange">

    <div class="bg-green-600" :style="{ width: `${width}px`, height: `${height}px` }">
        <img x-ref="image" src="" class="max-w-full" alt="">
    </div>

    <button @click.prevent="cropImage">Crop & Upload</button>

    <div :style="{ width: `${width}px`, height: `${height}px` }" class="bg-green-600">
        <img x-ref="avatar" src="" class="max-w-full" alt="">
    </div>

    <!-- Display the stored image if it exists -->
    @if ($storedImage)
        <div class="bg-gray-200 mt-4">
            <h3>Stored Image:</h3>
            <img src="{{ Storage::url($storedImage) }}" alt="Uploaded Image" class="max-w-full">
        </div>
    @endif

        <script>
            function imageCropper() {
                return {
                    cropper: null,
                    width: @js($width),
                    height: @js($height),
                    mimeType: 'image/jpeg',
                    onFileChange(event) {
                        let files = event.target.files;
                        if (files && files.length > 0) {
                            const file = files[0];
                            this.mimeType = file.type;
                            const url = URL.createObjectURL(file);
                            this.$refs.image.src = url;
                            this.initCropper();
                        }
                    },
                    initCropper() {
                        if (this.cropper) {
                            this.cropper.destroy();
                        }
                        this.cropper = new Cropper(this.$refs.image, {
                            aspectRatio: this.width / this.height,
                            dragMode: 'move',
                            autoCropArea: 1,
                            cropBoxMovable: false,
                            cropBoxResizable: false,
                            viewMode: 3
                        });
                    },
                    cropImage() {
                        if (this.cropper) {
                            const canvas = this.cropper.getCroppedCanvas({
                                width: this.width,
                                height: this.height
                            });
                            this.$refs.avatar.src = canvas.toDataURL();
                            canvas.toBlob((blob) => {
                                const reader = new FileReader();
                                reader.onloadend = () => {
                                    const base64data = reader.result;
                                    @this.call('uploadCroppedImage', base64data);
                                };
                                reader.readAsDataURL(blob);
                            }, this.mimeType);
                        }
                    }
                }
            }
        </script>
</div>
