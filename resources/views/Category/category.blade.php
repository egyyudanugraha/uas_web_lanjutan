@extends('layouts.main')
@section('title', 'Category')

@section('head')
<link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
<link rel="stylesheet" href="assets/vendors/toastify/toastify.css">
<link rel="stylesheet" href="assets/vendors/sweetalert2/sweetalert2.min.css">
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
        <button class="btn btn-outline-success float-end" data-bs-toggle="modal" data-bs-target="#tambahCategory">Add @yield('title')</button>
    </div>
    </div>
  </div>
  <div class="card-body">
      <table class="table table-striped" id="table1">
          <thead>
              <tr>
                  <th>No</th>
                  <th>Category Name</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              @php $no=1; @endphp
              @foreach($categories as $c)
              <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ $c->category_name }}</td>
                  <td class="text-center">
                    <form method="POST" action="{{ route('category.destroy', $c->id) }}" data-name="{{$c->category_name}}">
                      @csrf
                      <input name="_method" type="hidden" value="DELETE">
                      <a href="{{route('category.show', $c->id)}}" class="btn iconcustom btn-success" ><i class="bi bi-info-circle-fill"></i></a>
                      <button type="button" id="editCate" class="btn iconcustom btn-primary" data-id="{{$c->id}}" data-bs-toggle="modal" data-bs-target="#editCategory"><i class="bi bi-pencil-square"></i></button>
                      <button type="button" id="deleteCate" class="btn iconcustom btn-danger" data-toggle="tooltip" title='Delete'><i class="bi bi-trash-fill"></i></button>
                    </form>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
</div>
<!-- Modal Tambah Category -->
<div class="modal fade text-left" id="tambahCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel1">Add New Category</h5>
            <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
              <i data-feather="x"></i>
            </button>
          </div>
          <form class="form form-horizontal" id="formAddCategory" action="{{route('category.store')}}" method="POST">
          @csrf
            <div class="modal-body">
              <div class="form-body">
                <div class="row">
                  <div class="col-md-4">
                    <label>Category Name</label>
                  </div>
                  <div class="col-md-8 form-group">
                    <input type="text" name="category_name" class="form-control" placeholder="Category Name" autocomplete="off" required/>
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

<!-- Modal Edit Category -->
<div class="modal fade text-left" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel1">Edit Category</h5>
          <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <form class="form form-horizontal" id="formEditCategory" method="POST">
        @csrf
        @method('PUT')
          <div class="modal-body">
            <div class="form-body">
              <div class="row">
                <div class="col-md-4">
                  <label>Category Name</label>
                </div>
                <div class="col-md-8 form-group">
                  <input type="text" id="editNameCategory" name="category_name" class="form-control" placeholder="Category Name" autocomplete="off" required/>
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
<script>
  $(document).ready(function () {

    $('table').on('click', '#deleteCate', function(e){
        Swal.fire({
        title: 'Are you sure?',
        html: `Are you sure to delete category <b>${e.currentTarget.parentNode.getAttribute("data-name")}</b>?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete category!'
      }).then((result) => {
        if (result.isConfirmed) {
          e.currentTarget.parentNode.submit()
        }
      })
    })
  
  $('body').on('click', '#editCate', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    $.get('category/' + id + '/edit', function (data) {
      $("#formEditCategory").attr('action', 'http://127.0.0.1:8000/category/' + id)
      $('#editNameCategory').val(data.data.category_name);
    })
  });
}); 
</script>
<script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
<script>

  document.getElementById('formAddCategory').addEventListener('submit', (e) => {
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