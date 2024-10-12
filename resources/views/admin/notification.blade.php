@extends('template.template_superadmin')
@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include("template.notification")

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Pesan Notifikasi</h1>
        </div>

        <div class="d-flex justify-content-center align-items-center">
            <div class="notifMessage">
                <span id="cancel"><i class="fa">x</i></span>
                <form action="/delete/notification" method="post">
                    @csrf
                    <input type="hidden" value="{{ $message->id }}" name="id">
                    <input type="hidden" value="{{ $message->user_id }}" name="user_id">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Kirim Pesan Ke Reseller</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="3" required></textarea>
                    </div>
                    <input type="hidden" value="reseller" name="tujuan">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Kirim Pesan</button>
                </form>   
            </div>

            <div class="confirmBanner">
                <span id="cancel"><i class="fa">x</i></span>
                <form action="/confirm/banner" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $message->id }}" name="id">
                    <input type="hidden" value="{{ $message->user_id }}" name="user_id">
                    @error("image")<span class="text-danger ml-2 custom-text-invalid text-center">{{ $message }}</span>@enderror
                    <div class="form-group">
                        <label for="file">Banner</label>
                        <input class="form-control" type="file" id="file" name="image">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Kirim Pesan Ke Reseller</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="3" required></textarea>
                    </div>
                    <input type="hidden" value="reseller" name="tujuan">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Add Banner</button>
                </form>   
            </div>
        </div>

        <!-- Content table -->
           <!-- Begin Page Content -->
        <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        @if ($product)
                        <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Condition</th>
                                    <th>Categories</th>
                                    <th>Actions</th>
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
                                    <th>Actions</th>
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
                                        <td class="d-flex">
                                            @if (!$unggulan)
                                                <form action="/store/unggulan" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{ $message->user_id }}" name="user_id">
                                                    <input type="hidden" value="{{ $product->id }}" name="produk_id">
                                                    <button type="submit" class="btn btn-success">Confirm</button>
                                                </form>    
                                                <button type="submit" class="btn btn-danger ml-2" id="notifCancel">Cancel</button>
                                            @endif
                                        </td> 
                                    </tr>
                            </tbody>
                        @else
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Store</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Store</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $merchant->name }}</td>
                                        <td class="d-flex">
                                                <button type="submit" class="btn btn-success" id="confirmBanner">Confirm</button>
                                                <button type="submit" class="btn btn-danger ml-2" id="notifCancel">Cancel</button>
                                        </td> 
                                    </tr>
                            </tbody>
                        @endif
                        </table>
                    </div>
                </div>
            </div>

        <h1 class="h3 mb-0 text-gray-800 text-center">Bukti Pembayaran Iklan</h1>
        
        <img src="{{ asset("img/promo/$message->image") }}" alt="Bukti Pembayaran" id="image_pembayaran">


    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- /.container-fluid -->
@endsection
