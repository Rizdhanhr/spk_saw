@extends('layouts.main')
@section('title', 'Penilaian Alternatif')
@section('page_title', 'Penilaian Alternatif')
@section('button')

@endsection
@section('content')
    <div class="container-xl">
        <div class="card mb-4">
            {{-- <div class="card-header">
            <a type="button" href="{{ route('user.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
        </div> --}}
            <div class="card-body">
                <form class="row g-3" method="POST" action="{{ route('penilaian.store') }}">
                    @csrf
                        <div class="col-md-12">
                            <label for="inputState" class="form-label">Alternatif</label>
                            <select id="inputState" name="alternatif"  class="form-select @error('alternatif') is-invalid @enderror">
                              @foreach($alternatif as $a)
                              <option value="{{ $a->id }}" {{ old('alternatif',$a->id) == $a->id? 'selected' : '' }}>{{ $a->nama }}</option>
                              @endforeach
                            </select>
                            <span style="color:red;">@error('alternatif') {{ $message }} @enderror</span>
                        </div>
                        @foreach($kriteria as $k)
                        <div class="col-md-12">
                            <label for="inputState" class="form-label">{{ $k->nama }} ({{ $k->kode }})</label>
                            <select id="inputState" name="kriteria[{{ $k->id }}]"  class="form-select @error("kriteria.$k->id") is-invalid @enderror">
                              @foreach($k->subKriteria as $ks)
                              <option value="{{ $ks->id }}" {{ old("kriteria.{$k->id}") == $ks->id? 'selected' : '' }}>{{ $ks->nama }}</option>
                              @endforeach
                            </select>
                            @error("kriteria.{$k->id}")
                            <span style="color:red;">{{ str_replace(".$k->id"," $k->kode",$message) }}</span>
                            @enderror
                        </div>
                        @endforeach
                        <div class="col-12">
                            <a type="button" href="{{ route('penilaian.index') }}" class="btn btn-secondary">Back</a>
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
