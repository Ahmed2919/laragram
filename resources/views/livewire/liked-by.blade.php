<div class="px-5 mb-4">
    @if ($this->likes > 0)
        {{__('Liked by')}}
        <strong>
            <a href="/{{$this->FirstUsername}}">{{$this->FirstUsername}}</a>
        </strong>
    @endif
    @if ($this->likes > 1)
        {{__('and')}} <strong>{{__('Others')}}</strong>
    @endif

</div>
