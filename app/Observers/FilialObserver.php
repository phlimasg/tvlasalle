<?php

namespace App\Observers;

use App\Models\Filial;
use Illuminate\Support\Str;

class FilialObserver
{
    public function creating(Filial $filial)
    {
        $filial->url = Str::kebab(Str::lower(Str::replace('-','',$filial->nome)));
        
    }
    public function updating(Filial $filial)
    {
        $filial->url = Str::kebab(Str::lower(Str::replace('-','',$filial->nome)));
        
    }
}
