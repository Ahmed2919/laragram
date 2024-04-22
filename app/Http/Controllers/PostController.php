<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ids = auth()->user()->following()->wherePivot('confirmed', true)->get()->pluck('id');
        $posts = Post::whereIn('user_id', $ids)->latest()->get();
        $suggested_user = auth()->user()->userSuggession();
        return view('posts.index', compact(['posts', 'suggested_user']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required',
            'image' => ['required', 'mimes:jpeg,jpg,png']
        ]);
        $image = $request['image']->store('posts', 'public');
        $data['image'] = $image;

        $data['slug'] = Str::random(10);

        auth()->user()->posts()->create($data);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $data = $request->validate([
            'description' => 'required',
            'image' => ['nullable', 'mimes:jpeg,jpg,png']
        ]);
        if ($request->has('image')) {
            $image = $request->image->store('posts', 'public');
            $data['image'] = $image;
        }
        $post->update($data);

        return redirect('/p/' . $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        Storage::delete('public/' . $post->image);

        $post->delete();

        return redirect(route('user_profile', ['user' => auth()->user()]));
    }

    public function explore()
    {
        $posts = Post::whereRelation('owner', 'private_account', '=', '0')
            ->whereNot('id', auth()->id())
            ->simplePaginate(12);
        return view('posts.explore', compact('posts'));
    }
}
