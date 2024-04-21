<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class Follower extends Component
{
    public $userId;
    protected $user;
    #[On('unfollowUser')]

    public function getCountProperty()
    {
        $this->user = User::find($this->userId);
        return $this->user->followers()->wherePivot('confirmed', true)->count();
    }

    public function render()
    {
        return view('livewire.follower');
    }
}
