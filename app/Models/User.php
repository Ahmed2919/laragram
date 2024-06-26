<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'bio',
        'private_account',
        'image',
        'email',
        'password',
        'lang'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(related: Post::class);
    }

    public function comments()
    {
        return $this->hasMany(related: Comment::class);
    }

    public function userSuggession()
    {
        $followers = auth()->user()->following()->wherePivot('confirmed', true)->get();
        //dd(User::all()->diff($followers)->except(auth()->id())->shuffle());
        return User::all()->diff($followers)->except(auth()->id())->shuffle()->take(5);
    }

    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'following_user_id')->withTimestamps()->withPivot('confirmed');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_user_id', 'user_id')->withTimestamps()->withPivot('confirmed');
    }

    public function toggle_follow(User $user)
    {
        $this->following()->toggle($user);
        if (!$user->private_account) {
            $this->following()->updateExistingPivot($user, ['confirmed' => true]);
        }
    }

    public function follow(User $user)
    {
        if ($user->private_account) {
            return $this->following()->attach($user);
        }
        return $this->following()->attach($user, ['confirmed' => true]);
    }

    public function unfollow(User $user)
    {
        return $this->following()->detach($user);
    }

    public function is_pending(User $user)
    {
        return $this->following()->where('following_user_id', $user->id)->where('confirmed', false)->exists();
    }

    public function is_follower(User $user)
    {
        return $this->followers()->where('user_id', $user->id)->where('confirmed', true)->exists();
    }

    public function is_following(User $user)
    {
        return $this->following()->where('following_user_id', $user->id)->where('confirmed', true)->exists();
    }

    public function pending_followers()
    {
        return $this->followers()->wherePivot('confirmed', false);
    }
    public function confirm(User $user)
    {
        return $this->followers()->updateExistingPivot($user, ['confirmed' => true]);
    }

    public function deleteFollowRequest(User $user)
    {
        return $this->followers()->detach($user);
    }

    public function getImage()
    {
        if (Str::startsWith($this->image, 'http')) {
            return $this->image;
        }

        return asset('/storage/' . $this->image);
    }
}
