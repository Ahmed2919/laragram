<x-app-layout>
    <div class="h-screen md:flex md:flex-row">

        {{-- Left Side --}}
        <div class="flex h-full items-center overflow-hidden bg-black md:w-7/12">
            <img src="{{asset('storage/'.$post->image)}}" alt="{{$post->description}}" class="max-h-screen object-cover mx-auto"/>
        </div>

        {{-- Right Side --}}
        <div class="flex w-full flex-col bg-white md:w-5/12">

            {{-- Top --}}
            <div class="border-b-2">
                <div class="flex items-center p-5">
                    <img src="{{ $post->owner->getImage() }}" alt="{{ $post->owner->username }}"
                         class="ltr:mr-5 rtl:ml-5 h-10 w-10 rounded-full">
                    <div class="grow">
                        <a href="/{{ $post->owner->username }}" class="font-bold">{{ $post->owner->username }}</a>
                    </div>
                    @can('update', $post)
                        {{-- <a href="{{$post->slug}}/edit"><i class="bx bx-message-square-edit text-xl"></i></a> --}}
                        <button onclick="Livewire.dispatch('openModal', { component: 'edit-post-modal', arguments: { post: {{ $post }} }})">
                            <i class="bx bx-message-square-edit text-xl"></i>
                        </button>
                        <form action="/p/{{ $post->slug }}/delete" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">
                                <i class='bx bx-message-square-x ltr:ml-2 rtl:mr-2 text-xl text-red-600'></i>
                            </button>
                        </form>
                    @endcan
                    
                    @cannot('update', $post)
                       @livewire('follow-button', ['post' => $post , 'userId'=> $post->owner->id,'classes'=>'text-blue-500'])
                        
                    @endcannot

                    

               
                </div>
            </div>

            {{-- Middle --}}
            <div class="flex flex-col grow overflow-y-auto">
                <div class="flex items-start p-5">
                    <img src="{{ $post->owner->getImage() }}" class="ltr:mr-5 rtl:ml-5 h-10 w-10 rounded-full">
                    <div>
                        <a href="{{ $post->owner->username }}" class="font-bold">{{ $post->owner->username }}</a>
                        {{ $post->description }}
                    </div>
                </div>

                {{-- Comments --}}
                <div class="grow">
                    @foreach ($post->comments as $comment)
                        <div class="flex items-start px-5 py-2">
                            <img src="{{ $comment->owner->getImage }}" alt="" class="h-100 ltr:mr-5 rtl:ml-5 w-10 rounded-full">
                            <div class="flex flex-col">
                                <div>
                                    <a href="/{{ $comment->owner->username }}" class="font-bold">{{ $comment->owner->username }}</a>
                                    {{ $comment->body }}
                                </div>
                                <div class="mt-1 text-sm font-bold text-gray-400">
                                    {{ $comment->created_at->shortAbsoluteDiffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="p-3 border-t flex flex-row">
                    @livewire('like' , ['post' => $post]) {{--//, ['user' => $user], key($user->id))--}}
        
                    <a class="grow" onclick="document.getElementById('comment_body').focus()">
                        <i class="bx bx-comment text-3xl hover:text-gray-400 cursor-pointer ltr:mr-3 rtl:ml-3"></i>
                    </a>

                </div>
                @livewire('liked-by', ['post' => $post])

                <div class="border-t p-5">
                    <form action="/p/{{ $post->slug }}/comment" method="POST">
                        @csrf
                        <div class="flex flex-row">
                <textarea name="body" id="comment_body" placeholder="{{ __('Add a comment...') }}"
                        class="h-5 grow resize-none overflow-hidden border-none bg-none p-0 placeholder-gray-400 outline-0 focus:ring-0"></textarea>
                            <button type="submit"
                                    class="ltr:ml-5 rtl:mr-5 border-none bg-white text-blue-500">{{ __('Post') }}</button>
                        </div>
                    </form>
                </div>


               
            </div>

          
        </div>

    </div>
</x-app-layout>