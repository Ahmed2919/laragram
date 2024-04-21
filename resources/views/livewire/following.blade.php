<div>
    <li class="flex flex-col md:flex-row text-center ">
        <div class=" font-bold md:font-normal mr-2">
            {{$this->count}}
        </div>
        <button class='text-neutral-500 md:text-black' onclick="Livewire.dispatch('openModal', { component: 'followigmodal', arguments: { userId: {{ $this->userId }} }})">
            {{  __('Following') }}
        </button>
    </li>
</div>
