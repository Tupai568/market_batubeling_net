<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{  asset("img/logo.svg") }}" type="image/x-icon"> <!-- Jika menggunakan .ico -->
    <title>Dashboard | SuperAdmin</title>

    <!-- Editor -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="{{ asset("vendor/fontawesome-free/css/all.min.css")}}" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{asset("css/sb-admin-2.css")}}">
    <link rel="stylesheet" href="{{asset("css/custom.css")}}">
    <link rel="stylesheet" href="{{asset("vendor/datatables/dataTables.bootstrap4.min.css")}}">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar bg-gradient-primary  sidebar-dark accordion warna-bg" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url("Admin") }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SuperAdmin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ $Title == "SuperAdmin" ? "active":""}}">
                <a class="nav-link" href="{{ url("Admin") }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - produk -->
            <li class="nav-item {{ $Title == "Total Produk SuperAdmin" ? "active":""}}">
                <a class="nav-link" href="{{ url("Total/Product") }}">
                    <i class="fas fa-fw fa-calendar"></i>
                    <span>Product </span>
                    @if ($pending > 0)
                    <span class="badge  badge-danger ">{{ $pending }}</span>
                    @endif
                </a>
            </li>

            <!-- Nav Item - User Confirm -->
            <li class="nav-item {{ $Title == "userConfirm" ? "active":""}}">
                <a class="nav-link" href="{{ url("Verified/Admin") }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>User Confirm</span>
                @if ($userPending > 0)
                    <span class="badge  badge-danger ">{{ $userPending }}</span>
                @endif
                </a>
            </li>

            <!-- Nav Item - Iklan Banner -->
            <li class="nav-item {{ $Title == "iklanBanner" ? "active":""}}">
                <a class="nav-link" href="{{ url("Admin/Banner") }}">
                    <i class="fa fa-image"></i>
                    <span>Iklan Banner</span></a>
            </li>

            <!-- Nav Item - Featured Product -->
            <li class="nav-item {{ $Title == "totalFeatured" ? "active":""}}">
                <a class="nav-link" href="{{ url("Admin/Product/Unggulan") }}">
                    <i class="fa fa-star"></i>
                    <span>Featured Product</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter" id="totalNotif"></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown" id="dropdownNotif">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                @foreach ($Notifications as $notification)
                                    <a class="dropdown-item d-flex align-items-center  {{ $notification->reat_at == null ? "bg-gray-200":""}}" href="{{ url("text/".$notification->id."/notif") }}">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">{{ $notification->TanggalNotif }}</div>
                                            {{ $notification->user->name }} {{ $notification->message }}
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                <img class="img-profile rounded-circle" src="{{ asset("img/web/undraw_profile.svg")}}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ url("Profil/Admin") }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <form action="/logout" method="post">
                                        @csrf
                                        <button type="submit"
                                            style="border: none; outline: none;   background: transparent;
                                ">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Logout
                                        </button>
                                    </form>
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('container')


            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="/logout" method="post">
                                        @csrf
                        <button type="submit" style="border: none; outline: none;   background: transparent; ">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset("vendor/jquery/jquery.min.js")}}"></script>
    <script src="{{ asset("vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset("vendor/jquery-easing/jquery.easing.min.js")}}"></script>


    <!-- Custom scripts for all pages-->
    <script src="{{ asset("js/script.js")}}"></script>
    <script src="{{ asset("js/sb-admin-2.min.js")}}"></script>


    <!-- Page level plugins -->
    <script src="{{ asset("vendor/datatables/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("vendor/datatables/dataTables.bootstrap4.min.js") }}"></script>
  

    <!-- Page level custom scripts -->
    <script src="{{ asset("js/demo/datatables-demo.js") }}"></script>

</body>

</html>
