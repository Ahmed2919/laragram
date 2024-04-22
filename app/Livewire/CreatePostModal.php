<?php

namespace App\Livewire;

use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class CreatePostModal extends ModalComponent
{
    use WithFileUploads;

    //#[Validate('image|max:1024')] // 1MB Max
    public $image;
    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '3xl';
    }

    public function render()
    {
        return view('livewire.create-post-modal');
    }

    public function save_temp()
    {
        $image = $this->image->store('temp', 'public');
        $this->dispatch('openModal', 'felters-modal', ['image' => $image]);
    }
}
