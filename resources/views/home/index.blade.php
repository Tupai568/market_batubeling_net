@extends('template.template_home')
@section('container')
    <main>
        <!--\- BANNER -->
        <div class="banner">
            <div class="container swiper-baner">
                <div class="slider-container has-scrollbar swiper-wrapper">
                    @foreach ($baners as $baner)
                        <div class="slider-item swiper-slide">
                            <a href="{{ route('store.products', ['profile' => $baner->user->profile]) }}">
                                <img src="{{ asset('img/baner/' . $baner->image) }}" alt="women's latest fashion sale"
                                    class="banner-img" />
                            </a>
                        </div>
                    @endforeach
                    <div class="slider-item swiper-slide">
                        <img src="{{ asset('img/baner/baner1.jpg') }}" alt="Almaas" class="banner-img" />
                    </div>
                    <div class="slider-item swiper-slide">
                        <img src="{{ asset('img/baner/baner2.jpg') }}" alt="Cellustone" class="banner-img" />
                    </div>
                    <div class="slider-item swiper-slide">
                        <img src="{{ asset('img/baner/baner3.jpg') }}" alt="Toilet Portable" class="banner-img" />
                    </div>
                </div>
            </div>
        </div>
        <!--- CATEGORY -->


        <div class="category">
            <div class="container">
                <div class="category-item-container has-scrollbar">
                    <div class="category-item">
                        <div class="category-img-box">
                            <img src="{{ asset('img/icons/sepeda.svg') }}" alt="dress & frock" width="30" />
                        </div>

                        <div class="category-content-box">
                            <div class="category-content-flex">
                                <h3 class="category-item-title">Sepeda</h3>

                                <p class="category-item-amount">({{ $sepeda }})</p>
                            </div>

                            <a href="{{ url('search?search=sepeda') }}" class="category-btn">Show all</a>
                        </div>
                    </div>

                    <div class="category-item">
                        <div class="category-img-box">
                            <img src="{{ asset('img/icons/mobil.svg') }}" alt="winter wear" width="30" />
                        </div>

                        <div class="category-content-box">
                            <div class="category-content-flex">
                                <h3 class="category-item-title">Mobil</h3>

                                <p class="category-item-amount">({{ $mobil }})</p>
                            </div>

                            <a href="{{ url('search?search=mobil') }}" class="category-btn">Show all</a>
                        </div>
                    </div>

                    <div class="category-item">
                        <div class="category-img-box">
                            <img src="{{ asset('img/icons/bonsai.svg') }}" alt="dress & frock" width="30" />
                        </div>

                        <div class="category-content-box">
                            <div class="category-content-flex">
                                <h3 class="category-item-title"> Bonsai</h3>

                                <p class="category-item-amount">({{ $bonsai }})</p>
                            </div>

                            <a href="{{ url('search?search=bonsai') }}" class="category-btn">Show all</a>
                        </div>
                    </div>

                    <div class="category-item">
                        <div class="category-img-box">
                            <img src="{{ asset('img/icons/buku.svg') }}" alt="hat & caps" width="30" />
                        </div>

                        <div class="category-content-box">
                            <div class="category-content-flex">
                                <h3 class="category-item-title">Buku</h3>

                                <p class="category-item-amount">({{ $buku }})</p>
                            </div>

                            <a href="{{ url('search?search=buku') }}" class="category-btn">Show all</a>
                        </div>
                    </div>

                    <div class="category-item">
                        <div class="category-img-box">
                            <img src="{{ asset('img/icons/jam.svg') }}" alt="glasses & lens" width="30" />
                        </div>

                        <div class="category-content-box">
                            <div class="category-content-flex">
                                <h3 class="category-item-title">Jam</h3>

                                <p class="category-item-amount">({{ $jam }})</p>
                            </div>

                            <a href="{{ url('search?search=jam') }}" class="category-btn">Show all</a>

                        </div>
                    </div>

                </div>
            </div>
        </div>

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
                                <a href="{{ route('categories', ['name' => $categorie->name]) }}">
                                    <li class="sidebar-menu-category">
                                        <button class="sidebar-accordion-menu" data-accordion-btn>
                                            <div class="menu-title-flex">
                                                <img src="{{ asset('img/kategori/' . $categorie->name . '.png') }}"
                                                    alt="clothes" width="20" height="20" class="menu-title-img" />

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
                                        <a href="{{ route('detail-product', ['name' => $unggulan->produk->name, 'id' => $unggulan->produk->id]) }}"
                                            class="showcase-img-box">
                                            <img src="{{ asset('img/produk/' . $unggulan->produk->image->image) }}"
                                                alt="baby fabric shoes" width="75" height="75"
                                                class="showcase-img" />
                                        </a>

                                        <div class="showcase-content">
                                            <a
                                                href="{{ route('detail-product', ['name' => $unggulan->produk->name, 'id' => $unggulan->produk->id]) }}">
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
                - PRODUCT MINIMAL
              -->

                    <div class="product-minimal">
                        <div class="product-showcase">
                            <h2 class="title">New Arrivals</h2>

                            <div class="showcase-wrapper has-scrollbar">
                                <div class="showcase-container">
                                    @foreach ($limits as $limit)
                                        <div class="showcase">
                                            <a href="{{ route('detail-product', ['name' => $limit->name, 'id' => $limit->id]) }}"
                                                class="showcase-img-box">
                                                <img src="{{ asset('img/produk/' . $limit->image->image) }}"
                                                    alt="{{ $limit->name }}" width="70"  class="showcase-img" />
                                            </a>

                                            <div class="showcase-content">
                                                <a
                                                    href="{{ route('detail-product', ['name' => $limit->name, 'id' => $limit->id]) }}">
                                                    <h4 class="showcase-title">{{ $limit->name }}</h4>
                                                </a>

                                                <a href="{{ route('detail-product', ['name' => $limit->name, 'id' => $limit->id]) }}"
                                                    class="showcase-category">{{ $limit->kategori->name }}</a>

                                                <div class="price-box">
                                                    <p class="price">RP.{{ $limit->harga }}</p>
                                                    {{-- <del>$12.00</del> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="showcase-container">
                                    @foreach ($slices as $slice)
                                        <div class="showcase">
                                            <a href="{{ route('detail-product', ['name' => $slice->name, 'id' => $slice->id]) }}"
                                                class="showcase-img-box">
                                                <img src="{{ asset('img/produk/' . $slice->image->image) }}"
                                                    alt="{{ $slice->name }}" class="showcase-img" width="70" />
                                            </a>

                                            <div class="showcase-content">
                                                <a
                                                    href="{{ route('detail-product', ['name' => $slice->name, 'id' => $slice->id]) }}">
                                                    <h4 class="showcase-title">{{ $slice->name }}</h4>
                                                </a>

                                                <a href="{{ route('detail-product', ['name' => $slice->name, 'id' => $slice->id]) }}"
                                                    class="showcase-category">{{ $slice->kategori->name }}</a>

                                                <div class="price-box">
                                                    <p class="price">RP.{{ $slice->harga }}</p>
                                                    {{-- <del>$12.00</del> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="product-showcase">
                            <h2 class="title">Trending</h2>

                            <div class="showcase-wrapper has-scrollbar">
                                <div class="showcase-container">
                                    @foreach ($limitsTrending as $limitTrending)
                                        <div class="showcase">
                                            <a href="{{ route('detail-product', ['name' => $limitTrending->name, 'id' => $limitTrending->id]) }}"
                                                class="showcase-img-box">
                                                <img src="{{ asset('img/produk/' . $limitTrending->image->image) }}"
                                                    alt="{{ $limitTrending->name }}" width="70"
                                                    class="showcase-img" />
                                            </a>

                                            <div class="showcase-content">
                                                <a
                                                    href="{{ route('detail-product', ['name' => $limitTrending->name, 'id' => $limitTrending->id]) }}">
                                                    <h4 class="showcase-title">{{ $limitTrending->name }}</h4>
                                                </a>

                                                <a href="{{ route('detail-product', ['name' => $limitTrending->name, 'id' => $limitTrending->id]) }}"
                                                    class="showcase-category">{{ $limitTrending->kategori->name }}</a>

                                                <div class="price-box">
                                                    <p class="price">RP.{{ $limitTrending->harga }}</p>
                                                    {{-- <del>$12.00</del> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="showcase-container">
                                    @foreach ($slicesTrending as $sliceTrending)
                                        <div class="showcase">
                                            <a href="{{ route('detail-product', ['name' => $sliceTrending->name, 'id' => $sliceTrending->id]) }}"
                                                class="showcase-img-box">
                                                <img src="{{ asset('img/produk/' . $sliceTrending->image->image) }}"
                                                    alt="{{ $sliceTrending->name }}" class="showcase-img"
                                                    width="70" />
                                            </a>

                                            <div class="showcase-content">
                                                <a
                                                    href="{{ route('detail-product', ['name' => $sliceTrending->name, 'id' => $sliceTrending->id]) }}">
                                                    <h4 class="showcase-title">{{ $sliceTrending->name }}</h4>
                                                </a>

                                                <a href="{{ route('detail-product', ['name' => $sliceTrending->name, 'id' => $sliceTrending->id]) }}"
                                                    class="showcase-category">{{ $sliceTrending->kategori->name }}</a>

                                                <div class="price-box">
                                                    <p class="price">RP.{{ $sliceTrending->harga }}</p>
                                                    {{-- <del>$12.00</del> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="product-showcase">
                            <h2 class="title">Top Rated</h2>

                            <div class="showcase-wrapper has-scrollbar">
                                <div class="showcase-container">
                                    @foreach ($limitsLike as $like)
                                        <div class="showcase">
                                            <a href="{{ route('detail-product', ['name' => $like->name, 'id' => $like->id]) }}"
                                                class="showcase-img-box">
                                                <img src="{{ asset('img/produk/' . $like->image->image) }}"
                                                    alt="{{ $like->name }}" width="70" class="showcase-img" />
                                            </a>

                                            <div class="showcase-content">
                                                <a
                                                    href="{{ route('detail-product', ['name' => $like->name, 'id' => $like->id]) }}">
                                                    <h4 class="showcase-title">{{ $like->name }}</h4>
                                                </a>

                                                <a href="{{ route('detail-product', ['name' => $like->name, 'id' => $like->id]) }}"
                                                    class="showcase-category">{{ $like->kategori->name }}</a>

                                                <div class="price-box">
                                                    <p class="price">RP.{{ $like->harga }}</p>
                                                    {{-- <del>$12.00</del> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="showcase-container">
                                    @foreach ($slicesLikes as $slicesLike)
                                        <div class="showcase">
                                            <a href="{{ route('detail-product', ['name' => $slicesLike->name, 'id' => $slicesLike->id]) }}"
                                                class="showcase-img-box">
                                                <img src="{{ asset('img/produk/' . $slicesLike->image->image) }}"
                                                    alt="{{ $slicesLike->name }}" class="showcase-img" width="70" />
                                            </a>

                                            <div class="showcase-content">
                                                <a
                                                    href="{{ route('detail-product', ['name' => $slicesLike->name, 'id' => $slicesLike->id]) }}">
                                                    <h4 class="showcase-title">{{ $slicesLike->name }}</h4>
                                                </a>

                                                <a href="{{ route('detail-product', ['name' => $slicesLike->name, 'id' => $slicesLike->id]) }}"
                                                    class="showcase-category">{{ $slicesLike->kategori->name }}</a>

                                                <div class="price-box">
                                                    <p class="price">RP.{{ $slicesLike->harga }}</p>
                                                    {{-- <del>$12.00</del> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--
                - PRODUCT FEATURED
              -->

                    <div class="product-featured">
                        <h2 class="title">Deal of the day</h2>

                        <div class="showcase-wrapper has-scrollbar deal">
                            @foreach ($unggulans as $unggulan)
                                <div class="showcase-container">
                                    <div class="showcase">
                                        <div class="showcase-banner">
                                            <img src="{{ asset('img/produk/' . $unggulan->produk->image->image) }}"
                                                alt="{{ $unggulan->produk->name }}" class="showcase-img" />
                                        </div>

                                        <div class="showcase-content">

                                            <a href="#">
                                                <h3 class="showcase-title">{{ $unggulan->produk->name }}</h3>
                                            </a>

                                            <div class="showcase-desc">
                                                {!! $unggulan->produk->descripsi !!}
                                            </div>

                                            <div class="price-box">
                                                <p class="price">RP.{{ $unggulan->produk->harga }}</p>
                                            </div>

                                            <a
                                                href="{{ route('detail-product', ['name' => $unggulan->produk->name, 'id' => $unggulan->produk->id]) }}">
                                                <button class="add-cart-btn">show to product</button>
                                            </a>

                                            <div class="countdown-box">
                                                <p class="countdown-desc">Hurry Up! Offer ends in:</p>

                                                <div class="countdown">
                                                    <div class="countdown-content">
                                                        <p class="display-number">360</p>

                                                        <p class="display-text">Days</p>
                                                    </div>

                                                    <div class="countdown-content">
                                                        <p class="display-number">24</p>
                                                        <p class="display-text">Hours</p>
                                                    </div>

                                                    <div class="countdown-content">
                                                        <p class="display-number">59</p>
                                                        <p class="display-text">Min</p>
                                                    </div>

                                                    <div class="countdown-content">
                                                        <p class="display-number">00</p>
                                                        <p class="display-text">Sec</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!--
                - PRODUCT GRID
              -->

                    <div class="product-main">
                        <h2 class="title">New Products</h2>

                        <div class="product-grid">

                            @foreach ($products as $product)
                                <div class="showcase">
                                    <div class="showcase-banner">
                                        <img src="{{ asset('img/produk/' . $product->image->image) }}"
                                            alt="{{ $product->name }}" class="product-img default" width="300px"/>
                                        <img src="{{ asset('img/produk/' . $product->image->imageSatu) }}"
                                            alt="{{ $product->name }}" class="product-img hover" width="300px"/>

                                        @if ($product->status->status == 'Habis')
                                            <p class="showcase-badge angle black">sale</p>
                                        @endif

                                        <div class="showcase-actions">
                                            @auth
                                                <button class="btn-action btn-action-heart  {{ $product->like ? 'like' : '' }}"
                                                    data-product={{ $product->id }}>
                                                    <ion-icon name="heart-outline" class="heart"></ion-icon>
                                                </button>
                                            @endauth
                                            @guest
                                                <button class="btn-action">
                                                    <ion-icon name="heart-outline"></ion-icon>
                                                </button>
                                            @endguest

                                            <a
                                                href="{{ route('detail-product', ['name' => $product->name, 'id' => $product->id]) }}">
                                                <button class="btn-action">
                                                    <ion-icon name="eye-outline"></ion-icon>
                                                </button>
                                            </a>

                                        </div>
                                    </div>

                                    <a
                                        href="{{ route('detail-product', ['name' => $product->name, 'id' => $product->id]) }}">
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
                    {{ $products->links('template.paginator') }}
                </div>
            </div>
        </div>
    </main>
@endsection
