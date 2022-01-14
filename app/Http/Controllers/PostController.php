<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Filial;
use App\Models\Post;
use App\Models\Post_tv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Filial $filial)
    {
        //dd($filial->Posts);
        return view('admin.posts.index',[
            'posts' => $filial->Posts()
            ->orderBy('id','desc')
            ->orderBy('ativo','desc')
            ->orderBy('user_autorizacao','asc')
            ->paginate(10),
            'filial' => $filial
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Filial $filial)
    {
        Auth::loginUsingId(1);
        //dd(Auth::user()->name);
        return view('admin.posts.create',[
            //'post' => Post::first(),
            'filial' => $filial
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Filial $filial, PostRequest $request)
    {
        try {
            Session::put('filial_id', $filial->id);
            Post::create($request->except('token'));
            return redirect()->back()->with('message', 'Post criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Filial $filial, Post $post)
    {
        //dd($post->PostTv);
        return view('admin.posts.show',[
            'post' => $filial->Posts()->find($post->id),
            'filial' => $filial,
            'tvs' => $post->PostTv
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Filial $filial,Post $post)
    {
        //dd($post);
        return view('admin.posts.edit',[
            'post' => $post,
            'filial' => $filial            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Filial $filial, Request $request, post $post)
    {
        try {
            $post->update($request->except('_token'));            
            return redirect()->back()->with('message', 'Post editado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Filial $filial, Post $post)
    {
        try {
            $post->delete();            
            return redirect()->back()->with('message', 'Post removido com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function status(Filial $filial, Post $post)
    {
        try {
            $post->ativo == 1 ? $post->update(['ativo' => 0]) : $post->update(['ativo' => 1]);            
            return redirect()->back()->with('message', 'Status alterado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function autorizar(Filial $filial, Post $post)
    {
        try {
            $post->update(['user_autorizacao' => Auth::user()->id,'ativo' => 1]);            
            return redirect()->back()->with('message', 'Post autorizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function vincular(Filial $filial,Request $request, Post $post)
    {
        try {            
            if($filial->posts()->find($post->id)){                
                foreach ($request->tvs as $i) {                    
                    Post_tv::updateOrCreate([
                        'post_id' => $post->id, 
                        'tv_id' => $i,
                      //  'user_id' => Auth::user()->id
                    ],[
                        'post_id' => $post->id, 
                        'tv_id' => $i,
                        'user_id' => Auth::user()->id
                    ]);
                }
            }else {
                return redirect()->back()->with('error', 'Erro ao vincular...');
            }
            
            return redirect()->back()->with('message', 'Post autorizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function desvincular(Filial $filial, Post $post, Post_tv $post_tv)
    {
        try {            
            if($filial->posts()->find($post->id)){  
                
                $post->PostTv()->find($post_tv->id)->delete();
            }else {
                return redirect()->back()->with('error', 'Erro ao desvincular...');
            }
            
            return redirect()->back()->with('message', 'Post autorizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
