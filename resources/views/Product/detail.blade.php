@extends('layouts.main')
@section('title', 'Detail Product')

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
                    <th class="text-bold-500" style="width: 200px;">ID Product</th>
                    <td>: {{$product[0]->product_id}}</td>
                </tr>
                <tr>
                    <th class="text-bold-500" style="width: 200px;">Product Name</th>
                    <td>: {{$product[0]->product_name}}</td>
                </tr>
            </tbody>
        </table>
  </div>
  <div class="card-body">
      <table class="table table-striped" id="table1">
          <thead>
              <tr>
                  <th style="width: 50px;">No</th>
                  <th>Category Name</th>
              </tr>
          </thead>
          <tbody>
              @php $no=1; @endphp
              @foreach($product[0]->categories as $i)
              <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td><a href="{{ route('category.show', $i->id) }}">{{ $i->category_name }}</a></td>
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
