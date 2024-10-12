@extends('template.template_admin')
@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include("template.notification")

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Featured Product</h1>
        </div>

        <!-- Content table -->
           <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">data table of all your current featured products</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Featured Products</h6>
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
                                <th>Verified</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Condition</th>
                                <th>Verified</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($Products as $Produk)
                                <tr>
                                    <td><img src="{{asset('img/produk/'.$Produk->produk->image->image )}}" alt="" class="img-vendor"></td>
                                    <td>{{$Produk->produk->name}}</td>
                                    <td>{{$Produk->produk->harga}}</td>
                                    <td>{{ $Produk->produk->status_id == 2 ? "Habis":"Tersedia"}}</td>
                                    <td>{{$Produk->produk->kondisi}}</td>
                                    <td>{{ $Produk->produk->verified == true ? "verified":"pending"}}</td>
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
</script>
@endsection
