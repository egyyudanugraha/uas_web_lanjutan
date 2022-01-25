@extends('layouts.main')
@section('title', 'Detail warehouse')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
@endsection

@section('subtitle')
  <p class="text-subtitle text-muted">@yield('title')</p>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
      <table class="table mb-0 table-lg">
            <tbody>
                <tr>
                    <th class="text-bold-500" style="width:250px;">Warehouse Name</th>
                    <td>: {{$warehouses[0]->warehouse_name}}</td>
                </tr>
                <tr>
                    <th class="text-bold-500" style="width:250px;">Location</th>
                    <td>: {{$warehouses[0]->location}}</td>
    
                </tr>
            </tbody>
        </table>
  </div>
  <div class="card-body">
      <table class="table table-striped" id="table1">
          <thead>
              <tr>
                  <th>No</th>
                  <th>Product Name</th>
                  <th>Stock</th>
              </tr>
          </thead>
          <tbody>
              @php $no=1; @endphp
              @foreach($inventories as $i)
              <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td><a href="{{ route('product.show', $i->products->product_id) }}">{{ $i->products->product_name }}</a></td>
                  <td>
                    <span class="badge bg-{{ ($i->stock < 1 ) ? 'danger' : (($i->stock < 5) ? 'warning' : 'success') }}">{{ $i->stock }} Item</span>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
</div>
@endsection

@section('utils')
<script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
<script>
    // Simple Datatable
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
@endsection