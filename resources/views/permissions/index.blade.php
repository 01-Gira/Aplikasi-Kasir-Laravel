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
                    <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#createPermissionsModal"><i class="fas fa-plus"></i> Create Permissions</button>
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
  <div class="modal fade" id="createPermissionsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createPermissionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <form action="/permissions/index" method="post">
     @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createPermissionsModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-stripped">
                        <thead>
                            <tr class="text-center">
                                <td >Name</td>
                                <td>Display Name</td>
                                <td>Description</td>
                                <th class="text-center" style="width: 2%;">
                                    <button type="button" class="btn btn-default btn-xs" id="btn-add-row"><span class="fa fa-plus"></span></button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="t2"></tbody>
                    </table>
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
        ajax: '{{ url('/permissions/dashboard') }}',
        columns: [
            { data: null, name: null, className: 'text-center'},
            { data: 'name', name: 'name', className: 'text-center'},
            { data: 'description', name: 'description', className: 'text-center'},
            { data: 'action' , namae: 'action', className: 'text-center', searchable: false, orderable:false}
        ]
        });

        $('#btn-add-row').on('click', function(){
            addRowDock();
        });

        
        function addRowDock() {
            rows = $('#tblMaster tbody tr').length;
            rows = rows + 1;

            $('#t2').append('\
            <tr>\
                <td>\
                    <input type="text" class="form-control" name="name[]" required>\
                </td>\
                <td>\
                    <input type="text" class="form-control" name="display_name[]" required>\
                </td>\
                <td>\
                    <input type="text" class="form-control" name="description[]" required>\
                </td>\
                <td class="no-padd">\
                    <center><button type="button" class="btn btn-danger btn-xs mg-top-3" id="btn-delete-row-cycle"><i class="fa fa-trash"></i></button></center>\
                </td>\
            \
            </tr>').children(':last');
        }

      
        $("#tblMaster tbody").on("click", "button", function()  {
            $(this).closest("tr").remove();
        });


    
    });
</script>
@endsection