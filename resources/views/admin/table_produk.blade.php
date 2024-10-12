@extends('template.template_superadmin')
@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include("template.notification")

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total (Produk)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $Products->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Produk (Tersedia)
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $Tersedia }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Produk (Habis)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sold }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content table -->
           <!-- Begin Page Content -->
        <div class="container-fluid">
            <div class="d-flex justify-content-center align-items-center">
                <div class="notifMessage">
                    <span id="cancel"><i class="fa">x</i></span>
                    <form action="/revisi" method="post">
                        @csrf
                    <!-- Name Produk --> 
                    <div class="form-group">
                        <input type="text" class="form-control"  id="product_revisi" readonly/>
                        <input type="hidden" class="form-control" name="produk_id" id="product_id">
                        <input type="hidden" class="form-control" name="user_id" id="product_user">
                    </div>
                        <div class="form-group">
                            <label for="textRevisi">Kirim Pesan Ke Reseller</label>
                            <textarea class="form-control" name="message" rows="3" required></textarea>
                        </div>
                        <input type="hidden" value="reseller" name="tujuan">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Kirim Pesan</button>
                    </form>   
                </div>
        </div>


        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">data table of all your current Reseller</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Reseller</h6>
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
                                <th>Verified</th>
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
                                <th>Verified</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($Products as $Product)
                                 <tr>
                                    @if (is_null($Product->image))
                                    <td><img src="{{asset('img/web/undraw_profile.svg')}}" alt="" class="img-vendor"></td>
                                    @else
                                    <td><img src="{{asset('img/produk/'.$Product->image->image )}}" alt="" class="img-vendor"></td>
                                    @endif
                                    <td>{{$Product->name}}</td>
                                    <td>{{$Product->harga}}</td>
                                    <td>{{ $Product->status->status == "Habis" ? "Habis":"Tersedia"}}</td>
                                    <td>{{$Product->kondisi}}</td>
                                    <td>{{$Product->kategori->name}}</td>
                                    <td><button class="btn btn-sm btn-{{ $Product->verified == true ? "success":"danger"}}">{{ $Product->verified == true ? "verified":"pending"}}</button></td>
                                    <td class="revisi_id" data-product-id="{{ $Product->id }}" data-item-id="{{ $Product->name }}" data-user-id="{{ $Product->user_id }}">
                                        <div class="d-flex mb-1">
                                            <a href= "{{ url('products/' . $Product->name . '/' . $Product->id . '/show') }}" rel="noopener noreferrer">
                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button>
                                            </a> | 
                                            <form action="/Verified" method="post">
                                                @csrf
                                                <input type="text" hidden value="{{ $Product->id }}" name="id">
                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-retweet"></i></button>
                                            </form>
                                        </div>
                                        <div class="d-flex">
                                            <form action="{{ route('delete-product.admin') }}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{ $Product->id }}" name="id">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete()"><i class="fa fa-trash"></i></button>
                                            </form> | 
                                            <button type="submit" class="btn btn-{{ $Product->revisi == 1? "warning": "success"}} btn-sm revisi"><i class="fa fa-pen-fancy"></i></button>
                                        </div>
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

    </div>
    <!-- /.container-fluid -->

    <script>
        function confirmDelete() {
            if (confirm("Yakin Ingin Menghapus?")) {
                // Jika pengguna mengonfirmasi, kirim formulir
                document.getElementById('delete-product').submit();
            }else {
                // Jika pengguna membatalkan, hentikan pengiriman formulir
                event.preventDefault();
            }
            // Jika pengguna membatalkan, tidak ada tindakan yang diambil
        }
    </script>
@endsection
