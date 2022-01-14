@extends('adminlte::page')


@php
//Config::set('adminlte.sidebar_collapse',true);
@endphp

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <a href="{{ route('post.create',['filial'=>$filial]) }}" class="btn btn-primary float-right"><i class="fa fa-plus"></i> Novo Post</a>
        <h3>Listagem de posts</h3>
    </div>
</div>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Todos os posts</h3>
                <div class="card-tools">
                    {{ $posts->links() }}
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Titulo</th>
                            <th>Início</th>
                            <th>Fim</th>
                            <th>Status</th>
                            <th>Autorizado por:</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $i)
                        <tr class="@if ($i->tipo == 'Patrocinado') bg-success @endif">
                            <td>{{$i->id}}</td>
                            <td style="max-width: 300px" >
                                <span >
                                    @if ($i->tipo == 'Patrocinado')
                                        <i class="fa fa-dollar-sign"></i><i class="fa fa-dollar-sign"></i><i class="fa fa-dollar-sign"></i> - 
                                    @endif
                                    {{$i->titulo}}
                                    @if ($i->tipo == 'Patrocinado')
                                        - <i class="fa fa-dollar-sign"></i><i class="fa fa-dollar-sign"></i><i class="fa fa-dollar-sign"></i>
                                    @endif
                                </span>
                            </td>
                            <td>{{$i->dt_inicio}}</td>
                            <td>{{$i->dt_fim}}</td>
                            <td>
                                <span class="badge {{$i->ativo == 1 ? 'bg-success' : 'bg-danger'}}">
                                    {{$i->ativo == 1 ? 'Ativo' : 'Desativado'}}
                                </span>
                            </td>
                            <td>{{$i->user_autorizacao == null ? 'Não autorizado': $i->User->name}}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                                        data-toggle="dropdown">
                                        <i class="fa fa-cogs"></i> Opções
                                        <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('post.show', ['filial'=>$filial,'post'=>$i]) }}"><i class="fa fa-tv"></i> Tv's Vinculadas</a>
                                        @if ($i->user_autorizacao == null)
                                            <a class="dropdown-item" href="{{ route('post.autorizar', ['filial'=>$filial,'post'=>$i]) }}"><i class="fa fa-thumbs-up"></i> Autorizar</a>                                            
                                        @endif
                                        <a class="dropdown-item" href="{{ route('post.status', ['filial'=>$filial,'post'=>$i]) }}">
                                            @if ($i->ativo == 1)
                                                <i class="fa fa-frown"></i> Desativar
                                            @else
                                                <i class="fa fa-smile-beam"></i> Ativar
                                            @endif
                                            
                                        </a>
                                        <a class="dropdown-item" href="{{ route('post.edit', ['filial'=>$filial,'post'=>$i]) }}"><i class="fa fa-edit"></i> Editar</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#excluir_{{$i->id}}"><i class="fa fa-trash"></i> Excluir</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="#" target="_blank" data-toggle="modal" data-target="#video_{{$i->id}}" class="btn btn-primary"><i class="fab fa-youtube"></i> Assistir Vídeo</a>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="video_{{$i->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{$i->titulo}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                <video width="100%" controls preload="auto" height="450px">
                                    <source src="{{$i->video_url}}" type="video/mp4">
                                    Seu navegador não suporta esse recurso. Utilize o Google Chrome.
                                </video>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="modal fade" id="excluir_{{$i->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{$i->titulo}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                Deseja realmente excluir o post <b>{{$i->titulo}}</b>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('post.destroy', ['filial'=>$filial,'post'=>$i]) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Confirmar Exclusão</button>
                                    </form>
                                  </div>
                            </div>
                            </div>
                        </div>
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