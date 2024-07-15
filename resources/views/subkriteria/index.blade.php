@extends('layouts.main')
@section('title', 'Sub Kriteria')
@section('page_title', 'Sub Kriteria')
@section('button')
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a onclick="modalCreate()"  class="btn btn-primary d-none d-sm-inline-block">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                    </svg>
                    Tambah Sub Kriteria
                </a>
                <a onclick="modalCreate()" class="btn btn-primary d-sm-none btn-icon">
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
                <div class="row mb-3">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                              <tr>
                                <th scope="row" width="30%">Nama Kriteria :</th>
                                <td>{{ $kriteria->kode }} - {{ $kriteria->nama }}</td>
                              </tr>
                              <tr>
                                <th scope="row">Bobot (%) :</th>
                                <td>{{ $kriteria->bobot }} ({{ $kriteria->bobot/100 }})</td>

                              </tr>
                              <tr>
                                <th scope="row">Tipe :</th>
                                <td>{{ $kriteria->tipe }}</td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>

                                <th>Nama</th>
                                <th width="20%">Nilai</th>
                                <th class="text-center" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteria->subKriteria as $r)
                                <tr>

                                    <td>{{ $r->nama }}</td>
                                    <td>{{ $r->bobot }}</td>
                                    <td align="center">
                                        <!-- Example single danger button -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Opsi
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a onclick="modalEdit({{ json_encode($r) }})" class="dropdown-item">Edit</a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('subkriteria.destroy',$r->id) }}" method="POST">
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



<!-- Modal -->
<div class="modal fade" id="modalCreate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 id="title" class="modal-title fs-5" id="staticBackdropLabel">Subkriteria</h1>
          <button type="button" onclick="modalClose()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="formData" >
                <input type="hidden" name="id" id="id">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="">
                    <span class="validation form-nama" style="color:red;"></span>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nilai</label>
                    <input type="number" class="form-control" id="nilai" name="nilai" value="">
                    <span class="validation form-nilai" style="color:red;"></span>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" onclick="modalClose()" data-bs-dismiss="modal">Close</button>
          <button type="button" id="btnSubmit" onclick="formSubmit()" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
</div>

@endsection
@push('script')
    <script>
        var id_kriteria = {!! json_encode($kriteria->id) !!};

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

        function modalCreate(){
            $('#id').val('');
            $('#modalCreate').modal('show');
        }

        function modalEdit(data){
            let array = data;
            // alert('edit');
            $('#id').val(array.id);
            $('#nama').val(array.nama);
            $('#nilai').val(array.bobot);
            $('#modalCreate').modal('show');
        }

        function modalClose(){
            $('.form-control').removeClass('is-invalid');
            $('.validation').html('');
            $('#nama').val('');
            $('#id').val('');
            $('#nilai').val('');
            $('#modalCreate').modal('hide');
        }

        function formSubmit(){
            let id =  $('#id').val()? $('#id').val() : null;
            console.log(id);
            if(id === null){

                formCreate();
            }else{

                formEdit();
            }
        }

        function formCreate(){
            let form = $('#formData');
            $('.validation').html('');
            $('.form-control').removeClass('is-invalid');
            let url = "{{ route('subkriteria.store', ":id") }}";
            url = url.replace(':id', parseInt(id_kriteria));
            $.ajax({
                method: "POST",
                url: url,
                data : form.serialize(),
                success: function(result) {
                    $('#modalCreate').modal('hide');
                    alertSuccess(result.success);
                    location.reload();
                    // table.ajax.reload();
                },
                error: function(error) {
                    if (error.status == 422) {
                        let error_validation = error.responseJSON.errors;
                        // console.log(error.responseJSON.errors);
                        $.each(error_validation, function(field_name, error) {
                            $('#' + field_name).addClass("is-invalid")
                            $('.form-' + field_name.replaceAll(".", "")).html(error);
                        });
                    }
                },
            });
        }

        function formEdit(){
            let id =  $('#id').val()
            let form = $('#formData');
            let url = "{{ route('subkriteria.update', ":id") }}";
            url = url.replace(':id', parseInt(id));
            $.ajax({
                method: "POST",
                url: url,
                data : form.serialize(),
                success: function(result) {
                    // $('#modalTask').modal('hide');
                    alertSuccess(result.success);
                    location.reload();
                    // table.ajax.reload();
                },
                error: function(error) {
                    if (error.status == 422) {
                        let error_validation = error.responseJSON.errors;
                        // console.log(error.responseJSON.errors);
                        $.each(error_validation, function(field_name, error) {
                            $('#' + field_name).addClass("is-invalid")
                            $('.form-' + field_name.replaceAll(".", "")).html(error);
                        });
                    }
                },
            });
        }
    </script>
@endpush
