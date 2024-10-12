@extends('template.template_superadmin')
@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        @include("template.notification")

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total (Produk)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $Total }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total (Reseller)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $Resellers->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Produk (Tersedia)
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $Tersedia }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Produk (Habis)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sold }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content table -->
           <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">data table of all your current Reseller</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Reseller</h6>
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
                                <th>Member</th>
                                <th>Limit</th>
                                <th>Total</th>
                                <th>Sold</th>
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
                                <th>Limit</th>
                                <th>Total</th>
                                <th>Sold</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($Resellers as $Reseller)
                                <tr>
                                    <td><img src="{{asset('img/web/undraw_profile.svg')}}" alt="" class="img-vendor"></td>
                                    <td>{{$Reseller->name}}</td>
                                    <td>{{$Reseller->email}}</td>
                                    <td>{{ $Reseller->status == false ? "Pending":"Verified"}}</td>
                                    <td class="text-center">{{ $Reseller->membership }}</td>
                                    <td class="text-center">{{ $Reseller->product_limit }}</td>
                                    <td class="text-center">{{ $Reseller->Produks->count() }}</td>
                                    <td class="text-center">{{ $Reseller->Habis }}</td>
                                    <td class="d-flex align-item-center">
                                    @if(isset($Reseller->profile))
                                        <a href="{{ route("store.products", ["profile" => $Reseller->profile]) }}">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></button>
                                        </a>
                                    @endif
                                        | 
                                        <a href="{{ url("show/".$Reseller->id."/membership") }}" id="membership">
                                            <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-comments-dollar"></i></button>
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
