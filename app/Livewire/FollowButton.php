<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class FollowButton extends Component
{
    public $post;
    public $userId;
    private $user;
    public $follw_state;
    public $classes;


    public function mount()
    {
        $this->user = User::find($this->userId);
        $this->set_follow_state();
    }

    public function toggle_follow()
    {
        $this->user = User::find($this->userId);
        auth()->user()->toggle_follow($this->user);
        $this->set_follow_state();
        $this->dispatch('toggleFollow');
    }

    public function set_follow_state()
    {
        if (auth()->user()->is_pending($this->user)) {

            return $this->follw_state = "Pending";
        } elseif (auth()->user()->is_following($this->user)) {
            return $this->follw_state = "Unfollow";
        } else {
            return $this->follw_state = "Follow";
        }
        dd($this->follw_state);
    }

    public function render()
    {
        return view('livewire.follow-button');
    }
}
