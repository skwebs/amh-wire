<div x-data="imageCropper" class="p-4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" integrity="sha512-UtLOu9C7NuThQhuXXrGwx9Jb/z9zPQJctuAgNUBK3Z6kkSYT9wJ+2+dh6klS+TDBCV9kNPBbAxbVD+vCcfGPaA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif

    <!-- Image Upload Input -->
    <input type="file" wire:model="image" accept="image/*" @change="handleImageUpload" id="imageInput">

    <!-- Image Cropper Preview -->
    @if ($image)
        <div x-show="imageLoaded">
            <img x-ref="image" id="imageToCrop" src="{{ $image->temporaryUrl() }}" style="max-width: 100%;"/>
        </div>
        <button @click="cropImage">Crop Image</button>
    @endif

    <!-- Cropped Image Preview -->
    @if ($croppedImage)
        <div>
            <img src="{{ $croppedImage }}" style="max-width: 100%;"/>
        </div>
        <button wire:click="saveCroppedImage">Save Cropped Image</button>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageCropper', () => ({
                cropper: null,
                imageLoaded: false,

                handleImageUpload() {
                    this.imageLoaded = true;  // Set flag to true when image is ready
                },

                initializeCropper() {
                    // Destroy any existing cropper before initializing
                    if (this.cropper) {
                        this.cropper.destroy();
                    }
                    // Initialize CropperJS on the image when loaded
                    this.cropper = new Cropper(this.$refs.image, {
                        aspectRatio: 1,
                        viewMode: 1,
                    });
                },

                cropImage() {
                    if (this.cropper) {
                        const canvas = this.cropper.getCroppedCanvas();
                        const croppedImageData = canvas.toDataURL("image/png");

                        // Send the cropped image data to Livewire
                        @this.set('croppedImage', croppedImageData);
                    }
                }
            }));
        });
    </script>
</div>
