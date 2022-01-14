<div class="row">
    <div class="col-md-12">
        <label for="">Nome da Filial:</label>
        <input type="text" name="nome" id="" class="form-control  @error('nome') is-invalid @enderror" placeholder="Insira o nome" value="{{!empty(old('nome')) ? old('nome') : (isset($filial) == true ? $filial->nome : null)}}">
        @error('nome')                        
            <span class="text-danger">{{$message}}</span>        
        @enderror
    </div>
</div>



    


