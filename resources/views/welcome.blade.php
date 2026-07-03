<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koperasi Sejahtera | Simpan Pinjam Terpercaya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-blue-700">
                Koperasi<span class="text-gray-700">Sejahtera</span>
            </div>
            <div class="hidden md:flex space-x-6 font-medium">
                <a href="#" class="hover:text-blue-600">Beranda</a>
                <a href="#profil" class="hover:text-blue-600">Profil</a>
                <a href="#layanan" class="hover:text-blue-600">Layanan</a>
                <a href="#simpanan" class="hover:text-blue-600">Simpanan</a>
                <a href="#pinjaman" class="hover:text-blue-600">Pinjaman</a>
                <a href="#iklan" class="hover:text-blue-600">Iklan</a>
                <a href="#pengumuman" class="hover:text-blue-600">Pengumuman</a>
                <a href="#kontak" class="hover:text-blue-600">Kontak</a>
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Login</a>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="bg-gradient-to-r from-blue-700 to-blue-500 text-white">
        <div class="container mx-auto px-6 py-24 text-center">
            <h1 class="text-5xl font-bold mb-5">Membangun Ekonomi Bersama</h1>
            <p class="text-xl max-w-3xl mx-auto mb-8">
                Koperasi Sejahtera hadir memberikan layanan simpan pinjam yang mudah, aman, transparan dan terpercaya bagi seluruh anggota.
            </p>
            <div>
                <a href="#" class="bg-yellow-400 text-blue-900 px-8 py-3 rounded-full font-bold mr-3">Daftar Anggota</a>
                <a href="#layanan" class="border border-white px-8 py-3 rounded-full">Pelajari Layanan</a>
            </div>
        </div>
    </section>

    <!-- STATISTIK -->
    <section class="container mx-auto px-6 py-12">
        <div class="grid md:grid-cols-4 gap-6">
            <div class="bg-white shadow rounded-xl p-6 text-center">
                <h2 class="text-4xl font-bold text-blue-600">1.250+</h2>
                <p>Jumlah Anggota</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6 text-center">
                <h2 class="text-4xl font-bold text-green-600">850 Juta</h2>
                <p>Total Simpanan</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6 text-center">
                <h2 class="text-4xl font-bold text-yellow-600">500+</h2>
                <p>Pinjaman Aktif</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6 text-center">
                <h2 class="text-4xl font-bold text-purple-600">10 Tahun</h2>
                <p>Pengalaman</p>
            </div>
        </div>
    </section>

    <!-- PROFIL -->
    <section id="profil" class="bg-white py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-8">Tentang Koperasi Sejahtera</h2>
            <p class="text-center text-gray-600 max-w-4xl mx-auto">
                Koperasi Sejahtera merupakan lembaga ekonomi anggota yang bergerak dalam bidang simpan pinjam dengan tujuan meningkatkan kesejahteraan anggota melalui pelayanan keuangan yang profesional dan transparan.
            </p>
        </div>
    </section>

    <!-- LAYANAN -->
    <section id="layanan" class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-bold text-center mb-12">Layanan Kami</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow p-8 text-center">
                <div class="text-5xl mb-4">💰</div>
                <h3 class="text-xl font-bold">Simpanan</h3>
                <p class="text-gray-600 mt-3">Simpanan wajib, pokok dan sukarela dengan pengelolaan aman.</p>
            </div>
            <div class="bg-white rounded-xl shadow p-8 text-center">
                <div class="text-5xl mb-4">📄</div>
                <h3 class="text-xl font-bold">Pinjaman</h3>
                <p class="text-gray-600 mt-3">Pinjaman modal usaha dengan proses mudah dan cepat.</p>
            </div>
            <div class="bg-white rounded-xl shadow p-8 text-center">
                <div class="text-5xl mb-4">🤝</div>
                <h3 class="text-xl font-bold">Keanggotaan</h3>
                <p class="text-gray-600 mt-3">Nikmati berbagai fasilitas khusus anggota koperasi.</p>
            </div>
        </div>
    </section>

    <!-- IKLAN -->
    <section id="iklan" class="bg-blue-50 py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold mb-8 text-center">Iklan & Promo Anggota</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-bold text-lg">Promo Pinjaman Usaha</h3>
                    <p class="mt-3 text-gray-600">Bunga ringan untuk pengembangan usaha anggota.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-bold text-lg">Produk Anggota</h3>
                    <p class="mt-3 text-gray-600">Temukan berbagai usaha anggota koperasi.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-bold text-lg">Program Berkah</h3>
                    <p class="mt-3 text-gray-600">Program hadiah dan penghargaan anggota aktif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PENGUMUMAN -->
    <section id="pengumuman" class="container mx-auto px-6 py-16">
        <h2 class="text-3xl font-bold text-center mb-10">Pengumuman Terbaru</h2>
        <div class="bg-white shadow rounded-xl divide-y">
            <div class="p-5">📢 Rapat Anggota Tahunan akan dilaksanakan bulan depan.</div>
            <div class="p-5">📢 Pembayaran angsuran dapat dilakukan melalui sistem online.</div>
            <div class="p-5">📢 Update layanan digital koperasi terbaru.</div>
        </div>
    </section>

    <!-- TESTIMONI -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-10">Apa Kata Anggota</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow">
                    <p>"Koperasi membantu perkembangan usaha saya."</p>
                    <b>- Ahmad</b>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <p>"Pelayanan cepat dan transparan."</p>
                    <b>- Siti</b>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <p>"Sistem koperasi sangat mudah digunakan."</p>
                    <b>- Rudi</b>
                </div>
            </div>
        </div>
    </section>

    <!-- KONTAK -->
    <section id="kontak" class="container mx-auto px-6 py-16 text-center">
        <h2 class="text-3xl font-bold">Hubungi Kami</h2>
        <p class="mt-4 text-gray-600">
            Alamat : Jl. Koperasi Sejahtera No.10 <br>
            Email : info@koperasisejahtera.com <br>
            Telp : 0812-0000-0000
        </p>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-10">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-white text-xl font-bold mb-3">Koperasi Sejahtera</h3>
            <p>Mitra terpercaya dalam membangun kesejahteraan anggota.</p>
            <p class="mt-5">© 2026 Koperasi Sejahtera. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>