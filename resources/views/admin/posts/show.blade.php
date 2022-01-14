@extends('adminlte::page')


@php
//Config::set('adminlte.sidebar_collapse',true);
@endphp

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('post.index',['filial'=> $filial]) }}" class="btn btn-primary float-right"><i
                class="fa fa-arrow-left"></i> Listar Posts</a>
        <h3>Informações do post</h3>
    </div>
</div>

@stop

@section('content')
<div class="card">
    <div class="card-header">
        <small class="float-right">criado em {{date('d/m/Y', strtotime($post->created_at))}}</small>
        <h3 class="card-title">
            {{$post->titulo}}
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <video width="100%" controls autoplay muted loop>
                    <source src="{{$post->video_url}}" type="video/mp4">
                    Navegador incompatível.
                </video>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Título:</label>
                        {{$post->titulo}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Data ini.:</label>
                        {{date('d/m/Y', strtotime($post->dt_inicio))}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Data fim:</label>
                        {{date('d/m/Y', strtotime($post->dt_fim))}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Criado por:</label>
                        {{$post->User->name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="">Autorizado por:</label>
                        {{$post->UserAutorizacao->name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if ($post->tipo == 'Patrocinado')
                        <label for="" class="text-success">
                            <i class="fa fa-dollar-sign"></i> - Patrocinado - <i class="fa fa-dollar-sign"></i>
                        </label>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <form action="{{ route('post.vincular', ['filial'=>$filial, 'post' => $post]) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <select class="js-example-basic-multiple form-control" name="tvs[]" multiple="multiple">
                                    @foreach ($filial->tvs()->where('ativo',1)->get() as $i)
                                    <option value="{{$i->id}}">{{$i->nome}}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="submit">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tvs Viculadas</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <tbody>
                                        @forelse ($tvs as $i)
                                        <tr>
                                            <td>{{$i->tv->nome}}</td>
                                            <td>
                                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_{{$i->id}}"><i
                                                        class="fa fa-times"></i></a>
                                            </td>
                                        </tr>

                                        <!-- The Modal -->
                                        <div class="modal fade" id="delete_{{$i->id}}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Desvincular Tv?</h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="modal-body">
                                                        Confirma a remoção?
                                                    </div>

                                                    <!-- Modal footer -->
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Cancelar</button>
                                                        <form action="{{ route('post.desvincular', ['filial'=>$filial, 'post'=>$post, 'post_tv' => $i]) }}" method="post">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Desvincular Tv</button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        Nenhuma tv vinculada...
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
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
<script>
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
@stop