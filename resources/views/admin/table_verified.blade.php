@extends('template.template_superadmin')
@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include("template.notification")

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">User Confirm</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content table -->
           <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">all data table verified</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Data Verified</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Member  </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Member</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody">
                            @foreach ($Data as $user)
                                <tr> 
                                    <td><img src="{{asset('img/web/undraw_profile.svg')}}" alt="" class="img-vendor"></td>
                                    <td>{{$user->user->name}}</td>
                                    <td>{{$user->user->email}}</td>
                                    <td>{{ $user->user->status == false ? "Pending":"Verified"}}</td>
                                    <td>{{ $user->user->membership }}</td>
                                     <td>
                                        <a href="{{ url("Account/".$user->user->id."/active") }}">
                                            <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                                        </a>
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
@endsection
