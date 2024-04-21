<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Post extends Component
{
    public $post;

    public function render()
    {
        return view('livewire.post');
    }
}
