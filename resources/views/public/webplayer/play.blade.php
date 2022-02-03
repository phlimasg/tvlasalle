@extends('adminlte::page')


@php
Config::set('adminlte.menu',[]);
//Config::set('adminlte.sidebar_collapse',true);
//Config::set('adminlte.classes_sidebar','d-none');
Config::set('adminlte.classes_sidebar_nav','d-none');
//Config::set('adminlte.classes_content_wrapper','content-100');
Config::set('adminlte.layout_topnav',true);
Config::set('adminlte.classes_topnav','d-none');
Config::set('adminlte.classes_topnav_container','container-fluid');
Config::set('adminlte.classes_content_header','container-fluid');
Config::set('adminlte.classes_content','container-fluid');
@endphp

@section('title', 'Dashboard')

@section('content')
<div class="row bg-primary">
    <div class="col-md-2 pl-2 p-0 text-center" id="mensagem">
        <div class="row">
            <div class="col-md-12">
                <img src="{{ asset('images/logo.png') }}" alt="" srcset="" class="img-fluid p-4"
                    style="margin-bottom: -35px">
            </div>
        </div>
        <div class="row pt-5 mt-1 pb-5">
            <div class="col-md-12">
                <img src="{{ asset('images/tempo/0.png') }}" alt="" srcset="" class="img-fluid pl-2" id="img_tempo">
                <label for="" id="lbl_sub" style="float: right; margin-top: -65px; font-size: .8em;" class="mr-2">...</label>
                <label id="lbl_tempo" style="font-size: 1.3em; margin-top: -35px;">Carregando
                    previsão...</label>
                <p style="margin-top: -10px; font-size: 1.5em;">
                    <label id="lbl_hora">...</label>
                </p>
                <p style="margin-top: -15px; font-size: .8em">
                    <label id="lbl_local" style="">...</label> -
                    <label id="lbl_dt" style="">...</label>
                </p>
            </div>
        </div>
        <div class="row m-1">
            <div class="col-md-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <label for="" style="font-size: 1.5em;">Dolar hoje:</label>
                        <div class="row mt-1">
                            <div class="col-md-6">
                                <small>Compra:</small>
                                <h4><small style="font-size: 12px">R$:</small>
                                    {{$financas->results->currencies->USD->buy}}</h4>
                            </div>
                            <div class="col-md-6">
                                <small>Venda:</small>
                                <h4><small style="font-size: 12px">R$:</small>
                                    {{$financas->results->currencies->USD->sell}}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dollar-sign"></i>
                    </div>
                    <a href="#" class="small-box-footer bg-white">
                        @if (Str::contains($financas->results->currencies->USD->variation, '-'))
                        <span class="text-danger">Variação: <i class="fa fa-arrow-down"></i>
                            {{$financas->results->currencies->USD->variation}}%</span>
                        @else
                        <span class="text-success">Variação: <i class="fa fa-arrow-up"></i>
                            {{$financas->results->currencies->USD->variation}}%</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <div class="row m-1">
            <div class="col-md-12">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <label for="" style="font-size: 1.5em;">Taxas:</label>
                        <div class="row mt-1">
                            <div class="col-md-6">
                                <small>CDI:</small>
                                <h4><small style="font-size: 12px">R$:</small>
                                    {{$financas->results->taxes[0]->cdi}}</h4>
                            </div>
                            <div class="col-md-6">
                                <small>SELIC:</small>
                                <h4><small style="font-size: 12px">R$:</small>
                                    {{$financas->results->taxes[0]->selic}}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fa fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12 p-0">
                <video id="my-video" class="video-js video-full" controls='false' preload="auto" autoplay>
                    <!--<source src="https://www.w3schools.com/tags/mov_bbb.mp4" type="video/mp4" /> -->
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video>
            </div>
        </div>
        <div class="row bg-primary">
            <div class="col-md-12" style="max-height: 300px; padding: 10px 30px 30px 0px;">
                <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @php($active = true)                
                        @foreach ($news->articles as $i)
                            <div class="carousel-item @if ($active == true) active @endif">  
                                <div class="row">
                                    <div class="col-md-4 m-0 p-0" style="background-image: url('{{$i->urlToImage}}'); background-size: cover; background-position: center;">
                                        <div style="background: rgba(255, 255, 255, 0.5); width: 100%; height: 100%; max-height: 250px" class="m-0 p-2 text-center">
                                            <img src="{{$i->urlToImage}}" class="img-fluid align-middle" style="max-height: 250px">
                                        </div>
                                    </div>
                                    <div class="col-md-6 p-3">
                                        <h1>{{$i->title}}</h1>
                                        <!-- <p>{{$i->description}}</p>-->
                                        <h3 class="mt-2">Escaneie ao lado e leia a Matéria:</h3>
                                    </div>
                                    <div class="col-md-2 text-center p-1">
                                        {{ QrCode::margin(2)->size(10)->generate($i->url)}}
                                    </div>
                                </div>                      
                            </div>
                            @php($active = false)
                        @endforeach                
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
<link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
@stop

