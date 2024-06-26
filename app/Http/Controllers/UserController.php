<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserProfileRequest;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('users.profile', compact('user'));
    }

    public function edit(User $user)
    {
        //abort_if(auth()->user()->cannot('edit-update-profile', $user), 403);
        Gate::authorize('edit-update-profile', $user);

        return view('users.edit', compact('user'));
    }

    public function update(User $user, UpdateUserProfileRequest $request)
    {
        //  $user->save($request);
        $data = $request->safe()->collect();

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        if ($data->has('image')) {
            $path = $request->file('image')->store('users', 'public');
            $data['image'] = $path;
        }


        $data['private_account'] = $request->has('private_account');
        //dd($data['lang']);
        $user->update($data->toArray());

        session()->flash('success', __('Your profile has been updated successfully!', [], $data['lang']));

        return redirect()->route('user_profile', $user);
    }

    public function follow(User $user)
    {
        auth()->user()->follow($user);
        return back();
    }

    public function unfollow(User $user)
    {
        auth()->user()->unfollow($user);
        return back();
    }
}
