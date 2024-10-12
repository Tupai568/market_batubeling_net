@extends('template.template_admin')
@section('container')
<div class="container-fluid vendor-show">
<div class="vendor-show-image">
    <img src="{{ asset("img/produk/".$Produk->image->image ) }}" alt="">
</div>
<div class="vendor-show-descripsi">
    <h1>{{ $Produk->name }}</h1>
    <hr>
    <strong class="d-block">Kondisi: <span>{{ $Produk->kondisi }}</span></strong>
    <strong class="d-block">Kategori: <span>{{ $Produk->kategori->name }}</span></strong>
    <strong class="hubungi">Hubungi: <a href="{{ url("https://api.whatsapp.com/send/?phone=".$User->whatsapp."&text=Saya Ingin Bertanya Lebih Lanjut Tentang Produk Anda ".$Produk->name) }}"><span>whatsapp</span></a> </strong>
    <div class="descripsi_show">
        {!! $Produk->descripsi !!}
        <p id="read-more-btn">Lihat Selengkapnya</p>
    </div>
</div>
</div>
@endsection
