<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'user_id', 'post_id'];

    //ユーザーとのリレーション
    public function user(){
        return $this->belongsTo(User::class);
    }

    //投稿とのリレーション
    public function post(){
        return $this->belongsTo(Post::class);
    }

    //親コメントとのリレーション
    public function parent(){
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    //返信コメントとのリレーション
    public function replies(){
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
