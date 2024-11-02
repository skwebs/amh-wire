<?php

namespace App\Livewire\V1\Customer;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CropCustomerImage extends Component
{
    use WithFileUploads;

    public $image;
    public $storedImage;
    public $storedImageUrl;


    public function uploadCroppedImage($base64Image)
    {
        // Extract MIME type from the base64 string
        $mimeType = explode(';', explode(':', $base64Image)[1])[0]; // Get the MIME type
        $extension = '';

        // Determine the file extension based on MIME type
        switch ($mimeType) {
            case 'image/jpeg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
            case 'image/gif':
                $extension = 'gif';
                break;
            // Add other formats as needed
            default:
                throw new \Exception('Unsupported image type');
        }

        // Strip out the base64 header
        $image = str_replace('data:' . $mimeType . ';base64,', '', $base64Image);
        $image = str_replace(' ', '+', $image); // Replace spaces with plus signs

        // Create a unique name for the image
        $imageName = time() . '.' . $extension; // Use the extracted extension

        // Store the image in public storage
        Storage::disk('public')->put($imageName, base64_decode($image)); // Save the image

        // Store the URL for the uploaded image for later retrieval
        $this->storedImageUrl = Storage::url($imageName); // Get the public URL of the stored image


         // Store the path for later use
         $this->storedImage = $imageName;
        $this->dispatch('imageUploaded', $imageName);
    }



    public function uploadCroppedImage2($base64data)
    {
        // Decode the base64 data and store the image
        $this->image = $base64data;

        // Generate a filename and save the image
        $filename = 'images/cropped_' . time() . '.png';
        Storage::disk('public')->put($filename, file_get_contents($base64data));

        // Store the path for later use
        $this->storedImage = $filename;

        // Optionally, you can emit an event to notify Alpine
        $this->dispatch('imageUploaded', $filename);
    }

    public function render()
    {
        return view('livewire.v1.customer.crop-customer-image');
    }
}



