<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\On;

class PostList extends Component
{
    protected $listeners = ['toggleFollow' => '$refresh'];

    public function getPostsProperty()
    {
        $ids = auth()->user()->following()->wherePivot('confirmed', true)->get()->pluck('id');
        return Post::whereIn('user_id', $ids)->latest()->get();
        // return $this->posts;
    }
    public function render()
    {
        return view('livewire.post-list');
    }
}
