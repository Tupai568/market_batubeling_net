@extends('template.template_home') @section('container')
<main>
    <section class="about">
        <h1>Cara Berjualan</h1>
        <div id="main-content">
            <div id="pendaftaran">
                <h2>Pendaftaran Akun</h2>
                <ol>
                    <li>
                        <h3>Buat Akun Anda</h3>
                        <p>
                            Untuk memulai, klik tombol "Daftar" atau "Buat Akun"
                            di halaman utama.
                        </p>
                        <p>
                            Anda akan diminta untuk mengisi informasi dasar
                            seperti Username (nama pengguna) dan Email (alamat
                            email).
                        </p>
                    </li>
                    <li>
                        <h3>Masukkan Informasi</h3>
                        <ul>
                            <li>
                                <strong>Username</strong>: Pilih nama pengguna
                                unik yang akan digunakan untuk login.
                            </li>
                            <li>
                                <strong>Email</strong>: Masukkan alamat email
                                yang valid karena email ini akan digunakan untuk
                                komunikasi penting dan pemulihan akun.
                            </li>
                        </ul>
                    </li>
                    <li>
                        <h3>Konfirmasi Email</h3>
                        <p>
                            Setelah mendaftar, Anda akan menerima email
                            konfirmasi.
                        </p>
                        <p>
                            Buka email tersebut dan klik link konfirmasi yang
                            diberikan untuk menyelesaikan proses pendaftaran.
                        </p>
                    </li>
                </ol>
            </div>

            <div id="verifikasi">
                <h2>Verifikasi Akun</h2>
                <ol>
                    <li>
                        <h3>Unggah Dokumen</h3>
                        <p>
                            Masuk ke akun Anda dan navigasikan ke menu "Setting"
                            atau "Pengaturan".
                        </p>
                        <p>
                            Di bagian ini, Anda akan menemukan opsi untuk
                            memasukkan NIK (Nomor Induk Kependudukan) dan
                            mengunggah foto KTP (Kartu Tanda Penduduk).
                        </p>
                    </li>
                    <li>
                        <h3>Tunggu Verifikasi</h3>
                        <p>
                            Setelah mengunggah dokumen, proses verifikasi akan
                            dilakukan oleh admin.
                        </p>
                        <p>
                            Anda akan menerima pemberitahuan melalui email atau
                            notifikasi dalam aplikasi ketika verifikasi selesai
                            dan akun Anda siap digunakan.
                        </p>
                    </li>
                </ol>
            </div>

            <div id="ganti-password">
                <h2>Ganti Password</h2>
                <ol>
                    <li>
                        <h3>Akses Menu Profil</h3>
                        <p>
                            Masuk ke akun Anda dan buka menu "Profil" atau
                            "Akun".
                        </p>
                        <p>Pilih opsi untuk mengganti password.</p>
                    </li>
                    <li>
                        <h3>Ubah Password</h3>
                        <ul>
                            <li>
                                <strong>Password Lama</strong>: Isi dengan kata
                                sandi lama Anda.
                            </li>
                            <li>
                                <strong>Password Baru</strong>: Pilih kata sandi
                                baru yang kuat dan mudah diingat. Pastikan
                                password baru memenuhi syarat keamanan seperti
                                kombinasi huruf, angka, dan simbol.
                            </li>
                        </ul>
                        <p>Simpan perubahan untuk memperbarui password.</p>
                    </li>
                </ol>
            </div>

            <div id="fitur">
                <h2>Fitur-Fitur Utama</h2>
                <ul>
                    <li>
                        <h3>Upload</h3>
                        <p>
                            Untuk menambahkan produk baru ke dalam sistem, pilih
                            fitur "Upload".
                        </p>
                        <p>
                            Ikuti petunjuk untuk mengisi detail produk seperti
                            nama, deskripsi, harga, dan gambar produk.
                        </p>
                    </li>
                    <li>
                        <h3>Edit</h3>
                        <p>
                            Jika Anda perlu memperbaiki informasi produk yang
                            sudah diunggah, gunakan fitur "Edit".
                        </p>
                        <p>
                            Temukan produk yang ingin diperbaiki dan perbarui
                            informasi yang salah atau kurang.
                        </p>
                    </li>
                    <li>
                        <h3>Show</h3>
                        <p>
                            Fitur "Show" memungkinkan Anda untuk melihat detail
                            lengkap dari produk yang telah diunggah.
                        </p>
                        <p>
                            Gunakan fitur ini untuk memeriksa dan memastikan
                            semua informasi produk akurat.
                        </p>
                    </li>
                    <li>
                        <h3>Delete</h3>
                        <p>
                            Untuk menghapus produk yang tidak lagi relevan atau
                            ingin dihapus, pilih fitur "Delete".
                        </p>
                        <p>
                            Konfirmasi tindakan penghapusan untuk menghilangkan
                            produk dari daftar Anda.
                        </p>
                    </li>
                    <li>
                        <h3>Tag</h3>
                        <p>
                            Jika Anda ingin menjadikan produk Anda sebagai
                            produk unggulan, gunakan fitur "Tag".
                        </p>
                        <p>
                            Pilih produk yang ingin ditandai dan ikuti proses
                            untuk menambahkan tag unggulan.
                        </p>
                    </li>
                    <li>
                        <h3>Store Profil</h3>
                        <p>
                            Fitur "Store Profil" memungkinkan Anda untuk
                            mengatur dan mengkustomisasi tampilan profil toko
                            Anda.
                        </p>
                        <p>
                            Sesuaikan elemen visual seperti logo, banner, dan
                            deskripsi toko untuk mencerminkan identitas toko
                            Anda.
                        </p>
                    </li>
                    <li>
                        <h3>Featured Product</h3>
                        <p>
                            Untuk memeriksa produk yang terdaftar di kategori
                            unggulan, gunakan fitur "Featured Product".
                        </p>
                        <p>
                            Lihat daftar produk yang telah dipilih sebagai
                            produk unggulan dan pantau statusnya.
                        </p>
                    </li>
                </ul>
            </div>
            
        </div>
    </section>
</main>
@endsection
