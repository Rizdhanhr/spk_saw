<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Kriteria;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alternatif = Alternatif::orderBy('nama','ASC')->get();
        return view('alternatif.index',compact('alternatif'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kriteria = Kriteria::with('subKriteria')->orderBy('kode','ASC')->get();
        return view('alternatif.create',compact('kriteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255'
        ]);

        Alternatif::create([
            'nama' => $request->nama
        ]);

        return redirect()->route('alternatif.index')->with('success','Data Tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $alternatif = Alternatif::findOrFail($id);

        return view('alternatif.edit',compact('alternatif'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|max:255'
        ]);

        $alternatif = Alternatif::findOrFail($id);
        $alternatif->nama = $request->nama;
        $alternatif->save();

        return redirect()->route('alternatif.index')->with('success','Data Terupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alternatif = Alternatif::findOrFail($id);
        $alternatif->delete();

        return redirect()->route('alternatif.index')->with('success','Data Terhapus');
    }
}
