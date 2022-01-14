<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostObserver
{
    public function creating(Post $post)
    {
        $post->ativo = 1;
        $post->user_id = Auth::user()->id;
        $post->user_autorizacao = Auth::user()->id;
        $post->filial_id = Session::get('filial_id');
    }
}
