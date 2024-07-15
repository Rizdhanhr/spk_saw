@extends('layouts.main')
@section('title', 'Edit Kriteria')
@section('page_title', 'Edit Kriteria')
@section('button')

@endsection
@section('content')
    <div class="container-xl">
        <div class="card mb-4">
            {{-- <div class="card-header">
            <a type="button" href="{{ route('user.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
        </div> --}}
            <div class="card-body">
                <form class="row g-3" method="POST" action="{{ route('kriteria.update',$kriteria->id) }}">
                    @csrf
                    @method('PUT')
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Nama</label>
                            <input type="text" name="nama" value="{{ old('nama',$kriteria->nama) }}" class="form-control @error('nama') is-invalid @enderror" id="inputEmail4">
                            <span style="color:red;"> @error('nama') {{ $message }} @enderror</span>
                        </div>
                        <div class="col-md-3">
                          <label for="inputEmail4" class="form-label">Kode</label>
                          <input type="text" name="kode" value="{{ old('kode',$kriteria->kode) }}" class="form-control @error('kode') is-invalid @enderror" id="inputEmail4">
                          <span style="color:red;"> @error('kode') {{ $message }} @enderror</span>
                        </div>
                        <div class="col-md-2">
                            <label for="inputEmail4" class="form-label">Bobot (%)</label>
                            <input type="number" name="bobot" value="{{ old('bobot',$kriteria->bobot) }}" class="form-control @error('bobot') is-invalid @enderror" id="inputEmail4">
                            <span style="color:red;"> @error('bobot') {{ $message }} @enderror</span>
                            <div id="emailHelp" class="form-text">Range 1-100</div>
                        </div>
                        <div class="col-7">
                            <label for="inputState" class="form-label">Tipe</label>
                            <select id="inputState" name="tipe" class="form-select @error('tipe')
                                is-invalid
                            @enderror">
                              <option {{ old('tipe',$kriteria->tipe) == 'COST' ? 'selected' : '' }} value="COST">COST</option>
                              <option {{ old('tipe',$kriteria->tipe) == 'BENEFIT' ? 'selected' : '' }} value="BENEFIT">BENEFIT</option>
                            </select>
                            <span style="color:red;"@error('tipe') {{ $message }} @enderror></span>
                        </div>
                        <div class="col-12">
                            <a type="button" href="{{ route('kriteria.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    {{-- <div class="mb-3">
                        <label class='form-label' for="role">Tipe</label>
                        <select class="form-select-sm @error('role') is-invalid @enderror" id="role" name='role'>
                                <option {{ old('role') == $r->id? 'selected' : '' }} value="{{ $r->id }}">{{ $r->name }}</option>
                        </select>
                        <span style="color: red;">
                            @error('role')
                            {{ $message }}
                            @enderror
                        </span>
                    </div> --}}
                </form>

            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    $(document).ready(function() {
        $('#role').select2({
            theme: "bootstrap-5",
            width: '100%'
        });
    });
</script>
@endpush
