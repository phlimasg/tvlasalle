<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tv extends Model
{
    use HasFactory;

    protected $fillable =[
        'nome',
        'descricao',
        'url',
        'filial_id',
        'user_id',
        'ativo'
    ];

    function PostTv(){
        return $this->hasMany(Post_tv::class);
    }
}
