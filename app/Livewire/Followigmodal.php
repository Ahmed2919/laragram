<?php

namespace App\Livewire;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class Followigmodal extends ModalComponent
{
    public $userId;
    protected $user;


    public function getFollowingListProperty()
    {
        $this->user = User::find($this->userId);
        return $this->user->following()->wherePivot('confirmed', true)->get();
    }

    public function unfollow($userId)
    {
        $following_user = User::find($userId);
        $this->user = User::find($this->userId);
        $this->user->unfollow($following_user);
        $this->dispatch('unfollowUser');
    }

    public function render()
    {
        return view('livewire.followigmodal');
    }
}
