<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
        <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{ asset("vendor/fontawesome-free/css/all.min.css")}}" type="text/css">
    <link rel="stylesheet" href="{{asset("css/sb-admin-2.css")}}">
    <link rel="stylesheet" href="{{asset("css/custom.css")}}">

</head>

<body>
<section class="vh-100 bg-image"    
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
  
  @include("template.notification")
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">LOGIN</h2>
              <form action="{{ route("post-login") }}" method="POST">
                @csrf

                <div data-mdb-input-init class="form-outline mb-3">
                   @error("email")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror
                  <input value="{{ $errors->has('email') ? '' : old('email') }}" type="email" id="form3Example3cg" class="form-control form-control-lg {{ $errors->has('email') ? 'is-invalid' :  (old('email') ? 'is-valid' : '') }} " name="email" placeholder="Email" required/>
                  <label class="form-label" for="form3Example3cg">Your Email </label>  
                </div>

                <div data-mdb-input-init class="form-outline mb-3">
                  @error("password")<span class="text-danger ml-2 custom-text-invalid ">{{ $message }}</span>@enderror
                  <input type="password" id="form3Example4cg" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="Password" required/> 
                  <label class="form-label" for="form3Example4cg">Password  <i class="fas fa-eye ml-2" id="show"></i></label>
                </div>

                <div class="d-flex justify-content-center">
                  <button  type="submit" 
                    data-mdb-ripple-init class="btn btn-primary btn-block btn-lg gradient-custom-4 text-white">Login</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Don't have an account?  <a href="{{ route("register") }}"
                    class="fw-bold text-danger"><u>Register</u></a></p>
                    <a href="/" class="fw-bold text-body text-center d-block"><u>Back</u></a>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script>
             const show = document.getElementById("show");
              const password = document.getElementById("form3Example4cg");

              show.addEventListener("click", () => {
                  let atribut = password.getAttribute("type");
                  if (atribut === "password") {
                      password.setAttribute("type", "text");
                  } else {
                      password.setAttribute("type", "password");
                  }
                  show.classList.toggle("fa-eye-slash");
              });

              window.onload = function () {
                let notification = document.querySelector(".container-notif");

                if (notification) {
                      setTimeout(function () {
                          // Menghapus elemen span dari DOM
                          notification.parentNode.removeChild(notification);
                      }, 5000);
                }

              }
        </script>
</body>
</html>