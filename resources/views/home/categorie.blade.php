@extends('template.template_home')
@section('container')

<!--
      - PRODUCT
    -->

			<div class="product-container">
				<div class="container">
					<!--
          - SIDEBAR
        -->

					<div class="sidebar has-scrollbar" data-mobile-menu>
						<div class="sidebar-category">
							<div class="sidebar-top">
								<h2 class="sidebar-title">Category</h2>

								<button class="sidebar-close-btn" data-mobile-menu-close-btn>
									<ion-icon name="close-outline"></ion-icon>
								</button>
							</div>

							<ul class="sidebar-menu-category-list">
								@foreach ($categories as $categorie)
									<a href="{{route('categories', ['name' => $categorie->name])}}">
										<li class="sidebar-menu-category">
											<button class="sidebar-accordion-menu" data-accordion-btn>
												<div class="menu-title-flex">
													<img src="{{ asset("img/kategori/".$categorie->name.".png") }}" alt="clothes" width="20" height="20" class="menu-title-img" />
		
													<p class="menu-title">{{ $categorie->name }}</p>
												</div>
		
												{{-- <div>
													<ion-icon name="add-outline" class="add-icon"></ion-icon>
													<ion-icon name="remove-outline" class="remove-icon"></ion-icon>
												</div> --}}
											</button>
										</li>
									</a>
								@endforeach
							</ul>
						</div>

						<div class="product-showcase">
							<h3 class="showcase-heading">best featured</h3>

							<div class="showcase-wrapper">
								<div class="showcase-container unggulan-container">
									@foreach ($unggulans as $unggulan)
									<div class="showcase">
										<a href="{{ route('detail-product', ['name' => $unggulan->produk->name, 'id' => $unggulan->produk->id]) }}" class="showcase-img-box">
											<img
												src="{{ asset("img/produk/".$unggulan->produk->image->image) }}"
												alt="baby fabric shoes"
												width="75"
												height="75"
												class="showcase-img"
											/>
										</a>

										<div class="showcase-content">
											<a href="{{ route('detail-product', ['name' => $unggulan->produk->name, 'id' => $unggulan->produk->id]) }}">
												<h4 class="showcase-title">{{ $unggulan->produk->name }}</h4>
											</a>

											<div class="price-box">
												<p class="price">RP.{{ $unggulan->produk->harga }}</p>
											</div>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>

					<div class="product-box">
						<!--

            - PRODUCT GRID
          -->

						<div class="product-main">
							<h2 class="title">{{ $categoriName }}</h2>

							<div class="product-grid">

                                @foreach ($products as $product)
								<div class="showcase">
									<div class="showcase-banner">
                                            <img
                                                src="{{ asset("img/produk/".$product->image->image) }}"
                                                alt="{{ $product->name }}"
                                                class="product-img default"
                                                width="300"
                                            />
                                            <img
                                                src="{{ asset("img/produk/".$product->image->imageSatu) }}"
                                                alt="{{ $product->name }}"
                                                class="product-img hover"
                                                width="300"
                                            />

											@if ($product->status->status == "Habis")
											<p class="showcase-badge angle black">sale</p>
											@endif

										<div class="showcase-actions">
											<button class="btn-action">
												<ion-icon name="heart-outline"></ion-icon>
											</button>

											<a href="{{ route('detail-product', ['name' => $product->name, 'id' => $product->id]) }}">
												<button class="btn-action">
													<ion-icon name="eye-outline"></ion-icon>
												</button>
											</a>
										
										</div>
									</div>

									<a href="{{ route('detail-product', ['name' => $product->name, 'id' => $product->id]) }}">
										<div class="showcase-content">
											<p class="showcase-category">{{ $product->kategori->name }}</p>
	
											<h3>
												<p class="showcase-title">{{ $product->name }}</p>
											</h3>
	
											<div class="price-box">
												<p class="price">RP.{{ $product->harga }}</p>
											</div>
										</div>
									</a>

								</div>
                                @endforeach

							</div>
						</div>
					</div>
				</div>
			</div>
		</main>

<script>
            // Pilih semua elemen dengan class .thumbnail
            document.querySelectorAll('.thumbnail').forEach(item => {
                // Tambahkan event listener klik untuk setiap thumbnail
                item.addEventListener('click', function () {
                    // Ambil nilai src dari atribut data-src
                    const src = this.getAttribute('data-src');
                    // Ganti src gambar utama
                    document.getElementById('main-image').src = src;
        
                    // Hapus kelas active dari semua thumbnail
                    document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
                    // Tambahkan kelas active ke thumbnail yang diklik
                    this.classList.add('active');
                });
            });
        
            // Set active state pada thumbnail yang sama dengan gambar utama saat pertama kali dimuat
            window.addEventListener('load', function () {
                const mainImageSrc = document.getElementById('main-image').src;
                document.querySelectorAll('.thumbnail').forEach(thumb => {
                    if (thumb.getAttribute('data-src') === mainImageSrc) {
                        thumb.classList.add('active');
                    }
                });
            });
    </script>
@endsection