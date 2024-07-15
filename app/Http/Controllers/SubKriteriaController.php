<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Validation\Rule;

class SubKriteriaController extends Controller
{


    public function store(Request $request,$id){
        $request->validate([
            'nama' => 'required|max:255',
            'nilai' => ['required','integer','gt:0',
            Rule::unique('sub_kriteria','bobot')
            ->where(function ($query) use ($request,$id) {
                return $query->where('kriteria_id', $id);
            })],
        ]);

        SubKriteria::create([
            'nama' => $request->nama,
            'bobot' => $request->nilai,
            'kriteria_id' => $id
        ]);

        return response()->json(['success' => 'Data Tersimpan'],200);

    }

    public function update(Request $request,$id){
        $request->validate([
            'nama' => 'required|max:255',
            'nilai' => ['required','integer','gt:0',
            Rule::unique('sub_kriteria','bobot')
            ->where(function ($query) use ($request,$id) {
                return $query->where('kriteria_id', $id);
            })->ignore($id,'id')],
        ]);

        $sub = Subkriteria::findOrFail($id);
        $sub->nama = $request->nama;
        $sub->bobot = $request->nilai;
        $sub->save();

        return response()->json(['success' => 'Data Diupdate'],200);
    }

    public function destroy($id){
        $sub = Subkriteria::findOrFail($id);
        $sub->delete();

        return redirect()->back()->with('success','Data Terhapus');
    }
}
