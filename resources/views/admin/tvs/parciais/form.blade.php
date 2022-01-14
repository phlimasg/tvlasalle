<div class="row">
    <div class="col-md-12">
        <label for="">Nome da tv:</label>
        <input type="text" name="nome" id="" class="form-control  @error('nome') is-invalid @enderror" placeholder="Insira o nome" value="{{!empty(old('nome')) ? old('nome') : (isset($tv) == true ? $tv->nome : null)}}">
        @error('nome')                        
            <span class="text-danger">{{$message}}</span>        
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label for="">Descrição da tv:</label>
        <textarea name="descricao" id="" cols="30" rows="2" class="form-control @error('nome') is-invalid @enderror">{{!empty(old('descricao')) ? old('descricao') : (isset($tv) == true ? $tv->descricao : null)}}</textarea>        
        @error('descricao')                        
            <span class="text-danger">{{$message}}</span>        
        @enderror
    </div>
</div>



    


