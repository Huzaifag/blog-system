<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
