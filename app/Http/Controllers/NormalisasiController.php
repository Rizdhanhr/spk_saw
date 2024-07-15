<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\SubKriteria;
use Log;

class NormalisasiController extends Controller
{



    public function index(){
        //Kriteria
        $alternatif = Alternatif::with('kriteria')->orderBy('nama','ASC')->get();
        $kriteria = Kriteria::orderBy('kode','ASC')->get();

        $produk = DB::table('alternatif_kriteria')
        ->join('alternatif', 'alternatif_kriteria.alternatif_id', '=', 'alternatif.id')
        ->join('kriteria', 'alternatif_kriteria.kriteria_id', '=', 'kriteria.id')
        ->join('sub_kriteria', 'alternatif_kriteria.subkriteria_id', '=', 'sub_kriteria.id')
        ->select('alternatif.id as alternatif_id','kriteria.id as kriteria_id','sub_kriteria.bobot as bobot_sub')
        ->orderBy('alternatif.id')
        ->orderBy('kriteria.id')
        ->get();

        //Mencari Min Dan Max;
        $minMaxValues = [];
        foreach ($kriteria as $k) {
            $minMaxValues[$k->id]['min'] = $produk->where('kriteria_id', $k->id)->min('bobot_sub');
            $minMaxValues[$k->id]['max'] = $produk->where('kriteria_id', $k->id)->max('bobot_sub');
        }


        $data = [];
        foreach($alternatif as $a){
            foreach($kriteria as $k){
                foreach($produk as $d){
                    if($d->alternatif_id == $a->id && $d->kriteria_id == $k->id)
                    $data[$a->id][$k->id] = $d->bobot_sub;
                }
            }
        }


        //Normalisasi
        $normalisasi = [];
        foreach ($alternatif as $a) {
            foreach ($kriteria as $k) {
                foreach ($produk as $d) {
                    if ($d->alternatif_id == $a->id && $d->kriteria_id == $k->id) {
                        if ($k->tipe == 'BENEFIT') {
                            $normalisasi[$a->id][$k->id] = $d->bobot_sub / $minMaxValues[$k->id]['max'];
                        } else {
                            $normalisasi[$a->id][$k->id] = $minMaxValues[$k->id]['min'] / $d->bobot_sub;
                        }
                    }
                }
            }
        }

        //Preferensi
        $preferensi = [];
        foreach ($alternatif as $a) {
            foreach ($kriteria as $k) {
                foreach ($produk as $d) {
                    if ($d->alternatif_id == $a->id && $d->kriteria_id == $k->id) {
                        if ($k->tipe == 'BENEFIT') {
                            $preferensi[$a->id][$k->id] = ($d->bobot_sub / $minMaxValues[$k->id]['max']) * ($k->bobot / 100);
                        } else {
                            $preferensi[$a->id][$k->id] = ($minMaxValues[$k->id]['min'] / $d->bobot_sub) * ($k->bobot / 100);
                        }
                    }
                }
            }
        }

        $total_preferensi = [];
        foreach($preferensi as $key => $val){
            $total_preferensi[$key] = array_sum($preferensi[$key]);
        }


        $ranking = [];
        foreach($alternatif as $a){
            $ranking[$a->id] = [
             'nama' =>  $a->nama,
             'total' => $total_preferensi[$a->id]
            ];
        }

        usort($ranking, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        foreach($ranking as $r){
            Log::info($r['total']);
        }



        return view('normalisasi.index',compact('kriteria','produk','alternatif','minMaxValues','normalisasi','data','preferensi','total_preferensi','ranking'));




        // $alternatif = Alternatif::with('kriteria')->get();
        // $nama = Alternatif::pluck('nama','id');
        // $total_bobot = Kriteria::sum('bobot');
        // $kriteria = Kriteria::select('id','nama','bobot','tipe')->get();
        // $bobot = [];
        // foreach($kriteria as $k){
        //     $max = $alternatif->max(function ($item) use ($k) {
        //         return $item->kriteria()->where('kriteria_id', $k->id)->first()->pivot->nilai;
        //     });
        //     $min = $alternatif->min(function ($item) use ($k) {
        //         return $item->kriteria()->where('kriteria_id', $k->id)->first()->pivot->nilai;
        //     });
        //     $bobot[$k->id] = [
        //         'nama' => $k->nama,
        //         'bobot' => $k->bobot,
        //         'tipe' => $k->tipe,
        //         'nilai' => $k->bobot / $total_bobot,
        //         'max' => $max,
        //         'min' => $min
        //     ];
        // }

        // //Masukkan Data ke dalam Matriks
        // $matriks = [];
        // foreach($alternatif as $alt){
        //     foreach($alt->kriteria as $krit){
        //         $matriks[$alt->id][$krit->id] = $krit->pivot->nilai;
        //     }
        // }

        // // Log::info($matriks);

        // //Normalisasi Matriks
        // $matriks_normalisasi = [];
        // foreach($matriks as $key => $val){
        //    $hasil = 0;
        //    foreach($val as $key1 => $val1){
        //         $tipe = $bobot[$key1]['tipe'];
        //         $nilai = $bobot[$key1]['nilai'];
        //         $minVal = $bobot[$key1]['min'];
        //         $maxVal = $bobot[$key1]['max'];
        //         if($tipe == 'BENEFIT'){
        //             //Jika Benefit Maka Nilai / Max
        //             // $matriks_normalisasi[$key][$key1] = $val1 / $maxVal;
        //             $hasil += $nilai * ($val1 / $maxVal);
        //         }else{
        //             //Jika Cost Maka Min / Nilai
        //             // $matriks_normalisasi[$key][$key1] = $minVal / $val1;
        //             $hasil += $nilai * ($minVal / $val1);
        //         }
        //    }

        //    $matriks_normalisasi[$key] = [
        //     'nama' => $nama[$key],
        //     'hasil' => $hasil
        //    ];
        // }

        // // Fungsi untuk sorting berdasarkan hasil (descending)
        // usort($matriks_normalisasi, function($a, $b) {
        //     return $b['hasil'] <=> $a['hasil'];
        // });

        // // Log::info($matriks_normalisasi);

        // return view('penilaian.index',compact('matriks_normalisasi'));
    }
}
