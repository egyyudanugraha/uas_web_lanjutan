@extends('layouts.main')
@section('title', 'Dashboard')

@section('head')
<link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-6 col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon purple">
                            <i class="iconly-boldDocument"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Products</h6>
                        <h6 class="font-extrabold mb-0"><a href="{{ route('product.index') }}" class="badge bg-{{ (count($products) < 1 ) ? 'danger' : ((count($products) < 5) ? 'warning' : 'primary') }}">{{ count($products) }} Product</a></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon blue">
                            <i class="iconly-boldCategory"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Categories</h6>
                        <h6 class="font-extrabold mb-0"><a href="{{ route('category.index') }}" class="badge bg-success">{{ count($categories) }} Category</a></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-4 col-md-6">
        <div class="card">
            <div class="card-body px-3 py-4-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="stats-icon green">
                            <i class="iconly-boldHome"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h6 class="text-muted font-semibold">Warehouses</h6>
                        <h6 class="font-extrabold mb-0"><a href="{{ route('warehouse.index') }}" class="badge bg-secondary">{{ count($warehouses) }} Warehouse</a></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Category list with products</h4>
            </div>
            <div class="card-body">
                <!-- <div id="chart-profile-visit"></div> -->
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category Name</th>
                            <th>Product List</th>
                            <th>Product Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach($category_product as $p)
                        <tr>
                            <td class="text-center">{{ $no++ }}</td>
                            <td><a href="{{ route('category.show', $p->id) }}">{{ $p->category_name }}</a></td>
                            <td>
                                @if(count($p->products) == 0)
                                    <i>No products found</i>
                                @else
                                <ul class="ulcustom">
                                    @foreach($p->products as $r)
                                        <li>
                                            <a href="{{ route('product.show', $r->product_id) }}">{{ $r->product_name }}</a>
                                        </li>
                                        @if( $loop->iteration == 3)
                                            @break
                                        @endif
                                    @endforeach
                                </ul>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ (count($p->products) < 1) ? 'danger' : ((count($p->products) < 3) ? 'warning' : 'success') }}">{{ count($p->products) }} Products</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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