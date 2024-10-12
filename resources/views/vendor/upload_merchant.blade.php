@extends('template.template_admin') @section('container')
<!-- Begin Page Content -->
@include("template.notification")
<div class="container-fluid">
      @if ($Data !== null)
      <div class="container_promo">
             <div class="cild_promo">
                 <i class="fa" id="cancel">x</i>
                 <h4 class="mb-3 text-dark font-weight-bold">Profil Toko Anda Akan Diiklan Kan</h4>
                 <form action="/add/banner" method="post" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" value="{{ auth()->user()->id }}" name="user_id">
 
                     <p class="text-center">Masukkan Bukti Pembayaran Ke Rekening</p>
                     <p class="text-center">BCA: 81468253854676</p>
 
                     <!-- File Upload -->
                    @error("image")<span class="text-danger ml-2 custom-text-invalid text-center">{{ $message }}</span>@enderror
                     <div class="form-group">
                         <input class="form-control" type="file" name="image">
                     </div>
                 <button type="submit" class="btn btn-primary mt-2 w-100">Submit</button>
                 </form>
             </div>
     </div>
      @endif
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Profil Merchant</h1>
        @if ($Data !== null)
            @if ($Baners->count() < 3)
                @if (!$Ready)
                    <button class="btn btn-primary" id="addBaner">add iklan</button>
                @endif
            @endif
        @endif
    </div>

    <!--  Upload Produk -->
    <div class="container-fluid">
        @if ($Data !== null)
            <div class="reseller_store">
                <img src="{{ asset("img/baner/".$Data->baner) }}" alt="" class="image_reseller">
                <div class="shadow_reseller"></div>
                <div class="cild_reseller_store">
                    <img src="{{ asset("img/profil/".$Data->profil) }}" alt="">
                    <h3>{{ $Data->name }}</h3>
                    <p>{{ auth()->user()->membership }}</p>
                </div>
            </div>

            <form action="/edit/store/{{ $Data->id }}" method="post" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="namaProduk">Nama Toko @error("name")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : (old('name') ? 'is-valid' : '') }}" name="name" id="name" value="{{ $Data->name }}"/>
                </div>

                <!-- File Upload -->
                <div class="form-group">
                    <label for="profil" class="form-label">Image Profil @error("profil")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                    <input class="form-control" type="file"  name="profil"">
                </div>

                <!-- File Upload -->
                <div class="form-group">
                    <label for="baner" class="form-label">Image Baner @error("baner")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                    <input class="form-control" type="file" id="file" name="baner" onchange="previewImage()">
                </div>

                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
        @else
            <form action="/upload/store/profil" method="post" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="namaProduk">Nama Toko @error("name")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : (old('name') ? 'is-valid' : '') }}" name="name" id="name" value="{{ $errors->has('name') ? '' : old('name')}}"/>
                </div>

                <!-- File Upload -->
                <div class="form-group">
                    <label for="profil" class="form-label">Image Profil @error("profil")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                    <input class="form-control" type="file"  name="profil"">
                </div>

                <!-- File Upload -->
                <div class="form-group">
                    <label for="baner" class="form-label">Image Baner @error("baner")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                    <input class="form-control" type="file" id="file" name="baner" onchange="previewImage()">
                    <img id="preview" class="mt-2" />
                </div>

                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
        @endif
    </div>
</div>
<!-- /.container-fluid -->
<script>
    const imgPreview = document.getElementById("preview");

    imgPreview.style.display = "none";

    function previewImage() {
        const image = document.getElementById("file");
        const imgPreview = document.getElementById("preview");

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
