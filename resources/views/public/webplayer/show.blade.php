@extends('adminlte::page')


@php
//Config::set('adminlte.sidebar_collapse',true);
//Config::set('lfm.file_type_array',['mp4'  => 'MPEG4 File',]);

//Config::set('lfm.folder_categories.file.valid_mime',[]);

@endphp


@section('title', 'Dashboard')

@section('content_header')
    <h3>Selecione a Tv</h3>
@stop

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Todos os filials</h3>
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
                        <th>Nome da Tv</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tvs as $i)
                    <tr>
                        <td>{{$i->id}}</td>
                        <td>{{$i->nome}}</td>
                        <td><a href="{{ route('webplayer.play', ['filial'=>$filial->url,'tv'=>$i->url]) }}" class="btn btn-primary float-right"><i class="fa fa-tv"></i> Assitir Tv</a></td>
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop