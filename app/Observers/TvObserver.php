<?php

namespace App\Observers;

use App\Models\Filial;
use App\Models\Tv;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TvObserver
{
    public function creating(Tv $tv)
    {
        $tv->ativo = 1;
        $tv->filial_id = Session::get('filial_id');
        $tv->user_id = Auth::user()->id;
        $tv->url = Str::kebab(Str::lower(Str::replace('-','',$tv->nome)));
    }
}
