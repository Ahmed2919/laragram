<x-app-layout>
    <div class="grid grid-cols-4 ">
        {{-- User Image --}}
        <div class="px-4 col-span-1 order-1">
            <img src="{{ $user->image }}" alt="{{ $user->username }}' profile picture"
                 class="rounded-full w-20 h-20 object-cover md:w-40 md:h-40 border border-neutral-300">
        </div>

        {{-- Username And Buttons 
        <div class="px-4 col-span-2 md:ml-0 flex flex-col order-2 md:col-span-3">
            <div class="text-3xl mb-3">{{$user->username}}</div>
            @if ($user->id === auth()->id())
                <a href="/{{$user->username}}" class="w-44 border text-sm font-bold py-1 rounded-md border-neutral-300 text-center">
                    {{ __('Edit Profile') }}
                </a>
            @endif
        </div>
--}}
        {{-- Username and buttons --}}
        <div class="px-4 col-span-2 md:ml-0 flex flex-col md:flex-row order-2 md:col-span-3">
            <div class="text-3xl mb-3 ">{{ $user->username }}</div>
                @if ($user->id === auth()->id())
                    <a href="/{{ $user->username }}/edit"
                       class="w-32 h-8 self-start border text-sm font-bold py-1 px-1 rounded-md border-neutral-300 text-center">
                        {{ __('Edit Profile') }}
                    </a>
                @endif

           
        </div>

        {{-- User Bio --}}
        <div class="text-md mt-8 px-4 col-span-3 col-start-1 order-3 md:col-start-2 md:order-4 md:mt-0">
            <p class="font-bold">{{ $user->name }}</p>
            {!! nl2br(e($user->bio)) !!}
        </div> 

         {{-- User stats  --}}
         <div
            class="col-span-4 my-5 py-2 border-y border-y-neutral-200 order-4 md:order-3 md:border-none md:px-4 md:col-start-2">
            <ul class="text-md flex flex-row justify-around md:justify-start md:space-x-10 md:text-xl">
                <li class="flex flex-col md:flex-row text-center ">
                    <div class=" font-bold md:font-normal">
                        {{ $user->posts->count() }}
                    </div>
                    <span class='text-neutral-500 md:text-black'>
                        {{ $user->posts->count() > 1 ? __('posts') : __('post') }}
                    </span>
                </li>
            </ul>
        </div>
    </div>

    {{-- Bottom --}}
    @if ($user->posts()->count() > 0 and ($user->private_account == false or auth()->id() == $user->id))
        <div class="grid grid-cols-3 gap-1 my-5">
            @foreach ($user->posts as $post)
                <a href="/p/{{$post->slug}}" class="aspect-square block w-full">
                    <img src="{{asset('storage/'.$post->image)}}" class="w-full aspect-square object-cover"/>
                </a>
            @endforeach
        </div>
    @else
        <div class="w-full text-center mt-20">
            @if ($user->private_account == true and $user->id != auth()->id())
                {{ __('This Account is Private Follow to see their photos.') }}
            @else
                {{ __('This user does not have any post.') }}
            @endif
        </div>
    @endif
</x-app-layout>