<div class="max-h-96 flex flex-col">
    <div class="flex w-full items-center border-b border-b-neutral-100  p-2">
        <h1 class="text-lg font-bold text-center pb-2 grow">{{ __('Followers')}}</h1>
        <button wire:click="$dispatch('closeModal')"><i class="bx bx-x text-sm"></i></button>
    </div>
    <ul class="overflow-y-auto">
        @forelse($this->follower_list as $follower)
            <li class="flex flex-row w-full p-3 items-center text-sm" wire:key="user-{{ $follower->id }}">
                <div>
                    <img src="{{ $follower->image }}" class="w-10 h-10 ltr:mr-2 rtl:ml-2 rounded-full border border-neutral-300">
                </div>
                <div class="flex flex-col grow rtl:text-right">
                    <div class="font-bold">
                        <a href="/{{ $follower->username }}">{{ $follower->username }}</a>
                    </div>
                    <div class="text-sm text-neutral-500">
                        {{ $follower->name }}
                    </div>
                </div>
                @if(auth()->user()->id === $this->userId) 
                    <div>
                        <button class="border border-gray-500 px-2 py-1 rounded" wire:click="removeFollower({{ $follower->id }})">{{ __('Remove') }}</button>
                    </div>
                @endauth
            </li>
        @empty
            <li class="w-full p-3 text-center">
                {{ __('There is no data !!.') }}
            </li>
        @endforelse
    </ul>
</div>
