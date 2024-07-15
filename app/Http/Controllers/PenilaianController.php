<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Kriteria;
use DB;
use Log;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alternatif = Alternatif::has('kriteria')->with('kriteria')->get();
        return view('penilaian.index',compact('alternatif'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alternatif = Alternatif::whereDoesntHave('kriteria')->get();
        $kriteria = Kriteria::with('subKriteria')->orderBy('kode','ASC')->get();
        return view('penilaian.create',compact('alternatif','kriteria'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'alternatif' => 'required',
            'kriteria.*' => 'required',
        ]);

        try{
            DB::transaction(function () use($request){
                $alternatif = Alternatif::findOrFail($request->alternatif);
                $kriteria = $request->kriteria;
                foreach($kriteria as $key => $value){
                    $alternatif->kriteria()->attach($key,[
                        'subkriteria_id' => $value
                    ]);
                }
            });

            return redirect()->route('penilaian.index')->with('success','Data Tersimpan');
        }catch(\Exception $e){
            Log::info($e->getMessage());
            return redirect()->back()->with('error','Gagal');
        }

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
