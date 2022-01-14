@extends('adminlte::page')


@php
//Config::set('adminlte.sidebar_collapse',true);
@endphp

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('filial.create') }}" class="btn btn-primary float-right"><i class="fa fa-plus"></i> Nova filial</a>
        <h3>Listagem de filiais</h3>
    </div>
</div>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Todos os filials</h3>
                <div class="card-tools">
                    {{ $filials->links() }}
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nome da Filial</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($filials as $i)
                        <tr>
                            <td>{{$i->id}}</td>
                            <td style="max-width: 300px">{{$i->nome}}</td>                                                      
                            <td><a href="{{ route('post.index', ['filial'=>$i]) }}" class="btn btn-primary"><i class="fa fa-file"></i> Postagens</a></td>                                                        
                            <td><a href="{{ route('tv.index', ['filial'=>$i]) }}" class="btn btn-primary"><i class="fa fa-tv"></i> Vincular TV's</a></td>
                            <td><a href="{{ route('filial.edit', ['filial'=>$i]) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Editar</a></td>
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')
@if (Session::has('message'))
    <script>
        Swal.fire(
        'Sucesso',
        '{{Session::get("message")}}',
        'success'
    );
    </script>
@endif

@if (Session::has('error'))
    <script>
        Swal.fire(
        'Erro',
        '{{Session::get("error")}}',
        'error'
    );
    </script>
@endif
@stop