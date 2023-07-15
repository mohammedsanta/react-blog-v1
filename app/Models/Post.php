<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'description',
        'user_id',
        'tag_id',
        'picture',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->description = "$model->description Author: " . Auth::user()->name;
        });

        static::deleting(function ($model) {
            if(Storage::has($model->picture)){
                Storage::delete($model->picture);
            }
        });



    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comment()
    {
        return $this->morphOne(Comment::class,'commentable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }

}
