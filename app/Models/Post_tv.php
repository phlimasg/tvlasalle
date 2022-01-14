<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_tv extends Model
{
    use HasFactory;
    protected $fillable =['post_id', 'tv_id','user_id'];

    function Tv(){
        return $this->hasOne(Tv::class,'id','tv_id');
    }
    function Post(){
        return $this->hasOne(Post::class,'id','post_id');
    }
}
