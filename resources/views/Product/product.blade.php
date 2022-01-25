@extends('layouts.main')
@section('title', 'Product')

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
        <button class="btn btn-outline-success float-end" id="addProd" data-bs-toggle="modal" data-bs-target="#tambahProduk">Add @yield('title')</button>
    </div>
    </div>
  </div>
  <div class="card-body">
      <table class="table table-striped" id="table1">
          <thead>
              <tr>
                  <th>No</th>
                  <th>ID Product</th>
                  <th>Product Name</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              @php $no=1; @endphp
              @foreach($products as $p)
              <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ $p->product_id }}</td>
                  <td>{{ $p->product_name }}</td>
                  <td class="text-center">
                    <!-- <button onclick="delete_product('{{ $p->product_id }}', '{{ $p->product_name }}')" class="btn btn-sm btn-outline-danger">Delete</button> -->
                    <form method="POST" action="{{ route('product.destroy', $p->product_id) }}" data-name="{{$p->product_name}}" id="formDelete">
                      @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <a href="{{ route('product.show', $p->product_id) }}" class="btn iconcustom btn-success"><i class="bi bi-info-circle-fill"></i></a>
                      <button type="button" id="editProd" class="btn iconcustom btn-primary" data-id="{{$p->product_id}}" data-bs-toggle="modal" data-bs-target="#editProduk"><i class="bi bi-pencil-square"></i></button>
                      <button type="button" id="deleteProd" class="btn iconcustom btn-danger" data-toggle="tooltip" title='Delete'><i class="bi bi-trash-fill"></i></button>
                    </form>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
</div>
<!-- Modal Tambah Produk -->
<div class="modal fade text-left" id="tambahProduk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel1">Add New Product</h5>
            <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
              <i data-feather="x"></i>
            </button>
          </div>
          <form class="form form-horizontal" id="formAddProduct" action="{{route('product.store')}}" method="POST">
          @csrf
            <div class="modal-body" style="height: 300px;">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-4">
                    <label>ID Product</label>
                  </div>
                  <div class="col-md-8 form-group">
                    <input type="text" name="product_id" class="form-control" placeholder="ID Product" value="{{ old('title') }}" autocomplete="off" required/>
                  </div>
                  <div class="col-md-4">
                    <label>Product Name</label>
                  </div>
                  <div class="col-md-8 form-group">
                    <input type="text" name="product_name" class="form-control" placeholder="Product Name" autocomplete="off" required/>
                  </div>
                  <div class="col-md-4">
                    <label>Category</label>
                  </div>
                  <div class="col-md-8 form-group">
                    <select id="listCategory" class="choices form-select multiple-remove" multiple="multiple" name="category[]" required>
                    </select>
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

<!-- Modal Edit Produk -->
<div class="modal fade text-left" id="editProduk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel1">Edit Product</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <form class="form form-horizontal" id="formEditProduct" method="POST">
        @csrf
        @method('PUT')
          <div class="modal-body">
            <div class="form-body">
              <div class="row">
                <div class="col-md-4">
                  <label>ID Product</label>
                </div>
                <div class="col-md-8 form-group">
                  <input type="text" id="editIdProduct" name="product_id" class="form-control" placeholder="ID Product" value="{{ old('title') }}" autocomplete="off" required/>
                </div>
                <div class="col-md-4">
                  <label>Product Name</label>
                </div>
                <div class="col-md-8 form-group">
                  <input type="text" id="editNameProduct" name="product_name" class="form-control" placeholder="Product Name" autocomplete="off" required/>
                </div>
                <div class="col-md-4">
                    <label>Category</label>
                  </div>
                  <div class="col-md-8 form-group">
                    <select id="listCategoryEdit" class="choices form-select multiple-remove" multiple="multiple" name="category[]" required>
                    </select>
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
<script>
  const selectAdd = new Choices('#listCategory', {
    placeholder: true,
    placeholderValue: 'Pick an Strokes record',
    maxItemCount: 4,
    removeItemButton: true
  })

  const selectEdit = new Choices('#listCategoryEdit', {
    placeholder: true,
    placeholderValue: 'Pick an Strokes record',
    maxItemCount: 4,
    removeItemButton: true
  })
  
  const category_item = []

  const load_category = async () => {
    const res = await fetch('http://127.0.0.1:8000/get/list_category')
    res.json().then(data => data.categories.map(x => category_item.push({ value: x.id, label: x.category_name})));
  }

  load_category()
</script>

<script>
  $(document).ready(function () {

    $('table').on('click', '#deleteProd', function(e){
        Swal.fire({
          title: 'Are you sure?',
          html: `Are you sure to delete product <b>${e.currentTarget.parentNode.getAttribute("data-name")}</b>?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete product!'
        }).then((result) => {
          if (result.isConfirmed) {
            e.currentTarget.parentNode.submit()
          }
        })
    })

  $('body').on('click', '#editProd', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
  
    $.get('product/' + id + '/edit', function (data) {
      $("#formEditProduct").attr('action', 'http://127.0.0.1:8000/product/' + id)
        $('#editIdProduct').val(data.data.product_id)//.prop('disabled', true);
        $('#editNameProduct').val(data.data.product_name);
        const value = data.data.categories.map(x => `${x.id}`)

        selectEdit.destroy();
        selectEdit.init();
        selectEdit.setChoices(() => category_item.map( x => ({value: x.value, label: x.label, selected: value.includes(`${x.value}`)})));
    })

  });

  $('body').on('click', '#addProd', function (e) {
      e.preventDefault();
      selectAdd.destroy();
      selectAdd.init();
      selectAdd.setChoices(() => category_item.map( x => ({value: x.value, label: x.label})));
  });

}); 
</script>
<script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
<script>

  document.getElementById('formAddProduct').addEventListener('submit', (e) => {
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