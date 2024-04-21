<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;


class Following extends Component
{
    public $userId;
    protected $user;
    // protected $listenrs = ['unfollowUser' => 'getCountProperty'];
    #[On('unfollowUser')]

    public function getCountProperty()
    {
        $this->user = User::find($this->userId);
        return $this->user->following()->wherePivot('confirmed', true)->count();
    }

    public function render()
    {
        return view('livewire.following');
    }
}
