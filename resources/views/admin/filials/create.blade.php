@extends('adminlte::page')


@php
//Config::set('adminlte.sidebar_collapse',true);
//Config::set('lfm.file_type_array',['mp4'  => 'MPEG4 File',]);

//Config::set('lfm.folder_categories.file.valid_mime',[]);

@endphp


@section('title', 'Dashboard')

@section('content_header')
    <h3>Adicionar filial</h3>
@stop

@section('content')
<form action="{{ route('filial.store') }}" method="post">
    @csrf
    <div class="card">
        <div class="card-body">
            @include('admin.filials.parciais.form')
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Salvar filial</button>
        </div>
    </div>
</form>
@stop

@section('css')

@stop

@section('js')
<script src={{url("/vendor/laravel-filemanager/js/stand-alone-button.js")}}>    
</script>
<script>
    $('#lfm').filemanager('file');
</script>
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