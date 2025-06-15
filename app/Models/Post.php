<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'category_id',
        'user_id'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
