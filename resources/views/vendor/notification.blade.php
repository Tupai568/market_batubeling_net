@extends('template.template_admin')
@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include("template.notification")

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pesan Notifikasi</h1>
        </div>
        @if ($message->image)
            @if ($message->submit == "cancel")
                <div class="text-danger fs-3 bg-white p-4">
                    {{ $message->message }}
                </div>
            @else
                <div class="text-success fs-3 bg-white p-4">
                    {{ $message->message }}
                </div>
            @endif
        @endif

        <!-- Content table -->
           <!-- Begin Page Content -->
        <div class="container-fluid">
        <!-- DataTales Example -->
        @if ($message->action == "product")
            <div class="card shadow mb-4">
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
                                    @if ($product->revisi == 1)
                                    <th>Action</th>
                                    @endif

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
                                    @if ($product->revisi == 1)
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </tfoot>
                            <tbody>
                                    <tr>
                                        @if (is_null($product->image))
                                        <td><img src="{{asset('img/web/undraw_profile.svg')}}" alt="" class="img-vendor"></td>
                                        @else
                                        <td><img src="{{asset('img/produk/'.$product->image->image )}}" alt="" class="img-vendor"></td>
                                        @endif
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->harga}}</td>
                                        <td>{{ $product->status->status == "Habis" ? "Habis":"Tersedia"}}</td>
                                        <td>{{$product->kondisi}}</td>
                                        <td>{{$product->kategori->name}}</td>
                                    @if ($product->revisi == 1)
                                        <td><a href="{{ url("Reseller/".$product->id."/edit") }}">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        </a></td>
                                    @endif

                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif


        @if ($message->image)
        @if ($message->submit == "cancel")
            <h1 class="h3 mb-0 text-danger text-center">Pembayaran Anda Di Tolak</h1>
            <img src="{{ asset("img/promo/$message->image") }}" alt="Bukti Pembayaran" id="image_pembayaran">
        @else
            <h1 class="h3 mb-0 text-success text-center">Pembayaran Anda Berhasi</h1>
            <img src="{{ asset("img/promo/$message->image") }}" alt="Bukti Pembayaran" id="image_pembayaran">
        @endif
        @else
            @if ($message->action == "data")
                <p class="text-danger fs-3 bg-white p-4">
                {!! $message->message !!}
                </p>
            @else
                <p class="text-danger fs-3 bg-white p-4">
                    {{ $message->message }}
                </p>
            @endif
        @endif


    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- /.container-fluid -->
@endsection
