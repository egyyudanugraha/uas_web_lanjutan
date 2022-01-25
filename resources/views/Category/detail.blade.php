@extends('layouts.main')
@section('title', 'Detail Category')

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
                    <th class="text-bold-500" style="width: 200px;">Category Name</th>
                    <td>: {{$category[0]->category_name}}</td>
                </tr>
            </tbody>
        </table>
  </div>
  <div class="card-body">
      <table class="table table-striped" id="table1">
          <thead>
              <tr>
                  <th>No</th>
                  <th>ID Product</th>
                  <th>Product Name</th>
              </tr>
          </thead>
          <tbody>
              @php $no=1; @endphp
              @foreach($category[0]->products as $i)
              <tr>
                  <td class="text-center">{{ $no++ }}</td>
                  <td>{{ $i->product_id }}</td>
                  <td><a href="{{ route('product.show', $i->product_id) }}">{{ $i->product_name }}</a></td>
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
