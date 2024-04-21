<?php

namespace App\Livewire;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class FollowerModal extends ModalComponent
{
    public $userId;
    protected $user;


    public function getFollowerListProperty()
    {
        $this->user = User::find($this->userId);
        return $this->user->followers()->wherePivot('confirmed', true)->get();
    }

    public function removeFollower($userId)
    {
        $follower = User::find($userId);
        $this->user = User::find($this->userId);
        $follower->unfollow($this->user);
        $this->dispatch('unfollowUser');
    }

    public function render()
    {
        return view('livewire.follower-modal');
    }
}
