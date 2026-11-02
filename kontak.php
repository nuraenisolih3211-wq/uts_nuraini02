
    <?php
    // Halaman ini harus menerima data dari form POST
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: index.html#kontak");
        exit;
    }

    // Mengambil dan membersihkan input
    $nama  = trim($_POST["nama"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $pesan = trim($_POST["pesan"] ?? "");
    $telpon = trim($_POST["telpon"] ?? "");

    $errors = [];

    // Validasi nama
    if (empty($nama)) {
        $errors[] = "Nama wajib diisi.";
    } elseif (strlen($nama) > 100) {
        $errors[] = "Nama maksimal 100 karakter.";
    }

    // Validasi email
    if (empty($email)) {
        $errors[] = "Email wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid. Contoh: nama@email.com.";
    } elseif (strlen($email) > 254) {
        $errors[] = "Email terlalu panjang.";
    }

    // Validasi nomor telepon
    if (empty($telpon)) {
        $errors[] = "No Telpon wajib diisi.";
    } elseif (!preg_match("/^[0-9]{10,15}$/", $telpon)) {
        $errors[] = "Nomor telepon harus terdiri dari 10 sampai 15 angka.";
    }



    // Validasi pesan
    if (empty($pesan)) {
        $errors[] = "Pesan wajib diisi.";
    } elseif (strlen($pesan) > 5000) {
        $errors[] = "Pesan maksimal 5000 karakter.";
    }

    // Simpan pesan ke file teks jika semua validasi berhasil
    if (empty($errors)) {
        // Amankan baris untuk kolom singkat dan pertahankan baris baru pada pesan
        $namaFile = str_replace(["\r", "\n"], " ", $nama);
        $emailFile = str_replace(["\r", "\n"], " ", $email);
        $telponFile = str_replace(["\r", "\n"], " ", $telpon);

        $isiFile = "========================================\n";
        $isiFile .= "Tanggal: " . date("Y-m-d H:i:s") . "\n";
        $isiFile .= "Nama: " . $namaFile . "\n";
        $isiFile .= "Email: " . $emailFile . "\n";
        $isiFile .= "No Telpon: " . $telponFile . "\n";
        $isiFile .= "Pesan:\n" . $pesan . "\n";
        $isiFile .= "========================================\n\n";

        $lokasiFile = __DIR__ . DIRECTORY_SEPARATOR . "pesan_kontak.txt";
        $tersimpan = file_put_contents($lokasiFile, $isiFile, FILE_APPEND | LOCK_EX);

        if ($tersimpan === false) {
            $errors[] = "Pesan belum dapat disimpan ke file teks. Pastikan folder website dapat ditulisi oleh PHP.";
        }
    }

    // Mengamankan data sebelum ditampilkan
    function amanKontak($teks)
    {
        return htmlspecialchars($teks, ENT_QUOTES, "UTF-8");
    }
    ?>

    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Hasil formulir kontak portofolio Nuraini Sholihah">
        <title>Form Kontak - Nuraini Sholihah</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body>

    <header>
        <div class="container header-content">
            <div>
                <p class="subt  itle">PORTOFOLIO MAHASISWA</p>
                <h1>Formulir Kontak</h1>
                <p>Terima kasih telah menghubungi saya.</p>
            </div>
        </div>
    </header>

    <nav aria-label="Navigasi utama">
        <div class="container nav-content">
            <a href="index.html#tentang">Tentang</a>
            <a href="index.html#pendidikan">Pendidikan</a>
            <a href="index.html#keahlian">Keahlian</a>
            <a href="index.html#proyek">Proyek</a>
            <a href="index.html#kontak">Kontak</a>
        </div>
    </nav>

    <main class="container main-layout">
        <article>
            <section class="card">

                <?php if (!empty($errors)): ?>

                    <p class="section-label">PERIKSA KEMBALI</p>
                    <h2>Pesan Belum Dapat Diproses</h2>

                    <p>Mohon perbaiki data berikut:</p>

                    <ul style="padding-left: 22px; margin-bottom: 20px;">
                        <?php foreach ($errors as $error): ?>
                            <li><?= amanKontak($error) ?></li>
                        <?php endforeach; ?>
                    </ul>

                    <a href="index.html#kontak">Kembali ke formulir kontak</a>

                <?php else: ?>

                    <p class="section-label">KONTAK BERHASIL</p>
                    <h2>Terima Kasih, <?= amanKontak($nama) ?>!</h2>

                    <p>
                        Data formulir kamu berhasil diterima dan lolos validasi.
                        Berikut ringkasan data yang kamu kirim:
                    </p>

                    <div class="profile-info">
                        <div>
                            <strong>Nama</strong>
                            <span><?= amanKontak($nama) ?></span>
                        </div>

                        <div>
                            <strong>Email</strong>
                            <span><?= amanKontak($email) ?></span>
                        </div>

                        <div>
                            <strong>No Telpon</strong>
                            <span><?= amanKontak($telpon) ?></span>
                        </div>

                        <div>
                            <strong>Pesan</strong>
                            <span><?= nl2br(amanKontak($pesan)) ?></span>
                        </div>
                    </div>

                    <p>
                        Pesan tersimpan di file teks pada folder yang sama dengan
                        <strong>kontak.php</strong>. Buka file
                        <strong>pesan_kontak.txt</strong>
                    </p>

                    <button class="returnlink">
                        <a href="index.html#kontak" style="text-decoration: none;">
                            Kembali ke formulir kontak
                        </a>
                    </button>

                    <button class="returnlink">
                        <a href="index.html" style="text-decoration: none;">
                            Kembali ke halaman utama
                        </a>
                    </button>
                <?php endif; ?>

            </section>
        </article>
    </main>

    <footer>
        <div class="container footer-content">
            <p>&copy; 2026 Nuraini Sholihah.</p>
        </div>
    </footer>

    </body>
    </html>
