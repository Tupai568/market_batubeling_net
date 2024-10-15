<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" href="{{  asset("img/logo.svg") }}" type="image/x-icon"> <!-- Jika menggunakan .ico -->
		<title>Temukan Produk Unik dan Langka di Sini</title>
		<meta name="robots" content="index, follow">
		<meta name="description" content="MarketOnline yang menawarkan koleksi produk unik dan langka yang sulit ditemukan di tempat lain, Dengan fokus pada kualitas dan kelangkaan. Nikmati penawaran menarik">
		<meta name="keywords" content="produk unik, vespa langka, toilet portable, marketplace online, belanja unik, MarketOnline">
		<meta name="author" content="Tupai Anggora">

		<!-- untuk media sosial -->
		<meta property="og:title" content="Temukan Produk Unik dan Langka di MarketOnline">
		<meta property="og:description" content="Jelajahi koleksi produk unik dan langka di MarketOnline. Temukan penawaran terbaik dan barang-barang eksklusif yang sulit ditemukan di tempat lain.">
		<meta property="og:image" content="https://batubeling.net/images/logo/bb.svg">
		<meta property="og:url" content="https://batubeling.net/">

		<!-- untuk twiter -->
		<meta name="twitter:card" content="Temukan Produk Unik dan Langka di MarketOnline">
		<meta name="twitter:title" content="Temukan Produk Unik di MarketOnline">
		<meta name="twitter:description" content="Jelajahi koleksi produk langka dan eksklusif di marketplace kami. Dapatkan penawaran terbaik sekarang!">
		<meta name="twitter:image" content="https://batubeling.net/images/logo/bb.svg">
		
		<!-- Meta tag verifikasi Google Search Console -->
		<meta name="google-site-verification" content="-lxbMu4P1-ZpVbswK2Ot17H2SWkKxoRsbjNWEEOF5r4" />

		<!-- favicon -->
		<link rel="shortcut icon" href="./assets/images/logo/favicon.ico" type="image/x-icon" />

		<!-- custom css link -->
		<link rel="stylesheet" href="{{ asset("css/style-prefix.css") }}" />

		<!-- google font link -->
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
		
		
		<!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-GKEGK3H1VB"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
    
          gtag('config', 'G-GKEGK3H1VB');
        </script>
	</head>

	<body>
		<div class="overlay" data-overlay></div>

		<!-- HEADER-->
		<header>
			<div class="header-main">
				<div class="container">
					<a href="{{ route("home") }}" class="header-logo">
						<img src="{{ asset("images/logo/LOGO_BB_NET.svg") }}" alt="batubeling" />
					</a>

					<div class="header-search-container">
						<form action="{{ route('search')}}" method="get">
							<input type="search" name="search" class="search-field" placeholder="Enter your product name..." />

							<button class="search-btn" type="submit">
								<ion-icon name="search-outline"></ion-icon>
							</button>
						</form>

					</div>

					@auth
					<div class="header-user-actions">
						<a href="{{ route("login") }}" class="header-user-name">
						 {{ auth()->user()->name }}
						</a>
					</div>
					@endauth
					@guest
					<div class="header-user-actions">
						<a href="{{ route("login") }}">
							<button class="action-btn">
								<ion-icon name="person-outline"></ion-icon>
							</button>
						</a>

						<a href="{{ route("register") }}">
							<button class="action-btn">
									<ion-icon name="person-add-outline"></ion-icon>
							</button>
						</a>

					</div>
					@endguest
				</div>
			</div>

			<nav class="desktop-navigation-menu">
				<div class="container">
					<ul class="desktop-menu-category-list">
						<li class="menu-category">
							<a href="{{ route("home") }}" class="menu-title">Home</a>
						</li>


						<li class="menu-category">
							<a href="#" class="menu-title">Categories</a>

							<div class="dropdown-panel">
								@foreach ($limitsCategories as $limitCategorie)
									<ul class="dropdown-panel-list">
										<li class="menu-title">
											<a href="{{ route('categories', ['name' => $limitCategorie->name]) }}">{{ $limitCategorie->name }}</a>
										</li>

										<li class="panel-list-item">
											<a href="{{ route('categories', ['name' => $limitCategorie->name]) }}">
												<img src="{{ asset('images/' . $limitCategorie->name . '.jpg') }}" alt="headphone collection" width="250" height="119" />
											</a>
										</li>
									</ul>
								@endforeach
							</div>
						</li>

						<!--@auth-->
						<!--<li class="menu-category">-->
						<!--	<a href="#" class="menu-title">Favorite	</a>-->
						<!--</li>-->
						<!--@endauth-->

						@foreach ($slicesCategories as $sliceCategorie)
						<li class="menu-category">
							<a href="{{ route('categories', ['name' => $sliceCategorie->name]) }}" class="menu-title">{{ $sliceCategorie->name }}</a>
						</li>
						@endforeach

						
					</ul>
				</div>
			</nav>

			<div class="mobile-bottom-navigation">
				<button class="action-btn" data-mobile-menu-open-btn>
					<ion-icon name="menu-outline"></ion-icon>
				</button>

				<!--<button class="action-btn">-->
				<!--	<ion-icon name="bag-handle-outline"></ion-icon>-->

				<!--	<span class="count">0</span>-->
				<!--</button>-->
                <a href="{{ route('home') }}">
				<button class="action-btn">
					<ion-icon name="home-outline"></ion-icon>
				</button>
                </a>
				<!--<button class="action-btn">-->
				<!--	<ion-icon name="heart-outline"></ion-icon>-->

				<!--	<span class="count">0</span>-->
				<!--</button>-->

				<button class="action-btn" data-mobile-menu-open-btn>
					<ion-icon name="grid-outline"></ion-icon>
				</button>
			</div>

			<nav class="mobile-navigation-menu has-scrollbar" data-mobile-menu>
				<div class="menu-top">
					<h2 class="menu-title">Menu</h2>

					<button class="menu-close-btn" data-mobile-menu-close-btn>
						<ion-icon name="close-outline"></ion-icon>
					</button>
				</div>

				<ul class="mobile-menu-category-list">
					<li class="menu-category">
						<a href="{{ route('home') }}" class="menu-title">Home</a>
					</li>

					{{-- <li class="menu-category">
						<a href="" class="menu-title">Favorite</a>
					</li> --}}


					<li class="menu-category">
						<a href="{{ route('login') }}" class="menu-title">Login</a>
					</li>

					<li class="menu-category">
						<a href="{{ route('register') }}" class="menu-title">Register</a>
					</li>
				</ul>

				<div class="menu-bottom">
					<ul class="menu-social-container">
						<li>
							<a href="{{ url('https://www.facebook.com/batubelingofficial/') }}" class="social-link">
								<ion-icon name="logo-facebook"></ion-icon>
							</a>
						</li>

						<li>
							<a href="{{ url('https://www.youtube.com/c/batubeling') }}" class="social-link">
								<ion-icon name="logo-youtube"></ion-icon>
							</a>
						</li>

						<li>
							<a href="{{ url('https://www.instagram.com/batubeling_') }}" class="social-link">
								<ion-icon name="logo-instagram"></ion-icon>
							</a>
						</li>

						<li>
							<a href="{{ url('https://www.youtube.com/c/batubeling') }}" class="social-link">
								<ion-icon name="logo-tiktok"></ion-icon>
							</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>
        
