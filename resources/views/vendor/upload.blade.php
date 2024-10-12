@extends('template.template_admin') @section('container')
<!-- Begin Page Content -->
@include("template.notification")
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Upload Produk</h1>
    </div>

    <!--  Upload Produk -->
    <div class="container-fluid">
        <form action="/Upload" method="post" enctype="multipart/form-data">
            @csrf
            <!-- Nama Produk -->
            <div class="form-group">
                <label for="namaProduk">Nama Produk @error("name")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : (old('name') ? 'is-valid' : '') }}" name="name" id="name" value="{{ $errors->has('name') ? '' : old('name')}}"/>
            </div>

            <!-- User Id -->
            <input type="hidden" value="{{ auth()->user()->id }}" name="user_id"/>

            <!-- Harga Produk-->
            <div class="form-group">
                <label for="harga">Harga @error("harga")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                <input value="{{ $errors->has('harga') ? '' : old('harga')}}" type="number" class="form-control {{ $errors->has('harga') ? 'is-invalid' : (old('harga') ? 'is-valid' : '') }}" id="harga" name="harga"/>
            </div>

            <!-- Kondisi  Produk -->
            <div class="form-group">
                <label for="kondisi">Kondisi</label>
                <select id="kondisi" class="form-control" name="kondisi">
                        <option value="Baru">Baru</option>
                        <option value="Bekas">Bekas</option>
                </select>
            </div>

            <!-- Kondisi  Produk -->
            <div class="form-group">
                <label for="alamat">Provinsi </label>
                <select id="alamat" class="form-control" name="alamat">
                    @foreach ($Provinsis as $provinsi)
                        <option value="{{ $provinsi }}">{{ $provinsi }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kategori  Produk -->
            <div class="form-group">
                <label for="inputState">Kategori</label>
                <select id="inputState" class="form-control" name="kategori_id">
                    @foreach ($Categories as $categori)
                        <option value="{{ $categori->id }}">{{ $categori->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- File Upload -->
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Image @error("image")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>

                    <div class="container_upload">

                        <div class="card_upload">
                            <img id="preview" src="" alt="Image Preview" style="display:none;">
                            <button class="container-btn-file bg-primary">
                                Image1
                                <input type="file" class="file-input" name="image" accept="image/*" required>
                            </button>
                        </div>

                        <div class="card_upload">
                            <img id="preview" src="" alt="Image Preview" style="display:none;">
                            <button class="container-btn-file bg-primary">
                                Image2
                                <input type="file" class="file-input" name="imageSatu" accept="image/*">
                            </button>
                        </div>

                        <div class="card_upload">
                            <img id="preview" src="" alt="Image Preview" style="display:none;">
                            <button class="container-btn-file bg-primary">
                                Image3
                                <input type="file" class="file-input" name="imageDua" accept="image/*">
                            </button>
                        </div>

                        <div class="card_upload">
                            <img id="preview" src="" alt="Image Preview" style="display:none;">
                            <button class="container-btn-file bg-primary">
                                Image4
                                <input type="file" class="file-input" name="imageTiga" accept="image/*">
                            </button>
                        </div>

                    </div>
            </div>


            <!-- Descripsi -->  
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Descripsi @error("descripsi")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                <input id="descripsi" type="hidden" name="descripsi" value="{{ $errors->has('descripsi') ? '' : old('descripsi')}}">
                <trix-editor input="descripsi"></trix-editor>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
</div>
<!-- /.container-fluid -->
<script>


function previewImages() {
    // Ambil semua input file dan gambar preview
    const fileInputs = document.querySelectorAll(".file-input");
    const imagePreviews = document.querySelectorAll("#preview");

    // Sembunyikan semua preview gambar terlebih dahulu
    imagePreviews.forEach(element => {
        element.style.display = "none";
    });

    // Iterasi melalui setiap input file
    fileInputs.forEach((input, index) => {
        const file = input.files[0]; // Ambil file dari input

        if (file && index < imagePreviews.length) { // Pastikan file ada dan index dalam batasan
            const reader = new FileReader();
            
            // Event handler ketika file selesai dibaca
            reader.onload = function(event) {
                const preview = imagePreviews[index];
                preview.src = event.target.result;
                preview.style.display = "block"; // Tampilkan gambar
            };

            reader.readAsDataURL(file); // Bacalah file sebagai Data URL
        }
    });
}   


    // Tambahkan event listener ke semua input file
    document.querySelectorAll(".file-input").forEach(input => {
        input.addEventListener('change', previewImages);
    });




</script>
@endsection
