<?php

namespace App\Http\Controllers;

use App\Http\Requests\TvRequest;
use App\Models\Filial;
use App\Models\Tv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Filial $filial)
    {        
        return view('admin.tvs.index',[
            'tvs' => $filial->Tvs()->orderBy('ativo','desc')
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
        //Auth::loginUsingId(1);
        //dd(Auth::user()->name);
        return view('admin.tvs.create',[
            //'Tv' => Tv::first(),
            'filial' => $filial
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Filial $filial, TvRequest $request)
    {
        try {
            Session::put('filial_id', $filial->id);
            Tv::create($request->except('_token'));            
            return redirect()->back()->with('message', 'Tv criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tv  $Tv
     * @return \Illuminate\Http\Response
     */
    public function show(Filial $filial, Tv $Tv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tv  $Tv
     * @return \Illuminate\Http\Response
     */
    public function edit(Filial $filial, Tv $Tv)
    {
        //dd($Tv);
        return view('admin.tvs.edit',[
            'Tv' => $Tv,
            'filial' => $filial
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tv  $Tv
     * @return \Illuminate\Http\Response
     */
    public function update(Filial $filial, Request $request, Tv $Tv)
    {
        try {
            $Tv->update($request->except('_token'));            
            return redirect()->back()->with('message', 'Tv editado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tv  $Tv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Filial $filial, Tv $Tv)
    {
        try {
            $Tv->delete();            
            return redirect()->back()->with('message', 'Tv removida com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }  
    public function status(Filial $filial, Tv $tv)
    {
        try {
            $tv->ativo == 1 ? $tv->update(['ativo' => 0]) : $tv->update(['ativo' => 1]);            
            return redirect()->back()->with('message', 'Status alterado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

