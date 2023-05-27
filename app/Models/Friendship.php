<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_id',
        'to_id',
        'status',
    ];

    public function from(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function to(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
