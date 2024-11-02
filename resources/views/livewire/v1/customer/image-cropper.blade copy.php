<div x-data="imageCropper" class="p-4">
    @if (session()->has('message'))
        <div>{{ session('message') }}</div>
    @endif

    <!-- Image Upload Input -->
    <input type="file" wire:model="image" accept="image/*" @change="initializeCropper" id="imageInput">

    <!-- Image Cropper Preview -->
    @if ($image)
        <div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js" integrity="sha512-JyCZjCOZoyeQZSd5+YEAcFgz2fowJ1F1hyJOXgtKu4llIa0KneLcidn5bwfutiehUTiOuK87A986BZJMko0eWQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('imageCropper', () => ({
                cropper: null,

                initializeCropper() {
                    if (this.cropper) {
                        this.cropper.destroy();
                    }
                    // Initialize CropperJS
                    this.cropper = new Cropper(this.$refs.image, {
                        aspectRatio: 1,
                        viewMode: 1,
                    });
                },

                cropImage() {
                    const canvas = this.cropper.getCroppedCanvas();
                    const croppedImageData = canvas.toDataURL("image/png");

                    // Send the cropped image data to Livewire
                    @this.set('croppedImage', croppedImageData);
                }
            }));
        });
    </script>
</div>
