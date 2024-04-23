<div>
    <li class="flex flex-col md:flex-row text-center ">
        <div class="ltr:md:mr-1 rtl:md:ml-1 font-bold md:font-normal">
            {{ $this->count }}
        </div>
        <button class='text-neutral-500 md:text-black' onclick="Livewire.dispatch('openModal', { component: 'follower-modal', arguments: { userId: {{ $this->userId }} }})">
            {{ $this->count > 1 ? __('Followers') : __('Follower') }}
        </button>

    </li>
</div>
