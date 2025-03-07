@extends('layouts.main')
@section('title', 'Kriteria')
@section('page_title', 'Kriteria')
@section('button')

        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="{{ route('kriteria.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Tambah Kriteria
                </a>
                <a href="{{ route('kriteria.create') }}" class="btn btn-primary d-sm-none btn-icon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
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
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="10%">Kode</th>
                                <th>Nama</th>
                                <th width="20%">Bobot (%)</th>
                                <th align="center" width="11%">Tipe</th>
                                <th class="text-center" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteria as $r)
                                <tr>
                                    <td>{{ $r->kode }}</td>
                                    <td>{{ $r->nama }}</td>
                                    <td>{{ $r->bobot }}%</td>
                                    <td>
                                        @if($r->tipe == 'COST')
                                        <span class="badge text-bg-danger">{{ $r->tipe }}</span>
                                        @else
                                        <span class="badge text-bg-success">{{ $r->tipe }}</span>
                                        @endif
                                    </td>
                                    <td align="center">
                                        <!-- Example single danger button -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Opsi
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('kriteria.edit', $r->id) }}">Edit</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('kriteria.show', $r->id) }}">Subkriteria</a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('kriteria.destroy',$r->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="deleteConfirm(event)" class="dropdown-item" href="#">Hapus</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('script')
    <script>
        $('#example').DataTable();

        function deleteConfirm(e){
			e.preventDefault();
			var form = e.target.form;
            Swal.fire({
                title: 'Apakah anda ingin menghapus data ini?',
                text: "Data akan terhapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endpush
