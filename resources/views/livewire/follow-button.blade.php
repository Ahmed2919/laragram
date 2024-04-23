<div>
        @if ($this->follw_state === 'Pending')
            <span class="w-30  bg-gray-400 text-white text-sm px-3 py-1 font-bold text-center rounded"> {{__('pending')}}</span>
        @else
            <button  wire:click='toggle_follow' class="{{$this->classes}} w-30 cursor-pointer text-sm px-3 py-1 font-bold text-center rounded">
                {{__($this->follw_state)}}
            </button>
        @endif
        
   
</div>
