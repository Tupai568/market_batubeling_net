@extends('template.template_home')
@section('container')
<main>
    <section class="about container" id="about">
        <h1 class="about-title">tentang kami</h1>
        <div class="about-description">
            <h2>BATUBELING.net</h2>
            <p>BATUBELING.net adalah salah satu produk inovatif dari BATUBELINGyang merupakan platform marketplace
                terkemuka yang dirancang untuk memberikan kemudahan dan kenyamanan bagi Anda dalam menjual ataupun
                membeli berbagai produk. Kami menghubungkan penjual dan pembeli dalam satu platform yang nyaman, mudah
                dan efisien. BATUBELING.net juga membantu pengembangan usaha anda untuk lebih dikenal dan berprogres
                melalui
                berbagai fitur unggulan yang modern dan efektif. </p>
        </div>


        <!-- about visi -->
        <div class="about-visi" id="about-content">
            <h3 class="visi-title">visi</h3>
            <p>Visi Kami adalah menjadi platform marketplace pilihan utama yang terkemuka dengan memberikan pengalaman
                jual
                beli yang mudah, cepat, dan aman untuk semua pengguna Kami. Kami berkomitmen untuk menyediakan platform
                yang inovatif dan user-friendly yang memenuhi kebutuhan pasar saat ini.</p>
        </div>


        <!-- about misi -->
        <div class="about-misi" id="about-content">
            <h3 class="misi-title">misi</h3>
            <p>Misi Kami adalah mempermudah proses jual beli dengan menyediakan fitur yang memungkinkan pengguna
                untuk:</p>

            <ul class="list-misi">
                <li>Menjual dan membeli barang dengan cepat dan efisien.</li>
                <li>Menemukan produk yang sesuai, dengan harga terbaik melalui pencarian mudah dan filter yang lengkap.
                </li>
                <li>Menjamin keamanan transaksi dengan sistem pembayaran yang terpercaya dan proteksi pengguna.</li>
            </ul>
        </div>


        <!-- about fitur -->
        <div class="about-fitur" id="about-content">
            <h3 class="fitur-title">fitur utama kami</h3>
            <p>Kami menawarkan berbagai fitur yang dirancang untuk meningkatkan pengalaman pengguna:</p>

            <ul class="list-fitur">
                <li><strong>Pencarian Canggih:</strong> Temukan produk yang Anda cari dengan mudah menggunakan fitur
                    pencarian dan filter
                    yang terperinci.</li>
                <li><strong>Daftar dan Kelola Iklan:</strong> Tambahkan iklan dengan cepat dan kelola daftar produk Anda
                    dengan mudah dari
                    dashboard pengguna.</li>
                <li><strong>Komunikasi Langsung:</strong> Hubungi penjual atau pembeli langsung melalui fitur pesan
                    dalam aplikasi. </li>
            </ul>
        </div>

        <!-- about contact -->
        <div class="about-contact" id="about-content">
            <h3 class="about-contact-title">kontak kami</h3>
            <p>Jika Anda memiliki pertanyaan atau memerlukan bantuan, mohon menghubungi Kami melalui:</p>
            
            <!-- email -->
            <div class="about-contact-item">
                <strong class="text-cild-about">Email</strong>
                <a href="" class="link-email">emailbatubeling@gmail.com</a>
            </div>

            <!-- list sosial media -->
            <div class="about-contact-media">
                <strong class="text-cild-about">media</strong>
                <div>Facebok :<a href="https://www.facebook.com/batubelingofficial/" class="link-media">Batubeling</a></div>
                <div>Instagram :<a href="https://www.instagram.com/batubeling_" class="link-media">batubeling_</a></div>
                <div>Youtube :<a href="https://www.youtube.com/c/batubeling" class="link-media">BATUBELING</a></div>
                <div>Tiktok :<a href="http://" class="link-media">batubeling</a></div>
            </div>
        </div>
    </section>
</main>
@endsection