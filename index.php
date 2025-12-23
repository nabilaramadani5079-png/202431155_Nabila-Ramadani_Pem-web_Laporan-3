<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4 mb-5 px-5">
        <div class="card shadow-sm border-0">
            <div class="card-header-main text-center rounded-top">
                <h1 class="h4 mb-0">Form Penilaian Mahasiswa</h1>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Masukkan Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Mulyono" value="<?= isset($_POST['nama']) ? $_POST['nama'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">Masukkan NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="202232222" value="<?= isset($_POST['nim']) ? $_POST['nim'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="kehadiran" class="form-label">Nilai Kehadiran (10%)</label>
                        <input type="number" class="form-control" id="kehadiran" name="kehadiran" placeholder="Untuk Lulus minimal 70%" value="<?= isset($_POST['kehadiran']) ? $_POST['kehadiran'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tugas" class="form-label">Nilai Tugas (20%)</label>
                        <input type="number" class="form-control" id="tugas" name="tugas" placeholder="0 - 100" value="<?= isset($_POST['tugas']) ? $_POST['tugas'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="uts" class="form-label">Nilai UTS (30%)</label>
                        <input type="number" class="form-control" id="uts" name="uts" placeholder="0 - 100" value="<?= isset($_POST['uts']) ? $_POST['uts'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="uas" class="form-label">Nilai UAS (40%)</label>
                        <input type="number" class="form-control" id="uas" name="uas" placeholder="0 - 100" value="<?= isset($_POST['uas']) ? $_POST['uas'] : '' ?>">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="proses" class="btn btn-primary">Proses</button>
                    </div>

                    <?php
                    // Logika Validasi Kolom Kosong
                    $isError = false;
                    if (isset($_POST['proses'])) {
                        if (empty($_POST['nama']) || empty($_POST['nim']) || $_POST['kehadiran'] == "" || 
                            $_POST['tugas'] == "" || $_POST['uts'] == "" || $_POST['uas'] == "") {
                            $isError = true;
                            echo "<div class='alert-custom-error'>Semua kolom harus diisi!</div>";
                        }
                    }
                    ?>
                </form>

                <?php
                // TAMPILAN HASIL (Hanya muncul jika tombol PROSES ditekan dan data LENGKAP)
                if (isset($_POST['proses']) && !$isError) 
                {
                    $nama = $_POST['nama'];
                    $nim = $_POST['nim'];
                    $absen = (int)$_POST['kehadiran'];
                    $tugas = (int)$_POST['tugas'];
                    $uts = (int)$_POST['uts'];
                    $uas = (int)$_POST['uas'];

                    $nilai_akhir = ($absen * 0.1) + ($tugas * 0.2) + ($uts * 0.3) + ($uas * 0.4);

                    // Penentuan Grade
                    if ($nilai_akhir >= 85) $grade = "A";
                    elseif ($nilai_akhir >= 70) $grade = "B";
                    elseif ($nilai_akhir >= 55) $grade = "C";
                    elseif ($nilai_akhir >= 40) $grade = "D";
                    else $grade = "E";

                    // Rule Kelulusan
                    $isLulus = ($nilai_akhir >= 60 && $absen > 70 && $tugas >= 40 && $uts >= 40 && $uas >= 40);

                    // Pengaturan Warna
                    $statusClass = $isLulus ? "bg-lulus" : "bg-gagal";
                    $statusText = $isLulus ? "LULUS" : "TIDAK LULUS";
                    $statusColor = $isLulus ? "text-success" : "text-danger";

                    echo "
                    <div class='mt-4 card shadow-sm'>
                        <div class='card-header text-white $statusClass'>Hasil Penilaian</div>
                        <div class='card-body px-5'>
                            <div class='row mb-4 mt-2'>
                                <div class='col-6 text-center'><h5><strong>Nama:</strong> $nama</h5></div>
                                <div class='col-6 text-center'><h5><strong>NIM:</strong> $nim</h5></div>
                            </div>
                            <div class='result-container ps-3'>
                                <p>Nilai Kehadiran: $absen%</p>
                                <p>Nilai Tugas: $tugas</p>
                                <p>Nilai UTS: $uts</p>
                                <p>Nilai UAS: $uas</p>
                                <p>Nilai Akhir: " . number_format($nilai_akhir, 2) . "</p>
                                <p>Grade: $grade</p>
                                <p>Status: <span class='$statusColor status-bold'>$statusText</span></p>
                            </div>
                        </div>
                    </div>";
                    
                    echo "
                    <div class='d-grid gap-2 mt-4'>
                        <a href='laporan.php' class='btn $statusClass'>Selesai</a>
                    </div>";
                }
            
                ?>
            </div>
        </div>
    </div>
</body>
</html>