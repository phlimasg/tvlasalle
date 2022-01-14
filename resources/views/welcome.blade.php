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

@section('content_header')

@stop

@section('content')
<video id="my-video" class="video-js video-full" controls='false' preload="auto" autoplay>
    <!--<source src="https://www.w3schools.com/tags/mov_bbb.mp4" type="video/mp4" /> -->
    <p class="vjs-no-js">
        To view this video please enable JavaScript, and consider upgrading to a
        web browser that
        <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
    </p>
</video>
@stop

@section('css')
<link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
@stop

@section('js')
<script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
<script src="{{ asset('vendor/videojs-playlist/dist/videojs-playlist.js') }}"></script>


<script>
    var player = videojs('my-video',{
        autoplay: true,
        //controls: false,
        //aspectRatio: '16:9',
        responsive: true,
        muted: true,
        navigationUI: 'hide',
        autoSetup: true,
    });
    

    player.playlist([{
    sources: [{
        src: 'http://media.w3.org/2010/05/sintel/trailer.mp4',
        type: 'video/mp4'
    }],    
    }, {  
    sources: [{
        src: 'http://vjs.zencdn.net/v/oceans.mp4',
        type: 'video/mp4'
    }],    
    }]);

    // Play through the playlist automatically.
    player.playlist.autoadvance(0);
    player.playlist.repeat(true);
    $('body').css('cursor', 'none');

    setInterval(function () {
        console.log(player.playlist.currentItem())
        //player.autoplay('muted');
        //player.requestFullscreen;
        //player.muted(false);
        //$('#my-video').trigger('click');
        //document.getElementById('my-video').click();
        //console.log('Play');
    }, 2000);
</script>
@stop