@yield('container')

		<!-- FOOTER -->
		<footer>
			<div class="footer-nav">
				<div class="container">
					<ul class="footer-nav-list">
						<li class="footer-nav-item">
							<h2 class="nav-title">Popular Categories</h2>
						</li>
						@foreach ($categories as $categorie)
						<li class="footer-nav-item">
							<a href="{{ route('categories', ['name' => $categorie->name ]) }}" class="footer-nav-link">{{ $categorie->name }}</a>
						</li>
						@endforeach
					</ul>

					<ul class="footer-nav-list">
						<li class="footer-nav-item">
							<h2 class="nav-title">Products</h2>
						</li>

						@foreach ($list as $item)
						<li class="footer-nav-item">
							<a href="{{ url("search?search=".$item) }}" class="footer-nav-link">{{ $item }}</a>
						</li>
						@endforeach
					</ul>

					<ul class="footer-nav-list">
						<li class="footer-nav-item">
							<h2 class="nav-title">Our Company</h2>
						</li>

                        <li class="footer-nav-item">
							<a href="https://maps.app.goo.gl/x8gcWrwGWo6YSofT7" class="footer-nav-link">Sitemap</a>
						</li>
						
						<li class="footer-nav-item">
							<a href="{{ route("about") }}" class="footer-nav-link">About us</a>
						</li>


						<li class="footer-nav-item">
							<a href="{{ route("home") }}" class="footer-nav-link">New products</a>
						</li>

						<li class="footer-nav-item">
							<a href="{{ route("terms") }}" class="footer-nav-link">Terms and conditions</a>
						</li>
						
						<li class="footer-nav-item">
							<a href="{{ route("privacy") }}" class="footer-nav-link">privacy policy</a>
						</li>

						

						
					</ul>

					<!--<ul class="footer-nav-list">-->
					<!--	<li class="footer-nav-item">-->
					<!--		<h2 class="nav-title">Services</h2>-->
					<!--	</li>-->

					<!--	<li class="footer-nav-item">-->
					<!--		<a href="#" class="footer-nav-link">Prices drop</a>-->
					<!--	</li>-->

					<!--	<li class="footer-nav-item">-->
					<!--		<a href="#" class="footer-nav-link">New products</a>-->
					<!--	</li>-->

					<!--	<li class="footer-nav-item">-->
					<!--		<a href="#" class="footer-nav-link">Best sales</a>-->
					<!--	</li>-->

					<!--	<li class="footer-nav-item">-->
					<!--		<a href="#" class="footer-nav-link">Contact us</a>-->
					<!--	</li>-->

					<!--	<li class="footer-nav-item">-->
					<!--		<a href="#" class="footer-nav-link">Sitemap</a>-->
					<!--	</li>-->
					<!--</ul>-->

					<ul class="footer-nav-list">
						<li class="footer-nav-item">
							<h2 class="nav-title">Contact</h2>
						</li>

						<li class="footer-nav-item flex">
							<div class="icon-box">
								<ion-icon name="location-outline"></ion-icon>
							</div>
							<a href="https://maps.app.goo.gl/x8gcWrwGWo6YSofT7" class="footer-nav-link">
							JL. Kyai Tambak Deres 100B Surabaya
							</a>
						</li>

						<li class="footer-nav-item flex">
							<div class="icon-box">
								<ion-icon name="call-outline"></ion-icon>
							</div>

							<a href="tel:+607936-8058" class="footer-nav-link">(+62) 82132460155</a>
						</li>

						<li class="footer-nav-item flex">
							<div class="icon-box">
								<ion-icon name="mail-outline"></ion-icon>
							</div>

							<a href="mailto:example@gmail.com" class="footer-nav-link">emailbatubeling@gmail.com</a>
						</li>
					</ul>

					<ul class="footer-nav-list">
						<li class="footer-nav-item">
							<h2 class="nav-title">Follow Us</h2>
						</li>

						<li>
							<ul class="social-link">
								<li class="footer-nav-item">
									<a href="https://www.facebook.com/batubelingsby/" class="footer-nav-link">
										<ion-icon name="logo-facebook"></ion-icon>
									</a>
								</li>
								<li class="footer-nav-item">
									<a href="https://www.instagram.com/batubeling_/?hl=id" class="footer-nav-link">
										<ion-icon name="logo-instagram"></ion-icon>
									</a>
								</li>
								<li class="footer-nav-item">
									<a href="{{ url('https://www.youtube.com/c/batubeling') }}" class="footer-nav-link">
								        <ion-icon name="logo-youtube"></ion-icon>
							        </a>
								</li>

								<li class="footer-nav-item">
									<a href="{{ url('https://www.youtube.com/c/batubeling') }}" class="footer-nav-link">
								        <ion-icon name="logo-tiktok"></ion-icon>
							        </a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>

			<div class="footer-bottom">
				<div class="container">
					<p class="copyright">Copyright &copy; <a href="{{ route("home") }}">Batubeling.net</a>.</p>
				</div>
			</div>
		</footer>
	
		<!-- Core plugin JavaScript-->
	   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

		<!-- custom js link-->
		<script src="{{ asset("js/testing.js") }}"></script>


		<!--ionicon link -->
		<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
		<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
		
		<script>
				$(document).ready(function () {
					$(".btn-action-heart").click(function () {
						const productId = $(this).data("product");
						const button = $(this);

						$.ajax({
							url: "/like", // Ganti dengan URL yang sesuai
							method: "POST",
							data: {
								_token: "{{ csrf_token() }}", // Token CSRF
								produk_id: productId,
							},
							success: function (response) {
								// Tanggapan dari server

								if (response.status == "liked") {
									button.addClass("like");
								} else {
									button.removeClass("like");
								}
							},
							error: function (xhr) {
								// Tangani error
								console.log("error");
							},
						});
					});
				});
		</script>


	</body>
</html>