@section('js')

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
<script src="{{ asset('vendor/videojs-playlist/dist/videojs-playlist.js') }}"></script>


<script>
    var list = [
        @foreach ($posts as $i)        
        {
        sources: [{
            src: '{{$i->Post->video_url}}',
            type: 'video/mp4'
        }],
        poster: '{{asset("images/logo.png")}}',
        },
        @endforeach 
         
    ];
    var player = videojs('my-video',{
        autoplay: true,
        //controls: false,
        aspectRatio: '16:8',
        responsive: true,
        //muted: true,
        navigationUI: 'hide',
        autoSetup: true,
    });
    

    player.playlist(list);
    
    player.playlist.autoadvance(0);
    player.playlist.repeat(true);
    //$('body').css('cursor', 'none');

    setInterval(function () {
        var data = new Date();
        hora = data.getHours().toString().padStart(2, '0');
        min = data.getMinutes().toString().padStart(2, '0');
        seconds = data.getSeconds().toString().padStart(2, '0');
        dia  = data.getDate().toString().padStart(2, '0'),
        mes  = (data.getMonth()+1).toString().padStart(2, '0'), //+1 pois no getMonth Janeiro começa com zero.
        ano  = data.getFullYear();
        player.playlist.currentItem();
        console.log(seconds.length == 1);
        
        $("#lbl_hora").text(hora+":"+min+":"+seconds);
        $("#lbl_dt").text(dia+"/"+mes+"/"+ano);      
    }, 1000);
</script>


<!-- Pegar localização do usuário -->
<script>
    var x=document.getElementById("mensagem");
    function getLocation()
      {
      if (navigator.geolocation)
        {
        navigator.geolocation.getCurrentPosition(showPosition,showError);
        }
      else{x.innerHTML="Seu browser não suporta Geolocalização.";}
      }
    function showPosition(position)
      {
        var url = '{{route('webplayer.tempo',['filial'=>$filial->url, 'tv'=>$tv->url])}}/'+ position.coords.latitude +'/'+ position.coords.longitude;
        
        $.get(url, function(data, status){
            console.log(url,data["results"]["img_id"],status);
            $('#img_tempo').attr("src","{{asset('images/tempo/')}}/"+ data["results"]["img_id"] +".png");
            $("#lbl_tempo").text(data["results"]["forecast"][0]["description"]);
            $("#lbl_sub").text("Min.: "+ data["results"]["forecast"][0]["min"] + "º - Max.: " + data["results"]["forecast"][0]["max"] + "º");            
            $("#lbl_local").html( '<i class="fa fa-map-marker"></i> '+ data["results"]["city"]);
            
            //x.innerHTML= "Data: " + data + "\nStatus: " + status;
        });
      //x.innerHTML="Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude; 
      }
    function showError(error)
      {
      switch(error.code)
        {
        case error.PERMISSION_DENIED:
          x.innerHTML="Usuário rejeitou a solicitação de Geolocalização."
          break;
        case error.POSITION_UNAVAILABLE:
          x.innerHTML="Localização indisponível."
          break;
        case error.TIMEOUT:
          x.innerHTML="A requisição expirou."
          break;
        case error.UNKNOWN_ERROR:
          x.innerHTML="Algum erro desconhecido aconteceu."
          break;
        }
      }
    getLocation();
</script>

@stop