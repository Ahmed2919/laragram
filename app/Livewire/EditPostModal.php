<?php

namespace App\Livewire;

use App\Models\Post;
use LivewireUI\Modal\ModalComponent;

class EditPostModal extends ModalComponent
{
    public Post $post;
    public $description;

    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->description = $post->description;
    }
    public function update()
    {
        $this->validate([
            'description' => 'required',
        ]);

        $this->post->update([
            'description' => $this->description
        ]);

        return redirect(route('post.show', ['post' => $this->post->slug]));
    }
    public function render()
    {
        return view('livewire.edit-post-modal');
    }
}
