@extends('layouts.main')
@section('title', 'Inventory')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/toastify/toastify.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/choices.js/choices.min.css') }}" />
@endsection

@section('subtitle')
  <p class="text-subtitle text-muted">Data seluruh @yield('title')</p>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <div class="row justify-content-between">
    <div class="col-4">Data @yield('title')</div>
    <div class="col-4">
        <button class="btn btn-outline-success float-end" id="addInve" data-bs-toggle="modal" data-bs-target="#tambahInventory">Add @yield('title')</button>
    </div>
    </div>
  </div>
  <div class="card-body">
      <table class="table table-striped" id="table1">
          <thead>
              <tr>
                  <th>No</th>
                  <th>Warehouse Name</th>
                  <th>Product Name</th>
                  <th>Stock</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              @php $no=1; @endphp
              @foreach($inventories as $i)
              <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td><a href="{{ route('warehouse.show', $i->warehouses->id) }}">{{ $i->warehouses->warehouse_name }}</a></td>
                  <td><a href="{{ route('product.show', $i->products->product_id) }}">{{ $i->products->product_name }}</a></td>
                  <td>
                      <span class="badge bg-{{ ($i->stock < 1 ) ? 'danger' : (($i->stock < 5) ? 'warning' : 'success') }}">{{ $i->stock }} Item</span>
                  </td>
                  <td class="text-center">
                    <form method="POST" action="{{ route('inventory.destroy', $i->id) }}" data-ware="{{$i->warehouses->warehouse_name}}" data-prod="{{$i->products->product_name}}">
                      @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <a href="{{ route('inventory.show', $i->product_id) }}" class="btn iconcustom btn-success" ><i class="bi bi-info-circle-fill"></i></a>
                      <button type="button" id="editInve" class="btn iconcustom btn-primary" data-id="{{$i->id}}" data-bs-toggle="modal" data-bs-target="#editInventory"><i class="bi bi-pencil-square"></i></button>
                      <button type="button" id="deleteInve" class="btn iconcustom btn-danger" data-toggle="tooltip" title='Delete'><i class="bi bi-trash-fill"></i></button>
                    </form>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
</div>
<!-- Modal Tambah Inventory -->
<div class="modal fade text-left" id="tambahInventory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel1">Add New Inventory</h5>
            <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
              <i data-feather="x"></i>
            </button>
          </div>
          <form class="form form-horizontal" id="formAddInventory" action="{{route('inventory.store')}}" method="POST">
          @csrf
            <div class="modal-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-4">
                    <label>Warehouse Name</label>
                  </div>
                  <div class="col-md-8 form-group">
                  <fieldset class="form-group">
                    <select class="form-select" id="selectWarehouse" name="warehouse_id" required>
                      <option value="">-- Choose Warehouse --</option>
                    </select>
                </fieldset>
                  </div>
                  <div class="col-md-4">
                    <label>Product</label>
                  </div>
                  <div class="col-md-8 form-group">
                  <fieldset class="form-group">
                    <select class="form-select" id="selectProduct" name="product_id" required>
                      <option value="">-- Choose Product --</option>
                    </select>
                </fieldset>
                </div>
                <div class="col-md-4">
                    <label>Stock</label>
                  </div>
                  <div class="col-md-8 form-group">
                    <input type="number" name="stock" class="form-control" placeholder="Stock product" autocomplete="off" required/>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn" data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Cancel</span>
              </button>
              <button type="submit" class="btn btn-primary ml-1" id="btnTambah">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Add</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

<!-- Modal Edit Inventory -->
<div class="modal fade text-left" id="editInventory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel1">Edit Inventory</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <form class="form form-horizontal" id="formEditInventory" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-4">
                    <label>Warehouse Name</label>
                  </div>
                  <div class="col-md-8 form-group">
                  <fieldset class="form-group">
                    <select class="form-select" id="selectWarehouseEdit" name="warehouse_id" required>
                    </select>
                  </fieldset>
                    </div>
                    <div class="col-md-4">
                      <label>Product</label>
                    </div>
                    <div class="col-md-8 form-group">
                    <fieldset class="form-group">
                      <select class="form-select" id="selectProductEdit" name="product_id" required>
                      </select>
                  </fieldset>
                  </div>
                  <div class="col-md-4">
                      <label>Stock</label>
                    </div>
                    <div class="col-md-8 form-group">
                      <input type="number" name="stock" id="stockEdit" class="form-control" placeholder="Stock product" autocomplete="off" required/>
                    </div>
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Cancel</span>
            </button>
            <button type="submit" class="btn btn-primary ml-1" id="btnTambah">
              <i class="bx bx-check d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Save</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@section('utils')
<script src="{{ asset('assets/vendors/toastify/toastify.js') }}"></script>
<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/vendors/choices.js/choices.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-element-select.js') }}"></script>
<script>
  $(document).ready(function () {

    $('table').on('click', '#deleteInve', function(e){
        Swal.fire({
        title: 'Are you sure?',
        html: `Are you sure to delete product <b>${e.currentTarget.parentNode.getAttribute("data-prod")}</b> 
        from warehouse <b>${e.currentTarget.parentNode.getAttribute("data-ware")}</b>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          e.currentTarget.parentNode.submit()
        }
      })
    })
  
    $('body').on('click', '#editInve', function (e) {
      e.preventDefault();
      var id = $(this).data('id');
      $.get('inventory/' + id + '/edit', function (data) {
        $("#formEditInventory").attr('action', 'http://127.0.0.1:8000/inventory/' + id)
        $('#stockEdit').val(data.inventory.stock);

        // Delete all option warehouse
        $('#selectWarehouseEdit').find('option').remove().end().append(new Option('-- Select Warehouse --', ''));
        // Append option
        $.each(data.warehouses, function (i, item) {
          $("#selectWarehouseEdit").append(new Option(item.warehouse_name, item.id));
        });

        // Delete all option product
        $('#selectProductEdit').find('option').remove().end().append(new Option('-- Select Product --', ''));
          // Append option
        $.each(data.products, function (i, item) {
          $("#selectProductEdit").append(new Option(item.product_name, item.id));
        });

        // Set to default value
        $("#selectWarehouseEdit").val(data.inventory.warehouse_id).change();
        $("#selectProductEdit").val(data.inventory.product_id).change();
      })
    });

    $('body').on('click', '#addInve', function (e) {
        e.preventDefault();
        $.get('inventory/create', function (data) {

          // Delete all option warehouse
          $('#selectWarehouse').find('option').remove().end().append(new Option('-- Select Warehouse --', ''));
          // Append option
          $.each(data.warehouses, function (i, item) {
            $("#selectWarehouse").append(new Option(item.warehouse_name, item.id));
          });

          // Delete all option product
          $('#selectProduct').find('option').remove().end().append(new Option('-- Select Product --', ''));
          // Append option
          $.each(data.products, function (i, item) {
            $("#selectProduct").append(new Option(item.product_name, item.id));
          });
      });
    });

}); 
</script>
<script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
<script>

  document.getElementById('formAddInventory').addEventListener('submit', (e) => {
    const btn = document.querySelector('#btnTambah');
    btn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    Processing...`;
    btn.setAttribute('disabled', '');
  });

</script>

@if(session()->has('success'))
<script>
  Toastify({
      text: "{{ session()->get('success') }}",
      duration: 3000,
      backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
  }).showToast();
</script>
@elseif(session()->has('error'))
<script>
  Toastify({
      text: "{{ session()->get('error') }}",
      duration: 3000,
      backgroundColor: "linear-gradient(to right, #de0b0b, #e6c732)",
  }).showToast();
</script>
@endif

@endsection