<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'title',
        'content',
        'category_id',
        'user_id',
        'status'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}