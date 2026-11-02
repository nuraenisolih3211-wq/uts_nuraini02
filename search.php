
<?php
// Data proyek portofolio
$daftarProyek = [
    [
        "nomor" => "01",
        "judul" => "Website Portofolio",
        "deskripsi" => "Website portofolio pribadi menggunakan HTML, CSS, Flexbox, dan PHP dasar."
    ],
    [
        "nomor" => "02",
        "judul" => "Pengujian API",
        "deskripsi" => "Melakukan pengujian API menggunakan metode HTTP, Menganalisis hasil pengujian berdasarkan dokumentasi API."
    ],
    [
        "nomor" => "03",
        "judul" => "Form Kontak",
        "deskripsi" => "Formulir kontak menggunakan method POST dan diproses dengan PHP."
    ],
    [
        "nomor" => "04",
        "judul" => "Analisis Website",
        "deskripsi" => "Analisis performa dan keamanan website menggunakan berbagai alat dan teknik."
    ]
];

// Mengambil kata kunci dari URL menggunakan GET
$kataKunci = trim($_GET["q"] ?? "");
$hasilPencarian = [];

// Fungsi untuk mengamankan output
function amanSearch($teks)
{
    return htmlspecialchars($teks, ENT_QUOTES, "UTF-8");
}

// Memfilter proyek berdasarkan kata kunci
if (!empty($kataKunci)) {
    foreach ($daftarProyek as $proyek) {
        if (
            stripos($proyek["judul"], $kataKunci) !== false ||
            stripos($proyek["deskripsi"], $kataKunci) !== false
        ) {
            $hasilPencarian[] = $proyek;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hasil pencarian proyek portofolio Nuraini Sholihah">
    <title>Hasil Pencarian - Nuraini Sholihah</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<header>
    <div class="container header-content">
        <div>
            <p class="subtitle">PORTOFOLIO MAHASISWA</p>
            <h1>Hasil Pencarian</h1>
            <p>Temukan proyek yang kamu cari.</p>
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
            <p class="section-label">PENCARIAN PROYEK</p>
            <h2>Hasil Pencarian</h2>

            <form action="search.php" method="get">
                <label for="q">Kata kunci proyek</label>

                <div class="search-box">
                    <input
                        type="search"
                        id="q"
                        name="q"
                        value="<?= amanSearch($kataKunci) ?>"
                        placeholder="Contoh: website"
                        required
                    >
                    <button type="submit">Cari</button>
                </div>
            </form>

            <?php if (empty($kataKunci)): ?>

                <p>Silakan masukkan kata kunci untuk mencari proyek.</p>

            <?php elseif (empty($hasilPencarian)): ?>

                <p>
                    Maaf, proyek dengan kata kunci
                    <strong>"<?= amanSearch($kataKunci) ?>"</strong>
                    tidak ditemukan. Coba kata kunci lain, misalnya
                    <strong>website</strong>, <strong>landing page</strong>,
                    atau <strong>kontak</strong>.
                </p>

            <?php else: ?>

                <p>
                    Ditemukan
                    <strong><?= count($hasilPencarian) ?></strong>
                    proyek untuk kata kunci
                    <strong>"<?= amanSearch($kataKunci) ?>"</strong>.
                </p>

                <div class="projects">
                    <?php foreach ($hasilPencarian as $proyek): ?>
                        <div class="project-item">
                            <span class="project-number">
                                <?= amanSearch($proyek["nomor"]) ?>
                            </span>

                            <h3><?= amanSearch($proyek["judul"]) ?></h3>

                            <p><?= amanSearch($proyek["deskripsi"]) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php endif; ?>

            <button class="returnlink">
                <a href="index.html#pencarian" style="text-decoration: none;">Kembali ke halaman utama</a>
            </button>
        </section>
    </article>
</main>

<footer>
    <div class="container footer-content">
        <p>&copy; 2026 Nuraini Sholihah.</p>
        <p>Dibuat dengan HTML, CSS, dan PHP.</p>
    </div>
</footer>

</body>
</html>
