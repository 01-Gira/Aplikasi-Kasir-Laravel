@extends('layouts.layout')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Index</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Index</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        @include('components._flash')
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-4 col-lg-3 col-md-6">
                    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#createRoleModal"><i class="fas fa-plus"></i> Create Role</button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-stripped" id="tblMaster">
                    <thead>
                      <tr>
                        <td class="text-center">No</td>
                        <td class="text-center">Name</td>
                        <td class="text-center">Description</td>
                        <td class="text-center">Action</td>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 0; ?>
                      {{-- 
                      @foreach ($users as $user)
                      <tr>
                        <td class="text-center">{{ ++$no }}</td>
                        <td class="text-center">{{ $user->name }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{{ $user->role }}</td>
                        <td class="text-center"></td>
                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-warning mr-2"><i class="fas fa-pencil"></i></button>
                          <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                      </tr>
                      @endforeach
                     --}}
                    </tbody>
                  </table>
                </div>
              
              </div>
              <div class="card-footer"></div>
            </div>
          </div>
        </div>
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  {{-- Modal --}}
  <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form action="/roles/index" method="post">
     @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createRoleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name')
                        is-invalid
                    @enderror" placeholder="Role Name" name="name">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="display_name">Display Name</label>
                    <input type="text" class="form-control @error('display_name')
                        is-invalid
                    @enderror" placeholder="Display Name" name="display_name">
                    @error('display_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="description">Role Description</label>
                    <textarea name="description" class="form-control @error('description')
                        is-invalid
                    @enderror" cols="30" rows="10" placeholder="Role Description"></textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </div>
    </form>

    </div>
  </div>
  {{-- Modal END --}}



@endsection
@section('script')
<script>
  $(document).ready(function(){
        var tblMaster = $('#tblMaster').DataTable({
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": [0],
            render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }
        }],
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        "iDisplayLength": 10,
        processing: true,
        responsive: true,
        "oLanguage": {
            'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
        },
        serverSide:true,
        ajax: '{{ url('/roles/dashboard') }}',
        columns: [
            { data: null, name: null, className: 'text-center'},
            { data: 'name', name: 'name', className: 'text-center'},
            { data: 'description', name: 'description', className: 'text-center'},
            { data: 'action' , namae: 'action', className: 'text-center', searchable: false, orderable:false}
        ]
        });
    });
</script>
@endsection