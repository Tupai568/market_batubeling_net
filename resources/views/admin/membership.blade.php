@extends('template.template_superadmin')
 @section('container')
<!-- Begin Page Content -->
@include("template.notification")
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Membership</h1>
    </div>

    <!--  Upload Produk -->
    <div class="container-fluid">
        <form action="/membership" method="post">
           @csrf
           <input type="hidden" value="{{ $Data->id }}" name="id">
            <!-- Nama -->
            <div class="form-group">
                <label for="name">Nama</label>
                <input value="{{ $Data->name }}" type="text" class="form-control" name="name" id="name" readonly />
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input value="{{ $Data->email }}" type="email" class="form-control" name="email" id="email" readonly/>
            </div>

             <div class="form-group">
                <label for="membership">Membership</label>
                <select id="membership" class="form-control" name="membership">
                    @foreach ($Members as $member)
                    @if ($member == $Data->membership)
                        <option value="{{ $member }}" selected>{{ $member }}</option>
                    @else
                        <option value="{{ $member }}">{{ $member }}</option>
                    @endif
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
</div>

@endsection
