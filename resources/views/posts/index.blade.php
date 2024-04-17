<x-app-layout>
    <div class="flex flex-row max-w-3xl gap-8 mx-auto">
        {{-- Left Side --}}
        <div class="w-[30rem] mx-auto lg:w-[95rem]">
            @forelse ($posts as $post)
                <x-post :post="$post"/>

            @empty
                <div class="max-w-2xl gap-8 mx-auto">
                    {{ __('Start Following Your Friends and Enjoy.')}}
                </div>
            @endforelse
        </div>
        {{-- Right Side --}}
        <div class="hidden w-[60rem] lg:flex lg:flex-col pt-4">
            <div class="flex flex-row text-sm">
                <div class="mr-5">
                    <img src="{{ auth()->user()->image}}" class="border boreder-gray-500 w-12 h-12 mr-3 rounded-full" />
                </div>
                <div class="flex flex-col">
                    <a href="/{{ auth()->user()->username }}" class="font-bold">
                        {{auth()->user()->username }}
                    </a>
                    <div class="text-gray-500 text-sm"> {{auth()->user()->name }}</div>
                </div>
            </div>

            <div class="mt-5">
                <h3 class="text-gray-500 font-bold">{{__('Suggession for you')}}</h3>
                <ul>
                    @foreach ($suggested_user as $suggested_user)
                        <li class="flex flex-row my-5 text-sm justify-items-center">
                            <div class="mr-5">
                                <a href="/{{$suggested_user->username}}">
                                    <img src="{{$suggested_user->image}}" class="rounded-full h-9 w-9 border border-gray-500"/>
                                </a>
                            </div>

                            <div class="flex flex-col grow">
                                <a href="/{{$suggested_user->username}}" class="font-bold">{{$suggested_user->username}}</a>
                                <div class="text-gray-500 text-sm">{{$suggested_user->name}}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>