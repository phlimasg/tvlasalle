<?php

namespace App\Http\Controllers;

use App\Models\Filial;
use App\Models\Post;
use Illuminate\Http\Request;

class WebPlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.webplayer.index',[
            'filials' => Filial::paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $filial = Filial::where('url',$url)->first();        
        return view('public.webplayer.show',[
            'filial' => $filial,
            'tvs' => $filial->Tvs()->where('ativo',1)->paginate(5)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function play($filial_url, $tv_url)
    {
        $filial = Filial::where('url',$filial_url)->first();        
        $posts = $filial->Tvs()->where('url',$tv_url)->where('ativo',1)->first()
        ->PostTv()->whereIn('post_id',
            Post::select('id')->where('ativo',1)->where('user_autorizacao','<>', null)->where('filial_id',$filial->id)->get()
        )->get();
        //dd($posts);
        return view('public.webplayer.play',[
            //'filial' => $filial,
            //'tvs' => $filial->Tvs()->paginate(5)
            'posts' => $posts
        ]);
    }
}
