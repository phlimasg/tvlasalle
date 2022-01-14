<?php

namespace Database\Seeders;

use App\Models\Perfil;
use Illuminate\Database\Seeder;

class PerfilSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perfil::create([
            'nome' => 'Root',
            'descricao' => 'Administra todo o sistema e todas as filiais.'
        ]);
        Perfil::create([
            'nome' => 'Administrador',
            'descricao' => 'Administra todo o sistema e filiais específicas.'
        ]);
        Perfil::create([
            'nome' => 'Editor',
            'descricao' => 'Cria e autoriza posts de filiais específicas.'
        ]);
        Perfil::create([
            'nome' => 'Usuário',
            'descricao' => 'Cria posts de acordo com o pacote escolhido.'
        ]);
            
    }
}
