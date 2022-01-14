<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable =[
        'titulo',
        'dt_inicio',
        'dt_fim',
        'video_url',
        'tipo',
        'ativo',
        'user_id',
        'user_autorizacao'
    ];

    function User(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function UserAutorizacao(){
        return $this->hasOne(User::class, 'id', 'user_autorizacao');
    }
    function PostTv(){
        return $this->hasMany(Post_tv::class);
    }
}
