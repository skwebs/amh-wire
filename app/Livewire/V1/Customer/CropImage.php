<?php

namespace App\Livewire\V1\Customer;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CropImage extends Component
{
    use WithFileUploads;

    public $croppedImage; // For storing the cropped image data
    public $storedImageUrl; // For storing the URL of the stored image

    public function uploadCroppedImage($base64Image)
    {
        // Process and save the image
        $image = str_replace('data:image/jpeg;base64,', '', $base64Image);
        $image = str_replace(' ', '+', $image);
        $imageName = time() . '.jpeg'; // Unique image name
        Storage::disk('public')->put($imageName, base64_decode($image)); // Save the image

        // Store the URL for later use
        $this->storedImageUrl = Storage::url($imageName); // Get the public URL of the stored image
    }

    public function render()
    {
        return view('livewire.v1.customer.crop-image');
    }
}

// use Livewire\Component;
// use Livewire\WithFileUploads;

// class ImageCropper extends Component
// {


//     public function render()
//     {
//         return view('livewire.image-cropper');
//     }
// }
