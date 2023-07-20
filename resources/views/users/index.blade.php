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
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                
              </div>
              <div class="card-body">
                <canvas id="newUser"></canvas>
              </div>
              <div class="card-footer"></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                
              </div>
              <div class="card-body"></div>
              <div class="card-footer"></div>
            </div>
          </div>
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header">
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-4 col-lg-3 col-md-6">
                    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#createUserModal"><i class="fas fa-plus"></i> Create User</button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-stripped " id="tblMaster">
                    <thead>
                      <tr>
                        <td class="text-center">No</td>
                        <td class="text-center">Name</td>
                        <td class="text-center">Email</td>
                        <td class="text-center">Role</td>
                        <td class="text-center">Action</td>
                      </tr>
                    </thead>
                    <tbody>
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
  <div class="modal fade" id="createUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> 
    <form action="/users/index" method="post" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createUserModalLabel">Create User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name')
                        is-invalid
                    @enderror" placeholder="Name" name="name">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="email">Email</label>
                    <input type="text" class="form-control @error('email')
                        is-invalid
                    @enderror" placeholder="Email" name="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                  <label for="image">Image</label>
                  <input type="file" name="image" class="form-control @error('image')
                    is-invalid
                  @enderror" id="image">
                  @error('image')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
                <div class="col-md-6">
                    <label for="phoneNo">Phone Number</label>
                    <input type="text" class="form-control @error('phoneNo')
                        is-invalid
                    @enderror" placeholder="phoneNo" name="phoneNo">
                    @error('phoneNo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="imagePreview">Image Preview</label>
                    <img id="imagePreview" src="#" alt="Img Preview" class="img-thumbnail">
                </div>
                <div class="col-md-6">
                    <label for="address">Address</label>
                    <textarea name="address" class="form-control @error('address')
                        is-invalid
                    @enderror" cols="30" rows="10" placeholder="Address"></textarea>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-12">
                  <label for="role">Assign Role</label>
                  <select name="role" class="form-control select2"data-placeholder="Select a Role">
                    @foreach ($roles as $role)
                      <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-12">
                  <label for="permission">Assign Permission</label>
                  <select name="permission[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Permission">
                    <option value="admin">Admin</option>
                    <option value="cashier">Cashier</option>
                  </select>
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
{{-- 

  <div class="modal fade" id="editUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> 
    <form action="/users/index/update" method="put" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <input type="text" >
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editUserModalLabel">Create User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name')
                        is-invalid
                    @enderror" placeholder="Name" name="name" id="name">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="email">Email</label>
                    <input type="text" class="form-control @error('email')
                        is-invalid
                    @enderror" placeholder="Email" name="email" id="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                  <label for="image">Image</label>
                  <input type="file" name="image" class="form-control" id="imageEdit">
                  @error('image')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
                <div class="col-md-6">
                    <label for="phoneNo">Phone Number</label>
                    <input type="text" class="form-control @error('phoneNo')
                        is-invalid
                    @enderror" placeholder="phoneNo" name="phoneNo" id="phoneNo">
                    @error('phoneNo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="imagePreview">Image Preview</label>
                    <img id="imagePreviewEdit" src="#" alt="Img Preview" class="img-thumbnail">
                </div>
                <div class="col-md-6">
                    <label for="address">Address</label>
                    <textarea name="address" class="form-control @error('address')
                        is-invalid
                    @enderror" cols="30" rows="10" placeholder="Address" id="address"></textarea>
                    @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-12">
                  <label for="role">Assign Role</label>
                  <select name="role" class="form-control select2"data-placeholder="Select a Role">
                    @foreach ($roles as $role)
                      <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-12">
                  <label for="permission">Assign Permission</label>
                  <select name="permission[]" class="form-control select2" multiple="multiple" data-placeholder="Select a Permission">
                    <option value="admin">Admin</option>
                    <option value="cashier">Cashier</option>
                  </select>
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
  </div> --}}
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
      ajax: '{{ url('/users/dashboard') }}',
      columns: [
        { data: null, name: null, className: 'text-center'},
        { data: 'name', name: 'name', className: 'text-center'},
        { data: 'email', name: 'email', className: 'text-center'},
        { data: 'role', name: 'role', className: 'text-center'},
        { data: 'action' , namae: 'action', className: 'text-center', searchable: false, orderable: false}
      ]
    });

    var newUser = $('#newUser');

    new Chart(newUser, {
      type: 'bar',
      data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
          label: '# of Votes',
          data: [12, 19, 3, 5, 2, 3],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    $('#image').on('change', function(e){
      var file = e.target.files[0];
      if(file){
        var reader = new FileReader();
        reader.onload = function(e){
          $('#imagePreview').attr('src', e.target.result);
        }
        reader.readAsDataURL(file);
      }
    });

  });
 

</script>
@endsection