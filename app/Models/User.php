<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;

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
        'email',
        'password',
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
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    protected function online(): Attribute
    {
        return Attribute::make(
            get: fn () => Cache::has('user-online-' . $this->id),
        );
    }

    protected function friends(): Attribute
    {
        return Attribute::make(
            get: function () {
                $to_friendships = Friendship::select('to_id as id')->where('from_id', $this->id)->where('status', 'approved')->get();
                $from_friendships = Friendship::select('from_id as id')->where('to_id', $this->id)->where('status', 'approved')->get();
                $all_friendships = $to_friendships->merge($from_friendships);
                $friends = User::whereIn("id", $all_friendships->pluck("id")->toArray())->get();
                return $friends;
            },
        );
    }

    protected function groups(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Group::whereIn("id", $this->memberships->pluck("group_id")->toArray());
            },
        );
    }
}
