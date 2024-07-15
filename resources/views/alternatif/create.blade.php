@extends('layouts.main')
@section('title', 'Tambah Alternatif')
@section('page_title', 'Tambah Alternatif')
@section('button')

@endsection
@section('content')
    <div class="container-xl">
        <div class="card mb-4">
            {{-- <div class="card-header">
            <a type="button" href="{{ route('user.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
        </div> --}}
            <div class="card-body">
                <form class="row g-3" method="POST" action="{{ route('alternatif.store') }}">
                    @csrf
                        <div class="col-md-12">
                            <label for="inputEmail4" class="form-label">Nama Alternatif</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" id="inputEmail4">
                            <span style="color:red;"> @error('nama') {{ $message }} @enderror</span>
                        </div>
                        {{-- @foreach($kriteria as $k)
                        <div class="col-md-12">
                            <label for="inputState" class="form-label">{{ $k->nama }} ({{ $k->kode }})</label>
                            <select id="inputState"  class="form-select">
                                @foreach($k->subKriteria as $ks)
                              <option value="{{ $ks->id }}">{{ $ks->nama }}</option>
                              @endforeach
                            </select>
                        </div>
                        @endforeach --}}
                        <div class="col-12">
                            <a type="button" href="{{ route('alternatif.index') }}" class="btn btn-secondary">Back</a>
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
