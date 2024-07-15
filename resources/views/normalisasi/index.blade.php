@extends('layouts.main')
@section('title', 'Normalisasi')
@section('page_title', 'Normalisasi')
@section('button')

    <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
            <a href="" class="btn btn-danger d-none d-sm-inline-block">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <i class="bi bi-printer"></i>
                Cetak
            </a>
            <a href="" class="btn btn-primary d-sm-none btn-icon">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <i class="bi bi-printer"></i>
            </a>
        </div>
    </div>

@endsection
@section('content')
    <div class="container-xl">
        <div class="card mb-4">
            {{-- <div class="card-header">
            <a type="button" href="{{ route('user.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
        </div> --}}
            <div class="card-body">
                <div class="row">
                    <h1>1. Data Masing Masing Alternatif Terhadap Kriteria</h1>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Alternatif</th>
                                    @foreach ($kriteria as $k)
                                        <th scope="col">{{ $k->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatif as $a)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $a->nama }}</td>
                                        @foreach ($kriteria as $k)
                                            <td>
                                                {{ $data[$a->id][$k->id] }}
                                                {{-- @foreach ($produk as $d)
                                                    @if ($d->alternatif_id == $a->id && $d->kriteria_id == $k->id)
                                                        {{ $d->bobot_sub }}
                                                    @endif
                                                @endforeach --}}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" align="right"><strong>NILAI MIN :</strong></td>
                                    @foreach ($kriteria as $k)
                                        <td>
                                            {{ $minMaxValues[$k->id]['min'] }}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td colspan="2" align="right"><strong>NILAI MAX :</strong></td>
                                    @foreach ($kriteria as $k)
                                        <td>
                                            {{ $minMaxValues[$k->id]['max'] }}
                                        </td>
                                    @endforeach
                                </tr>
                            </tfoot>

                        </table>
                    </div>

                </div>

                <div class="row">
                    <h1>2. Menghitung Nilai Normalisasi</h1>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Alternatif</th>
                                    @foreach ($kriteria as $k)
                                        <th scope="col">{{ $k->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatif as $a)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $a->nama }}</td>
                                        @foreach ($kriteria as $k)
                                            <td>
                                                @foreach ($produk as $d)
                                                    @if ($d->alternatif_id == $a->id && $d->kriteria_id == $k->id)
                                                        @if ($k->tipe == 'BENEFIT')
                                                            {{ $d->bobot_sub }} / {{ $minMaxValues[$k->id]['max'] }}
                                                        @else
                                                            {{ $minMaxValues[$k->id]['min'] }} / {{ $d->bobot_sub }}
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <h1>3. Hasil Normalisasi</h1>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Alternatif</th>
                                    @foreach ($kriteria as $k)
                                        <th scope="col">{{ $k->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatif as $a)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $a->nama }}</td>
                                        @foreach ($kriteria as $k)
                                            <td>
                                                {{ $normalisasi[$a->id][$k->id] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="row">
                    <h1>4. Menghitung Nilai Preferensi </h1>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Alternatif</th>
                                    @foreach ($kriteria as $k)
                                        <th scope="col">{{ $k->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatif as $a)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $a->nama }}</td>
                                        @foreach ($kriteria as $k)
                                            <td>
                                                @foreach ($produk as $d)
                                                    @if ($d->alternatif_id == $a->id && $d->kriteria_id == $k->id)
                                                     {{ $normalisasi[$a->id][$k->id] }} x {{ $k->bobot/100 }}
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" align="right"><strong>BOBOT :</strong></td>
                                    @foreach ($kriteria as $k)
                                        <td>
                                           <strong>{{ $k->bobot/100 }}</strong>
                                        </td>
                                    @endforeach
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>



                <div class="row">
                    <h1>5. Hasil Preferensi </h1>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Alternatif</th>
                                    @foreach ($kriteria as $k)
                                        <th scope="col">{{ $k->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatif as $a)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $a->nama }}</td>
                                        @foreach ($kriteria as $k)
                                            <td>
                                                {{ $preferensi[$a->id][$k->id] }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <h1>6. Total Nilai Preferensi </h1>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Alternatif</th>
                                    @foreach ($kriteria as $k)
                                        <th scope="col">{{ $k->nama }}</th>
                                    @endforeach
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alternatif as $a)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $a->nama }}</td>
                                        @foreach ($kriteria as $k)
                                            <td>
                                                {{ $preferensi[$a->id][$k->id] }}
                                            </td>
                                        @endforeach
                                        <td class="table-dark">{{ $total_preferensi[$a->id] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <h1>7. Perankingan </h1>
                    <div class="table-responsive mb-5">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Alternatif</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ranking as  $r)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $r['nama'] }}</td>
                                        <td class="table-dark">{{ $r['total']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('script')
    <script></script>
@endpush
