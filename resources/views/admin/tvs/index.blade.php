@extends('adminlte::page')


@php
//Config::set('adminlte.sidebar_collapse',true);
@endphp

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('tv.create',['filial'=>$filial]) }}" class="btn btn-primary float-right"><i
                class="fa fa-plus"></i> Nova Tv</a>
        <h3>Listagem de Tvs</h3>
    </div>
</div>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Todos as Tvs</h3>
                <div class="card-tools">
                    {{ $tvs->links() }}
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nome da tv</th>
                            <th>Descrição</th>
                            <th>Acesso</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tvs as $i)
                        <tr>
                            <td>{{$i->id}}</td>
                            <td style="max-width: 300px">{{$i->nome}}</td>
                            <td>{{$i->descricao}}</td>
                            <td><a target="_blank" href="{{ route('webplayer.play', ['filial'=>$filial->url, 'tv'=>$i->url]) }}"><i class="fa fa-globe-americas"></i> Link</a></td>
                            <td style="width: 180px">
                                @if ($i->ativo == 1)
                                <a class="btn btn-success btn-block"
                                    href="{{ route('tv.autorizar', ['filial'=>$filial,'tv' => $i]) }}">
                                    <i class="fa fa-smile-beam"></i> Tv Ativada
                                    
                                </a>
                                @else
                                <a class="btn btn-danger btn-block"
                                    href="{{ route('tv.autorizar', ['filial'=>$filial,'tv' => $i]) }}">
                                    <i class="fa fa-frown"></i>  Tv Desativada
                                </a>
                                @endif
                            </td>
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