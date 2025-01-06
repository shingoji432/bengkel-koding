<?php
session_start();
include 'koneksi.php';

$idMhs = $_GET['id'];
$queryMhs = "SELECT * FROM inputmhs WHERE id = ?";
$stmtMhs = $conn->prepare($queryMhs);
$stmtMhs->bind_param("i", $idMhs);
$stmtMhs->execute();
$resultMhs = $stmtMhs->get_result();
$dataMhs = $resultMhs->fetch_assoc();
$stmtMhs->close();

$queryMatkul = "SELECT * FROM jwl_matakuliah";
$resultMatkul = $conn->query($queryMatkul);

$queryKrs = "SELECT * FROM jwl_mhs WHERE mhs_id = ?";
$stmtKrs = $conn->prepare($queryKrs);
$stmtKrs->bind_param("i", $idMhs);
$stmtKrs->execute();
$resultKrs = $stmtKrs->get_result();
$stmtKrs->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idMatkul = $_POST['id_matkul'];
    $idMatkul = intval($idMatkul);
    $queryIdMatkul = "SELECT * FROM jwl_matakuliah WHERE id = $idMatkul";
    $resultIdMatkul = $conn->query($queryIdMatkul);
    $rowIdMatkul = $resultIdMatkul->fetch_assoc();
    $Matkul = $rowIdMatkul['matakuliah'];
    $sks = $rowIdMatkul['sks'];
    $kelp = $rowIdMatkul['kelp'];
    $ruangan = $rowIdMatkul['ruangan'];

    $conn->begin_transaction();
    try {
        $insertKrs = "INSERT INTO jwl_mhs (mhs_id, matakuliah, sks, kelp, ruangan) VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($insertKrs);
        $stmtInsert->bind_param("isiss", $idMhs, $Matkul, $sks, $kelp, $ruangan);

        if (!$stmtInsert->execute()) {
            throw new Exception("Gagal menambahkan Mata Kuliah: " . $stmtInsert->error);
        }

        $insertInputmhs = "UPDATE inputmhs JOIN(
            SELECT mhs_id, GROUP_CONCAT(matakuliah SEPARATOR ', ') AS matakuliah
            FROM jwl_mhs GROUP BY mhs_id
        ) AS subquery ON inputmhs.id = subquery.mhs_id
        SET inputmhs.matakuliah = subquery.matakuliah;";

        if (!$conn->query($insertInputmhs)) {
            throw new Exception("Gagal memperbarui tabel inputmhs: " . $conn->error);
        }

        $conn->commit();
        $successMessage = "Mata Kuliah berhasil ditambahkan";
    } catch (Exception $e) {
        $conn->rollback();
        $errorMessage = $e->getMessage();
    }

    $stmtInsert->close();
    header("Location: editMhs.php?id=$idMhs");
    exit;
}

if (isset($_GET['hapus'])) {
    if (isset($_GET['id'])) {
        $idKrs = intval($_GET['hapus']);
        $idMhs = intval($_GET['id']);

        $conn->begin_transaction();
        try {
            $deleteKrs = "DELETE FROM jwl_mhs WHERE ID = ?";
            $stmtDelete = $conn->prepare($deleteKrs);
            $stmtDelete->bind_param("isiss", $idMhs, $Matkul, $sks, $kelp, $ruangan);

        if (!$stmtDelete->execute()) {
            throw new Exception("Gagal menghapus Mata Kuliah: " . $stmtDelete->error);
        }

        $stmtDelete->close();

        $updateInputmhs = "UPDATE inputmhs LEFT JOIN(
            SELECT mhs_id, GROUP_CONCAT(matakuliah SEPARATOR ', ') AS matakuliah
            FROM jwl_mhs GROUP BY mhs_id
            ) AS subquery ON inputmhs.id = subquery.mhs_id
            SET inputmhs.matakuliah = COALESCE(subquery.mhs.id)
            WHERE inputmhs.id = ?";
        
        $stmtUpdate = $conn->prepare($updateInputmhs);
        $stmtUpdate->bind_param("i", $idMhs);

        if (!$stmtUpdate->execute()) {
            throw new Exception("Gagal memperbarui tabel inputmhs: " . $conn->error);
        }

        $stmtUpdate->close();
        $conn->commit();
        $successMessage = "Mata Kuliah berhasil dihapus";
    } catch (Exception $e) {
        $conn->rollback();
        $errorMessage = $e->getMessage();
    }

    $stmtInsert->close();
    header("Location: editMhs.php?id=$idMhs");
    exit;
    } else {
        echo "Error: 'id' parameter is missing";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table thead {
            background-color: #468284;
            color: white;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #F0F8FF;
        }
        .table tbody tr:nth-child(even) {
            background-color: #E8F4FA;
        }
        .table tbody tr:hover {
            background-color: #D4ECF9;
        }
        .btn-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.375rem;
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow p-4 mb-5">
            <div class="text-center mb-4">
                <strong>Nama:</strong> <?php echo $dataMhs['namaMhs']; ?>
                <strong>NIM:</strong> <?php echo $dataMhs['nim']; ?>
                <strong>IPK:</strong> <?php echo $dataMhs['ipk']; ?>
            </div>
            <form method="POST" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="id_matkul" class ="form-label">Pilih Mata Kuliah</label>
                        <select id="id_matkul" name="id_matkul" class="form-select" required>
                            <?php while ($rowMatkul = $resultMatkul->fetch_assoc()) { ?>
                                <option value="php echo $rowMatkul['id']; ?>">
                                    <?php echo $rowMatkul['matakuliah']; ?> (<?php echo $rowMatkul['sks']; ?> SKS)
                                </option>
                             <?php } ?>
                        
                        </select>
                        <div class="col-mt-3">
                            <button type="submit" name="submit" class="btn btn-primary w-100">Input Mahasiswa</button>
                        </div>
                    </div>
            </form>
                <?php
                if (isset($_POST['submit'])) {
                    $namaMhs = $_POST['namaMhs'];
                    $nim = $_POST['nim'];
                    $ipk = floatval($_POST['ipk']);
                    $sks = $ipk < 3 ? 20 : 24;

                    $check = $conn->query("SELECT * FROM inputmhs WHERE nim = $nim");
                    if ($check->num_rows > 0) {
                        echo "<div class='alert alert-danger mt-3'>NIM Sudah Digunakan!</div>";
                    } else {
                        $sql = "INSERT INTO inputmhs (namaMhs, nim, ipk, sks) VALUES ('$namaMhs', '$nim', '$ipk', '$sks')";
                        if ($conn->query($sql) === TRUE) {
                            echo "<div class='alert alert-success mt-3'>Mahasiswa berhasil ditambahkan!</div>";
                        } else {
                            echo "<div class='alert alert-danger mt-3'>Terjadi Kesalahan: " . $conn->error . "</div>";
                        }
                    }
                }
                ?>
            </div>

            <div class="card shadow p-4">
                <h2 class="text-center">Matkul Yang Diambil</h2>
                <table class="table table-bordered table-striped table-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Kelompok</th>
                            <th>Ruangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($dataMatkul = $resultKrs->fetch_assoc()) {
                            
                        }
                        ?>
                            <tr>
                                <td><?php echo $no++;?></td>
                                <td><?php echo $dataMatkul['matakuliah'];?></td>
                                <td><?php echo $dataMatkul['sks'];?></td>
                                <td><?php echo $dataMatkul['kelp'];?></td>
                                <td><?php echo $dataMatkul['ruangan'];?></td>
                                <td>
                                    <a href='editMhs.php?id=<?php echo $idMhs;?>&hapus=<?php echo $dataMatkul['id']; ?>'>Edit</a>
                                </td>
                            </tr>";
                            $no++;
                    
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.bundle.min.css"></script>
</body>
</html>