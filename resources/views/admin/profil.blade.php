@extends('template.template_superadmin')
 @section('container')
<!-- Begin Page Content -->
@include("template.notification")
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil</h1>
    </div>

    <!--  Upload Produk -->
    <div class="container-fluid">
        <form action="/Update/Profil/Admin" method="post">
           @csrf
            <!-- Nama -->
            <div class="form-group">
                <label for="name">Nama</label>
                <input value="{{ auth()->user()->name }}" type="text" class="form-control" name="name" id="name" readonly />
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input value="{{ auth()->user()->email }}" type="email" class="form-control" name="email" id="email" readonly/>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="old">Old Password</label>
                <input type="password" class="form-control" name="old" id="old"/>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="password">New Password @error("password")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                <input type="password" class="form-control @error("password") is-invalid @enderror" name="password" id="password"/>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="confirm">Confirm New Password @error("confirm")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror</label>
                <input type="password" class="form-control @error("confirm") is-invalid @enderror" name="confirm" id="confirm"/>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
</div>

@endsection
