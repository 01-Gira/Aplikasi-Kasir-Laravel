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
                    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#createProduct"><i class="fas fa-plus"></i> Create Product</button>
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
                        <td class="text-center">Brand</td>
                        <td class="text-center">Stock</td>
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
  <div class="modal fade" id="createProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> 
    <form action="/products/index" method="post" enctype="multipart/form-data" id="form-create">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createProductLabel">Create Product</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <input type="text" placeholder="Scan Barcode Here!" class="form-control" name="barcode">
                </div>
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
                    <label for="brand">Assign Brand</label>
                    <select name="brand_id" class="select2 form-control @error('brand')
                        is-invalid
                    @enderror"data-placeholder="Select a brand" id="brand">
                      @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                      @endforeach
                    </select>
                    @error('brand')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" readonly placeholder="Slug" class="form-control @error('slug')
                      is-invalid
                    @enderror" id="slug">
                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                  <label for="stock">Stock</label>
                  <input type="number" name="stock" class="form-control @error('stock')
                    is-invalid
                  @enderror" id="stock">
                  @error('stock')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
                <div class="col-md-12">
                  <label for="price">Price</label>
                  <input type="number" name="price" class="form-control @error('price')
                    is-invalid
                  @enderror" id="price">
                  @error('price')
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


  <div class="modal fade" id="editUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> 
    <form action="/products/index" method="post" id="form-update">
      @csrf
      @method('PUT')
      <input type="text" name="user" id="userId" hidden>
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editUserModalLabel">Edit User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <input type="text" placeholder="Scan Barcode Here!" class="form-control" name="barcode">
                </div>
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
                    <label for="brand">Assign Brand</label>
                    <select name="brand" class="form-control select2 @error('brand')
                        is-invalid
                    @enderror"data-placeholder="Select a brand" id="brand">
                      {{-- @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                      @endforeach --}}
                    </select>
                    @error('brand')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" readonly placeholder="Slug" class="form-control @error('slug')
                      is-invalid
                    @enderror" id="slug">
                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-6">
                  <label for="stock">Stock</label>
                  <input type="number" name="stock" class="form-control @error('stock')
                    is-invalid
                  @enderror" id="stock">
                  @error('stock')
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
    // $(document).ready(function(){
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
          ajax: '{{ url('/products/dashboard') }}',
          columns: [
            { data: null, name: null, className:'dt-center' },
            { data: 'name', name: 'name', className:'dt-center' },
            { data: 'brand', name: 'brand', className: 'dt-center'},
            { data: 'stock', name: 'stock', className: 'dt-center'},
            { data: 'action' , namae: 'action', className: 'text-center', searchable: false, orderable: false}
          ]
        })

        $('#name').change(function(){
            $.ajax({
                url: '{{ url('/products/slug') }}',
                data: {
                    'name' : $(this).val()
                },
                success: function(response){
                    // console.log(response);
                    $('#slug').val(response.slug);
                },
                error : function(xhr){
                    console.log(xhr.responseText);
                }
            })
        })

        function deleteData(p){
          let token = $('meta[name="csrf-token"]').attr("content");
          console.log(p);
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
              // $('#loading').show();

              if(result.isConfirmed){
                $.ajax({
                  url: '{{ url('/products/index') }}',
                  type :'delete',
                  data : {
                    '_token' : token,
                    'slug' : p
                  },
                  success : function(response) {
                    // $('#loading').hide();
                    tblMaster.ajax.reload();  
                    if(response.indctr == 0){
                      Swal.fire('Success', response.message, 'success');

                    }else {
                      Swal.fire('Danger', response.message, 'error');
                    }
                    
                  },
                  error : function(xhr){
                    $('#loading').hide();
                    Swal.fire('Danger', xhr.responseText, 'error');

                    console.log(xhr.responseText);
                  }
                });
              }else {
                $('#loading').hide();
                    // Batalkan penghapusan
                Swal.fire('Cancelled', 'Deletion cancelled.', 'info');

              }
            
            }).catch(swal.noop)
        }

    // })
    
</script>
@endsection