<?php

namespace App\Livewire\V1\Customer;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Crop extends Component
{
    public function render()
    {
        return view('livewire.v1.customer.crop');
    }


    public function uploadCroppedImage($base64Image)
    {
        // Decode the base64 image
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

        // Create a unique filename
        $filename = 'cropped_image_' . uniqid() . '.jpg';

        // Store the image
        Storage::disk('public')->put($filename, $imageData);

        // dd($base64Image);

        // Optionally, return the filename or success message
        session()->flash('message', 'Image uploaded successfully!');
    }

}
