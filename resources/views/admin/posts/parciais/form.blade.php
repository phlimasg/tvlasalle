<div class="row">
    <div class="col-md-12">
        <label for="">Título:</label>
        <input type="text" name="titulo" id="" class="form-control  @error('titulo') is-invalid @enderror" placeholder="Insira o título" value="{{!empty(old('titulo')) ? old('titulo') : (isset($post) == true ? $post->titulo : null)}}">
        @error('titulo')                        
            <span class="text-danger">{{$message}}</span>        
        @enderror
    </div>
</div>
<hr>
<label for="">Perído de vinculação:</label>
<div class="row">
    <div class="col-md-6">
        <label for="">Data de início:</label>
        <input type="text" name="dt_inicio" id="" class="form-control @error('dt_inicio') is-invalid @enderror" placeholder="Insira a data" value="{{!empty(old('dt_inicio')) ? old('dt_inicio') : (isset($post) == true ? $post->dt_inicio : null)}}">
        @error('dt_inicio')                        
            <span class="text-danger">{{$message}}</span>        
        @enderror
    </div>
    <div class="col-md-6">
        <label for="">Data de Fim:</label>
        <input type="text" name="dt_fim" id="" class="form-control @error('dt_fim') is-invalid @enderror" placeholder="Insira a data" value="{{!empty(old('dt_fim')) ? old('dt_fim') : (isset($post) == true ? $post->dt_fim : null)}}">
        @error('dt_fim')                        
            <span class="text-danger">{{$message}}</span>        
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <label for="">Url do Vídeo em .mp4:</label>
        <div class="input-group">
            <span class="input-group-btn">
              <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                <i class="fa fa-video"></i> Selecionar Vídeo
              </a>
            </span>
            <input id="thumbnail" class="form-control @error('video_url') is-invalid @enderror" type="text" name="video_url" value="{{!empty(old('video_url')) ? old('video_url') : (isset($post) == true ? $post->video_url : null)}}">
          </div>
          <img id="holder" style="margin-top:15px;max-height:100px;">
        @error('video_url')                        
            <span class="text-danger">{{$message}}</span>        
        @enderror
    </div>
    <div class="col-md-4">
        <label for="">Tipo:</label>
        <select name="tipo" class="form-control @error('tipo') is-invalid @enderror">
            <option value=""></option>
            <option {{!empty(old('tipo')) && old('tipo') == 'Interno' ? 'selected' : (isset($post) == true && $post->tipo == 'Interno' ? 'selected' : null)}} value="Interno">Interno</option>
            <option {{!empty(old('tipo')) && old('tipo') == 'Patrocinado' ? 'selected' : (isset($post) == true && $post->tipo == 'Patrocinado' ? 'selected' : null)}} value="Patrocinado">Patrocinado</option>
        </select>
        @error('tipo')                        
            <span class="text-danger">{{$message}}</span>        
        @enderror
    </div>
</div>

    


