<?php

namespace App\Livewire\V1\Customer;

use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class UpdateCustomerPhoto extends Component
{
    use WithFileUploads;
    public $customer;

    public $photo;

    public $image;
    public $croppedImage;

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
    }




    public function save()
    {
        $image = $this->photo->getClientOriginalName();
        $path = $this->photo->storeAs('image', $image, 'public');
        // $path =     $this->photo->storeAs(path: 'public', name: $image);
// dd([$image,$path]);
        // dd($this->photo);
        $r = $this->customer->update([
            'image' => $image,
            'image_path'=>$path
        ]);

        // dd($r);


    }

    #[Title("Update Customer Photo")]
    public function render()
    {
        // return view('livewire.v1.customer.update-customer-photo');
        return view('livewire.v1.customer.image-cropper');
    }
}
