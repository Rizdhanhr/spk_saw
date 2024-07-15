@extends('layouts.main')
@section('title', 'Edit Role')
@section('page_title', 'Edit Role')
@section('button')

@endsection
@section('content')
    <div class="container-xl">
        <div class="card mb-4">
            {{-- <div class="card-header">
            <a type="button" href="{{ route('user.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
        </div> --}}
            <div class="card-body">
                <form method="POST" action="{{ route('role.update',$role->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name',$role->name) }}">
                        <span style="color:red;">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Description</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" name="description"
                            value="{{ old('description',$role->description) }}">
                        <span style="color:red;">
                            @error('description')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Access</label>
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="3%"></th>
                                        <th>Group</th>
                                        <th width="70%">Permission</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($module as $m)
                                        <tr>
                                            <td>
                                                <input class="form-check-input parentCheck" type="checkbox" data-size="xs" onchange="toggleChildCheckboxes(this)">
                                            </td>
                                            <td>
                                                <h3>{{ $m->name }}</h3>
                                            </td>
                                            <td>
                                                @foreach ($m->permission as $pm)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input childCheckbox" name="permission[]" value="{{ $pm->id }}" type="checkbox" onchange="updateParentCheckbox(this)"
                                                        {{ in_array($pm->id,$role->permission()->pluck('permission_id')->toArray()) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="inlineCheckbox1">{{ strtoupper($pm->slug) }}</label>
                                                    </div>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <a type="button" href="{{ route('role.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>

    $(document).ready(function () {
        $('#example').DataTable();
    });

    function toggleChildCheckboxes(checkbox) {
        var isChecked = checkbox.checked;
        // Find all child checkboxes in the same row
        var childCheckboxes = checkbox.closest('tr').querySelectorAll('.childCheckbox');
        // Set the state of each child checkbox based on the parent checkbox
        childCheckboxes.forEach(function(childCheckbox) {
            childCheckbox.checked = isChecked;
        });
    }

    function updateParentCheckbox(checkbox) {
        var parentCheckbox = checkbox.closest('tr').querySelector('.parentCheck');
        // Find all child checkboxes in the same row
        var childCheckboxes = checkbox.closest('tr').querySelectorAll('.childCheckbox');
        var allChecked = true;
        // Check if all child checkboxes are checked
        childCheckboxes.forEach(function(childCheckbox) {
            if (!childCheckbox.checked) {
                allChecked = false;
            }
        });
        // Update the state of the parent checkbox based on child checkboxes
        parentCheckbox.checked = allChecked;
    }
</script>
@endpush
