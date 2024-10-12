<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{  asset("img/logo.svg") }}" type="image/x-icon"> <!-- Jika menggunakan .ico -->
    <title>Dashboard | {{ $Title }}</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route("dashboard") }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{ Auth::user()->user_type == 'reseller' ? 'reseller':'account' }}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            

            @if (Auth::user()->user_type == 'reseller')
            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ $Title == "Reseller" ? "active":""}}">
                <a class="nav-link" href="{{ route("dashboard") }}">
                    <i class="fas fa-house-user"></i>

                    <span>Dashboard</span></a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link" href="{{ route("home") }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Home</span></a>
            </li>
            
            @if (Auth::user()->user_type == 'reseller')
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Upload -->
            <li class="nav-item {{ $Title == "Upload Produk" ? "active":""}}">
                <a class="nav-link" href="{{ url("Reseller/Upload")}}">
                    <i class="fas fa-fw fa-calendar"></i>
                    <span>Upload</span></a>
            </li>


            <!-- Nav Item - Profil -->
            <li class="nav-item {{ $Title == "UploadProfilStore" ? "active":""}}">
                <a class="nav-link" href="{{ url("upload/profil/store") }}">
                    <i class="fas fa-fw fa-store"></i>
                    <span>Store Profil</span></a>
            </li>

            <!-- Nav Item - Start -->
            <li class="nav-item {{ $Title == "Featured Product" ? "active":""}}">
                <a class="nav-link" href="{{ url("Reseller/Product/Unggulan") }}">
                    <i class="fa fa-star"></i>
                    <span>Featured Product</span></a>
            </li>
            @endif

            <!-- Nav Item - Like -->
            <li class="nav-item {{ $Title == "favorite" ? "active":""}}">
                <a class="nav-link" href="{{ route("favorite") }}">
                    <i class="fa fa-hand-holding-heart"></i>
                    <span>Like Product</span></a>
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
                                <span class="badge badge-danger badge-counter" id="totalNotifReseller"></span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                @foreach ($Notifications as $notification)
                                    <a class="dropdown-item d-flex align-items-center  {{ $notification->reat_at == null ? "bg-gray-200":""}}" href="{{ url("text/".$notification->id."/notifReseller") }}">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">{{ $notification->TanggalNotif }}</div>
                                            {{ $notification->TigaHuruf }}
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
                                <a class="dropdown-item" href="{{ url("Profil") }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="{{ url("Setting") }}">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
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
                        <span>Copyright &copy; BatuBeling 2024</span>
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

        <div class="whatsapp">
            <a href="{{ url("https://api.whatsapp.com/send/?phone=6282132460155&text=Permisi%20admin,%20%20saya%20ingin%20upgrade%20status%20toko%20saya%20dengan%20email:%20".auth()->user()->email."%20%F0%9F%99%8F&type=phone_number&app_absent=0") }}">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    x="0px"
                    y="0px"
                    viewBox="0 0 128 128"
                    class="induk-whatsapp"
                >
                    <path
                        fill="#fff"
                        d="M64,123c32.5,0,59-26.5,59-59c0-15.8-6.1-30.6-17.3-41.7C94.6,11.1,79.8,5,64,5C31.5,5,5,31.4,5,64 c0,10.4,2.7,20.5,7.9,29.5l-5.6,20.6c-1.2,4.4,2.8,8.5,7.3,7.3l21.3-5.6C44.4,120.5,54.1,123,64,123L64,123z"
                    ></path>
                    <path
                        fill="#5bf979"
                        d="M64,111c-7.8,0-15.6-2-22.5-5.7c-1.8-1-3.8-1.5-5.7-1.5c-1,0-2,0.1-3,0.4l-11.2,2.9l2.9-10.5 c0.8-3.1,0.4-6.4-1.2-9.2C19.1,80.3,17,72.2,17,64C17,38,38.1,17,64,17c12.6,0,24.4,4.9,33.3,13.8C106.1,39.6,111,51.4,111,64 C111,89.9,89.9,111,64,111L64,111z"
                    ></path>
                    <path
                        fill="#444b54"
                        d="M107.9,20.2C96.2,8.5,80.6,2,64,2C29.8,2,2,29.8,2,64c0,10.5,2.6,20.8,7.7,29.9l-5.3,19.4 c-0.9,3.1,0,6.3,2.3,8.6c2.3,2.3,5.5,3.2,8.6,2.4l20.2-5.3c8.8,4.6,18.6,7,28.6,7c34.2,0,62-27.8,62-62 C126,47.5,119.6,31.9,107.9,20.2z M64,120c-9.3,0-18.6-2.4-26.8-6.8c-0.4-0.2-0.9-0.4-1.4-0.4c-0.3,0-0.5,0-0.8,0.1l-21.3,5.6 c-1.5,0.4-2.5-0.4-2.9-0.8c-0.4-0.4-1.2-1.4-0.8-2.9l5.6-20.6c0.2-0.8,0.1-1.6-0.3-2.3C10.5,83.5,8,73.8,8,64C8,33.1,33.1,8,64,8 c15,0,29.1,5.8,39.6,16.4C114.2,35,120.1,49.1,120,64C120,94.9,94.9,120,64,120z"
                    ></path>
                    <g>
                        <path
                            fill="#006475"
                            d="M92.9,85.1c-1.2,3.4-7.2,6.8-10,7c-2.7,0.2-5.2,1.2-17.7-3.7c-15-5.9-24.5-21.3-25.2-22.3c-0.7-1-6-8-6-15.3 c0-7.3,3.8-10.8,5.2-12.3c1.4-1.5,2.9-1.8,3.9-1.8c1,0,2,0,2.8,0c1.1,0,2.2,0.1,3.3,2.5c1.3,2.9,4.2,10.2,4.5,10.9 c0.4,0.7,0.6,1.6,0.1,2.6c-0.5,1-0.7,1.6-1.5,2.5c-0.7,0.9-1.6,1.9-2.2,2.6c-0.7,0.7-1.5,1.5-0.6,3c0.9,1.5,3.8,6.3,8.2,10.2 c5.6,5,10.4,6.6,11.9,7.3c1.5,0.7,2.3,0.6,3.2-0.4c0.9-1,3.7-4.3,4.7-5.8c1-1.5,2-1.2,3.3-0.7c1.4,0.5,8.6,4.1,10.1,4.8 c1.5,0.7,2.5,1.1,2.8,1.7C94.1,78.7,94.1,81.6,92.9,85.1z"
                        ></path>
                    </g>
                </svg>
            </a>
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

    <script>
        $(document).ready(function () {
            $.ajax({
                type: "GET",
                url: "/totalNotifReseller",
                success: function (response) {
                    if (response.success) {
                        if (response.message > 0) {
                            $("#totalNotifReseller").append(response.message);
                        }
                    }
                },
            });
        });
    </script>


</body>

</html>
