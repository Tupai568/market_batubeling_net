@extends('template.template_admin')
@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include("template.notification")

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Like Product</h1>
            @if (Auth::user()->user_type == 'guest')
            <a href="{{ route('data') }}">
                <but ton class="btn btn-primary mt-2">Daftar Reseller</button>
            </a>
            @endif
        </div>

        <!-- Content table -->
           <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">data table of all your current like products</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Like Products</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Condition</th>
                                <th>Categories</th>
                                <th>Show</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Condition</th>
                                <th>Categories</th>
                                <th>Show</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($favorits as $favorit)
                                <tr>
                                    <td><img src="{{asset('img/produk/'.$favorit->image->image )}}" alt="" class="img-vendor"></td>
                                    <td>{{$favorit->name}}</td>
                                    <td>{{$favorit->harga}}</td>
                                    <td>{{ $favorit->status->status == "Habis" ? "Habis":"Tersedia"}}</td>
                                    <td>{{$favorit->kondisi}}</td>
                                    <td>{{$favorit->kategori->name}}</td>
                                    <td>
                                        <a href="{{ route("detail-product", ["name" => $favorit->name, "id" => $favorit->id]) }}">
                                            <button type="submit" class="btn btn-warning btn-sm">Show</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection
