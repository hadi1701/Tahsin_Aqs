<?php
if(!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['roles'] != 'admin') {
    session_destroy(); // hapus semua session
    header("Location: login.php");
    exit; // sangat penting agar kode di bawahnya tidak tetap dijalankan
}

require_once '../module/dbconnect.php';

// Ambil data pembayaran + nama user dari tabel daftar
$stmt = db()->prepare('
    SELECT p.id, p.user_id, p.is_paid, p.is_active, p.foto, d.nama
    FROM pembayaran p
    JOIN daftar d ON p.user_id = d.id
');
$stmt->execute();
$pembayaranData = $stmt->fetchAll(db()::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Pembayaran</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4 d-flex justify-content-center">Validasi Pembayaran</h2>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>
    
     <a href="admin.php" class="btn btn-success mb-3">Kembali</a>   
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr class="text-center">
                <th>ID</th>
                <th>Nama</th>
                <th>Foto</th>
                <th>Status Paid</th>
                <th>Status Active</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($pembayaranData)): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data pembayaran.</td>
                </tr>
            <?php else: ?>
                <?php foreach($pembayaranData as $row): ?>
                <tr class="text-center">
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td>
                        <?php if($row['foto']): ?>
                            <a href="../img/<?= htmlspecialchars($row['foto']) ?>" target="_blank">
                                <img src="../img/<?= htmlspecialchars($row['foto']) ?>" alt="Bukti" width="60" class="rounded shadow-sm">
                            </a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row['is_paid']): ?>
                            <span class="badge bg-success">Sudah</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Belum</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($row['is_active']): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Tombol Update -->
                        <button class="btn btn-sm btn-primary btn-validasi" data-id="<?= $row['user_id'] ?>" data-nama="<?= htmlspecialchars($row['nama']) ?>">
                        Update
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Load jQuery dulu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS (kalau perlu) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="../module/js/setDaftar.js"></script>
<!-- Font Awesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


</body>
</html>
