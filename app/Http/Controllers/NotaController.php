<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Nota;

class NotaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $username = auth()->user()->username;
        $notas = Nota::where('usuario', $username)->paginate(5);
        return view('notas.lista', compact('notas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notas.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nota = new Nota();
        $nota->nombre = $request->nombre;
        $nota->descripcion = $request->descripcion;
        $nota->usuario = auth()->user()->username;
        $nota->save();

        return back()->with('mensaje', 'Nota Agregada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $username = auth()->user()->username;
        $nota = Nota::where('usuario', $username)->findOrFail($id);
        return view('notas.editar', compact('nota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $username = auth()->user()->username;
        $notaActualizada = Nota::where('usuario', $username)->findOrFail($id);
        $notaActualizada->nombre = $request->nombre;
        $notaActualizada->descripcion = $request->descripcion;
        $notaActualizada->save();
        return back()->with('mensaje', 'Nota editada!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $username = auth()->user()->username;
        $notaEliminar = Nota::where('usuario', $username)->findOrFail($id);;
        $notaEliminar->delete();

        return back()->with('mensaje', 'Nota Eliminada');
    }
}
