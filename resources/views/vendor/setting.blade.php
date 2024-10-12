@extends('template.template_admin') @section('container')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center mb-4">
        <h1 class="sm text-gray-800">Setting Data </h1>

        @if ($Data !== null)
        @if (auth()->user()->status == 0)
            <div class="alert alert-warning ml-2" role="alert">
                Data Sedang Ditinjau
            </div>
        @else
            <div class="alert alert-success ml-2" role="alert">
                Verified
            </div>
        @endif
        @endif
    </div>
    @include("template.notification")

    <!--  Setting Data -->
    <div class="container-fluid">
        @if ($Data !== null)
            <form>
                <!-- Nik -->
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input value="{{ $Data->nik }}" type="number" class="form-control" readonly />
                </div>

                <!-- File Upload -->
                <div class="form-group">
                    <label for="file" class="form-label d-block">Image KTP </label>
                    <img src="{{asset("img/ktp/".$Data->image)}}"  class="mt-2 " style="width: 150px; height: 100px;"/>
                </div>

                <!-- Whatsapp -->
                <div class="form-group">
                    <label for="whatsapp">Whatsapp</label>
                    <input type="number" class="form-control" name="whatsapp" id="whatsapp" value="{{ $Data->whatsapp}}" readonly/>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control" name="alamat" id="alamat" value="{{ $Data->alamat}}" readonly/>
                </div>
            </form>   
        @else
            <form action="/Setting/Data" method="post" enctype="multipart/form-data">
                @csrf
                <!-- User Id -->
                <input type="hidden" value="{{ auth()->user()->id }}" name="user_id"/>

                <!-- Nik -->
                <div class="form-group">
                    <label for="nik">NIK @error("nik")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                    <input type="number" class="form-control {{ $errors->has('nik') ? 'is-invalid' : (old('nik') ? 'is-valid' : '') }}" name="nik" id="nik" value="{{ $errors->has('nik') ? '' : old('nik')}}"/>
                </div>

                <!-- File Upload -->
                <div class="form-group">
                    <label for="file" class="form-label">Image KTP @error("image")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                    <input class="form-control" type="file" id="file" name="image" onchange="previewImage()">
                    <img id="preview" class="mt-2" />
                </div>

                <!-- Whatsapp -->
                <div class="form-group">
                    <label for="whatsapp">Whatsapp @error("whatsapp")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                    <input type="number" class="form-control {{ $errors->has('whatsapp') ? 'is-invalid' : (old('whatsapp') ? 'is-valid' : '') }}" name="whatsapp" id="whatsapp" value="{{ $errors->has('whatsapp') ? '' : old('whatsapp')}}"/>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label for="alamat">Alamat Address @error("alamat")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                    <input type="text" class="form-control {{ $errors->has('alamat') ? 'is-invalid' : (old('alamat') ? 'is-valid' : '') }}" name="alamat" id="alamat" value="{{ $errors->has('alamat') ? '' : old('alamat')}}"/>
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
