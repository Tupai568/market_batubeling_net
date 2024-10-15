@extends('template.template_admin') @section('container')
<!-- Begin Page Content -->
@include("template.notification")
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Produk</h1>
    </div>

    <!--  Upload Produk -->
    <div class="container-fluid">
        <form action="{{ route("post-edit-product", ["produk" => $Produk->id]) }}" method="post" enctype="multipart/form-data">
           @csrf
            <!-- Nama Produk -->
            <div class="form-group">
                <label for="namaProduk">Nama Produk  @error("name")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : (old('name') ? 'is-valid' : '') }}" name="name" id="name" value="{{ $Produk->name }}"/>
            </div>

            <!-- Harga Produk-->
            <div class="form-group">
                <label for="harga">Harga @error("harga")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                <input value="{{ preg_replace('/\D/', '', $Produk->harga) }}" type="number" class="form-control {{ $errors->has('harga') ? 'is-invalid' : (old('harga') ? 'is-valid' : '') }}" id="harga" name="harga"/>
            </div>

            <!-- Kondisi  Produk -->
            <div class="form-group">
                <label for="kondisi">Kondisi</label>
                <select id="kondisi" class="form-control" name="kondisi">

                    <!-- Cek Selected -->
                    @if ($Produk->kondisi == "Baru")
                        <option value="Baru" selected>Baru</option>
                    @else
                        <option value="Bekas" selected>Bekas</option>
                    @endif

                    <!-- Sub  Kondisi -->
                    @if ($Produk->kondisi == "Baru")
                        <option value="Bekas">Bekas</option>
                    @else
                        <option value="Baru">Baru</option>
                    @endif

                </select>
            </div>

            <!-- Kategori  Produk -->
            <div class="form-group">
                <label for="inputState">Kategori</label>
                <select id="inputState" class="form-control" name="kategori_id">
                    @foreach ($Categories as $categori)
                    @if ($categori->id == $Produk->kategori_id)
                        <option value="{{ $categori->id }}" selected>{{ $categori->name }}</option>
                    @else
                        <option value="{{ $categori->id }}">{{ $categori->name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="alamat">Provinsi</label>
                <select id="alamat" class="form-control" name="alamat">
                    @foreach ($Provinsis as $provinsi)
                    @if ($provinsi == $Produk->alamat)
                        <option value="{{ $provinsi }}" selected>{{ $provinsi }}</option>
                    @else
                        <option value="{{ $provinsi }}">{{ $provinsi }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <!-- Status Produk -->
            <div class="form-group">
                <label for="inputState">Status</label>
                <select id="inputState" class="form-control" name="status_id">
                    @foreach ($Statuses as $status)
                    @if ($status->id === $Produk->status_id)
                            <option value="{{$status->id}}" selected>{{$Produk->status->status}}</option>
                    @else
                            <option value="{{$status->id}}">{{$Produk->status->status == "Habis" ? "Tersedia":"Habis"}}</option>
                    @endif
                    @endforeach
                </select>
            </div>

              <!-- File Upload -->
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Image @if ($errors->any())<span class="text-danger ml-2 custom-text-invalid ">{{ $errors->first() }}</span>@endif</label>

                    <div class="container_upload">

                        <div class="card_upload">
                            @if ($Produk->image->image)
                            <img id="preview" src="{{asset("img/produk/".$Produk->image->image )}}" alt="Image Preview">
                            @endif
                            <button class="container-btn-file bg-primary">
                                Image1
                                <input type="hidden"  name="OLDimage" value="{{ $Produk->image->image }}">
                                <input type="file" class="file-input" name="image" accept="image/*">
                            </button>
                        </div>

                        <div class="card_upload">
                             @if ($Produk->image->imageSatu)
                            <img id="preview" src="{{asset("img/produk/".$Produk->image->imageSatu )}}" alt="Image Preview">
                            @endif
                            <button class="container-btn-file bg-primary">
                                Image2
                                <input type="hidden"  name="OLDimageSatu" value="{{ $Produk->image->imageSatu }}">
                                <input type="file" class="file-input" name="imageSatu" accept="image/*">
                            </button>
                        </div>

                        <div class="card_upload">
                           @if ($Produk->image->imageDua)
                            <img id="preview" src="{{asset("img/produk/".$Produk->image->imageDua )}}" alt="Image Preview">
                            @endif
                            <button class="container-btn-file bg-primary">
                                Image3
                                <input type="hidden"  name="OLDimageDua" value="{{ $Produk->image->imageDua }}">
                                <input type="file" class="file-input" name="imageDua" accept="image/*">
                            </button>
                        </div>

                        <div class="card_upload">
                            @if ($Produk->image->imageTiga)
                            <img id="preview" src="{{asset("img/produk/".$Produk->image->imageTiga )}}" alt="Image Preview">
                            @endif
                            <button class="container-btn-file bg-primary">
                                Image4
                                <input type="hidden"  name="OLDimageTiga" value="{{ $Produk->image->imageTiga }}">
                                <input type="file" class="file-input" name="imageTiga" accept="image/*">
                            </button>
                        </div>

                    </div>
            </div>


            <!-- Descripsi -->
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Descripsi @error("descripsi")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                <input id="descripsi" type="hidden" name="descripsi" value="{{ $Produk->descripsi }}">
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



    // const imgPreview = document.getElementById("preview");

    // function previewImage() {
    //     const image = document.getElementById("file");
    //     const imgPreview = document.getElementById("preview");

    //     imgPreview.style.display = "block";
    //     const oFReader = new FileReader();
    //     console.log(oFReader);
    //     oFReader.readAsDataURL(image.files[0]);
    //     oFReader.onload = function (oFREvent) {
    //         imgPreview.src = oFREvent.target.result;
    //     };
    // }
</script>
@endsection
