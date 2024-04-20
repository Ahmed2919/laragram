<?php

namespace App\Livewire;

use Livewire\Attributes\On;

use Livewire\Component;

class LikedBy extends Component
{
    public $post;

    //protected $listeners = ['likeToggled' => 'getLikesProperty'];
    #[On('likeToggled')]


    public function getLikesProperty()
    {
        return $this->post->likes()->count();
    }

    public function getFirstUsernameProperty()
    {
        return $this->post->likes()->first()->username;
    }

    public function render()
    {
        return view('livewire.liked-by');
    }
}
