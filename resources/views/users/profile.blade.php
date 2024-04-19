<x-app-layout>
    <div
        class="{{ session('success') ? '' : 'hidden' }} w-50 p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800 absolute right-10 shadow shadow-neutral-200"
        role="alert">
        <span class="font-medium">{{ session('success') }}
    </div>
    <div class="grid grid-cols-4 ">
        {{-- User Image --}}
        <div class="px-4 col-span-1 order-1">
            <img src="{{asset('storage/'.$user->image)  }}" alt="{{ $user->username }}' profile picture"
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
        <div class="px-4 col-span-2 md:ml-0 flex flex-col md:flex-row items-center order-2 md:col-span-3">
            <div class="text-3xl mb-3 ">{{ $user->username }}</div>
                <div class="ml-3 my-12">
                    @auth
                        @if ($user->id === auth()->id())
                            <a href="/{{ $user->username }}/edit"
                            class="w-50 h-8 self-start border text-sm font-bold py-1 px-5 rounded-md border-neutral-300 text-center">
                                {{ __('Edit Profile') }}
                            </a>
                        @elseif(auth()->user()->is_following($user))
                            <a href="/{{$user->username}}/unfollow" class="w-30 bg-blue-500 text-white px-3 py-1 rounded text-center self-start">
                                {{__('UnFollow')}}
                            </a>
                        @elseif(auth()->user()->is_pending($user))
                            <span class="w-30 bg-gray-500 text-white px-3 py-1 rounded text-center self-start">
                                {{__('pending')}}
                            </span>
                        @else
                            <a href="/{{$user->username}}/follow" class="w-30 bg-blue-500 text-white px-3 py-1 rounded text-center self-start">
                                {{__('Follow')}}
                            </a>
                        @endif
                    @endauth
                    
                    @guest
                        <a href="/{{$user->username}}/follow" class="w-30 bg-blue-500 text-white px-3 py-1 rounded text-center self-start">
                            {{__('Follow')}}
                        </a>
                    @endguest
                </div>
           
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
                    <div class=" font-bold md:font-normal mr-2">
                        {{ $user->posts->count() }}
                    </div>
                    <span class='text-neutral-500 md:text-black'>
                        {{ $user->posts->count() > 1 ? __('posts') : __('post') }}
                    </span>
                </li>
                <li class="flex flex-col md:flex-row text-center ">
                    <div class=" font-bold md:font-normal mr-2">
                        {{ $user->followers()->count() }}
                    </div>
                    <span class='text-neutral-500 md:text-black'>
                        {{ $user->followers->count() > 1 ? __('Followers') : __('Follower') }}
                    </span>
                </li>

                <li class="flex flex-col md:flex-row text-center ">
                    <div class=" font-bold md:font-normal mr-2">
                        {{ $user->following()->wherePivot('confirmed' , true)->count() }}
                    </div>
                    <span class='text-neutral-500 md:text-black'>
                        {{  __('Following') }}
                    </span>
                </li>

            </ul>
        </div>
    </div>

    {{-- Bottom --}}
    @if ($user->posts()->count() > 0 and ($user->private_account == false or auth()->id() == $user->id))

  {{--  @if ($user->posts()->count() > 0 and ($user->private_account == false or auth()->id() == $user->id or auth()->user()->is_following($user)))--}}
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