<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilialRequest;
use App\Models\Filial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.filials.index',[
            'filials' => Filial::paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::loginUsingId(1);
        //dd(Auth::user()->name);
        return view('admin.filials.create',[
            //'filial' => filial::first(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilialRequest $request)
    {
        try {
            Filial::create($request->except('token'));
            return redirect()->back()->with('message', 'filial criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\filial  $filial
     * @return \Illuminate\Http\Response
     */
    public function show(Filial $filial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\filial  $filial
     * @return \Illuminate\Http\Response
     */
    public function edit(Filial $filial)
    {
        //dd($filial);
        return view('admin.filials.edit',[
            'filial' => $filial,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\filial  $filial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Filial $filial)
    {
        try {
            $filial->update($request->except('_token'));            
            return redirect()->back()->with('message', 'filial editado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\filial  $filial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Filial $filial)
    {
        try {
            $filial->delete();            
            return redirect()->back()->with('message', 'filial removido com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }   
}
