@extends('template.template_superadmin')
@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include("template.notification")

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Banner Store</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content table -->
           <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">Banner Store Data Table</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Banner Store</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Vendor</th>
                                <th>Banner</th>
                                <th>Start</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Vendor</th>
                                <th>Banner</th>
                                <th>Start</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody">
                            @foreach ($Data as $vendor)
                                <tr> 
                                    <td>{{ $vendor->User->name }}</td>
                                    <td><img src="{{asset('img/web/undraw_profile.svg')}}" alt="" class="img-vendor"></td>
                                    <td>{{ $vendor->created_at->format('d-m-Y')}}</td>
                                     <td>

                                        <form action="{{ url("delete/banner")}}" method="post" id="delete-product">
                                            @csrf
                                            <input type="hidden" value="{{ $vendor->id }}" name="id">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete()">Delete</button>
                                        </form>
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
