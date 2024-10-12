@extends('template.template_superadmin')
@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include("template.notification")
        <h3 class="{{ $Status == true ? "text-success":"text-danger"}} text-center"> {{ $Status == true ? "verified":"pending"}}</h3>
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

            <form action="/change" method="post" class="mt-4">
                @csrf
                <input type="hidden" name="id" value="{{ $Data->user_id }}">
                <button data-mdb-ripple-init class="btn btn-primary btn-block btn-lg gradient-custom-4 text-white" type="submit">Change Status</button>
            </form>

             <form id="delete-form" action="/destroyUser" method="post" class="mt-4">
                @csrf
                <input type="hidden" name="id" value="{{ $Data->id }}">
                <input type="hidden" name="user" value="{{ $Data->user_id }}">
                <button data-mdb-ripple-init class="btn btn-danger btn-block btn-lg gradient-custom-4 text-white" type="submit" onclick="confirmDelete()">Delete Data</button>
            </form>
    </div>
    <!-- /.container-fluid -->

    <script>
        function confirmDelete() {
            if (confirm("Yakin Ingin Menghapus?")) {
                // Jika pengguna mengonfirmasi, kirim formulir
                document.getElementById('delete-form').submit();
            }else {
                // Jika pengguna membatalkan, hentikan pengiriman formulir
                event.preventDefault();
            }
            // Jika pengguna membatalkan, tidak ada tindakan yang diambil
        }
    </script>
@endsection
