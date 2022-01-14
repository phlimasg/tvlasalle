<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filial extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];

    public function Posts()
    {
        return $this->hasMany(Post::class,'filial_id','id');
    }
    public function Tvs()
    {
        return $this->hasMany(Tv::class,'filial_id','id');
    }
}
