<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kriteria = Kriteria::orderBy('kode','ASC')->get();
        return view('kriteria.index',compact('kriteria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'kode' => 'required|max:255|unique:kriteria,kode',
            'bobot' => 'required|integer|gte:0|lte:100',
            'tipe' => 'required'
        ]);

        $kriteria = Kriteria::sum('bobot');
        $total = $kriteria + $request->bobot;
        if($total > 100){
            return back()->withErrors(['bobot' => 'Bobot total sudah melebihi 100%.'])->withInput();
        }

        Kriteria::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'bobot' => $request->bobot,
            'tipe' => $request->tipe
        ]);

        return redirect()->route('kriteria.index')->with('success','Data Tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kriteria = Kriteria::with('subKriteria')->findOrFail($id);

        return view('subkriteria.index',compact('kriteria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.edit',compact('kriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'kode' => 'required|max:255|unique:kriteria,kode,'.$id,
            'bobot' => 'required|integer|gte:0|lte:100',
            'tipe' => 'required'
        ]);

        $bobot = Kriteria::where('id','!=',$id)->sum('bobot');
        $total = $bobot + $request->bobot;
        if($total > 100){
            return back()->withErrors(['bobot' => 'Bobot total sudah melebihi 100%.'])->withInput();
        }

        $kriteria = Kriteria::findOrFail($id);
        $kriteria->nama = $request->nama;
        $kriteria->kode = $request->kode;
        $kriteria->bobot = $request->bobot;
        $kriteria->tipe = $request->tipe;
        $kriteria->save();

        return redirect()->route('kriteria.index')->with('success','Data Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        return redirect()->route('kriteria.index')->with('success','Data dihapus');
    }
}
