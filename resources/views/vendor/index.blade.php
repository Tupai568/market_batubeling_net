@extends('template.template_admin')
@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include("template.notification")

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <div class="container_promo">
            <div class="cild_promo">
                <i class="fa" id="cancel">x</i>
                <h4 class="mb-3 text-dark font-weight-bold">Produk Anda Akan Dimasukkan Ke Unggulan</h4>
                <form action="/Promo" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="" name="produk_id" id="ProductId">
                    <input type="hidden" value="admin" name="tujuan">
                    <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">

                    <!-- Name Produk --> 
                    <div class="form-group">
                        <input type="text" class="form-control" name="product" id="product" readonly/>
                    </div>

                    <p class="text-center">Masukkan Bukti Pembayaran Ke Rekening</p>
                    <p class="text-center">BCA: 81468253854676</p>

                    <!-- File Upload -->
                   @error("image")<span class="text-danger ml-2 custom-text-invalid text-center">{{ $message }}</span>@enderror
                    <div class="form-group">
                        <input class="form-control" type="file" id="file" name="image" onchange="previewImage()">
                        <img id="image_promo" class="mt-2" />
                    </div>
                <button type="submit" class="btn btn-primary mt-2 w-100">Submit</button>
                </form>
            </div>
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
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$Products->count()}}</div>
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
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Produk (Sold)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $Habis}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Verified
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$Verified}}</div>
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
                                    Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $Pending }}</div>
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

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">data table of all your current products</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Produk</h6>
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
                            @foreach ($Products as $Produk)
                                <tr>
                                    <td><img src="{{asset('img/produk/'.$Produk->image->image )}}" alt="" class="img-vendor"></td>
                                    <td>{{$Produk->name}}</td>
                                    <td>{{$Produk->harga}}</td>
                                    <td>{{ $Produk->status->status == "Habis" ? "Habis":"Tersedia"}}</td>
                                    <td>{{$Produk->kondisi}}</td>
                                    <td>{{$Produk->kategori->name}}</td>
                                    <td>{{ $Produk->verified == true ? "verified":"pending"}}</td>
                                    <td class="productId" data-product-id="{{ $Produk->id }}" data-item-id="{{ $Produk->name }}">
                                        <div class="d-flex">
                                            <a href="{{ url("Reseller/".$Produk->id."/edit") }}">
                                                <button type="submit" class="btn btn-primary btn-sm mr-1">Edit</button>
                                            </a>

                                            <a href="{{ url("Reseller/".$Produk->id."/Show") }}">
                                                <button type="submit" class="btn btn-warning btn-sm">Show</button>
                                            </a>
                                        </div>
                                        <div class="d-flex mt-1">
                                            @if ($Produk->revisi == 0 && $Produk->verified == 1)
                                            <button type="btn" class="btn btn-success btn-sm mr-1" id="promo"><i class="fas fa-tags "></i></button>
                                            @endif
                                                <form action="delete/product" method="post" id="delete-product">
                                                    @csrf
                                                        <input type="hidden" name="id" value="{{ $Produk->id }}">
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete()">Delete</button>
                                                 </form>
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

    <script>
    const imgPreview = document.getElementById("image_promo");

    imgPreview.style.display = "none";

    function previewImage() {
        const image = document.getElementById("file");
        const imgPreview = document.getElementById("image_promo");

        imgPreview.style.display = "block";
        const oFReader = new FileReader();
        console.log(oFReader);
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function (oFREvent) {
            imgPreview.src = oFREvent.target.result;
        };
    }

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
