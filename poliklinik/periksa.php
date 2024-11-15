<?php
include_once("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Bootstrap offline sesuai lokasi file disimpan-->
    <link rel="stylesheet" href="D:\New folder\css\bootstrap.min.css" />

    <!--Bootstrap online-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Periksa</title> <!--Judul halaman-->
</head>
<body>
    <div class="container">
        <h3>Periksa</h3>
        <hr>

        <!--form input data-->
        <form class="form-row" method="POST" action="" name="myForm" onsubmit="return(validate());">
            <!--Kode PHP untuk menghubungkan form dengan database-->
            <?php
            $pasien = '';
            $dokter = '';
            $tgl_periksa = '';
            $catatan = '';
            $obat = '';
            if (isset($_GET['id'])) {
                $ambil = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id='" . $_GET['id'] . "'");
                while ($row = mysqli_fetch_array($ambil)) {
                    $pasien = $row['id_pasien'];
                    $dokter = $row['id_dokter'];
                    $tgl_periksa = $row['tgl_periksa'];
                    $catatan = $row['catatan'];
                    $obat = $row['obat'];
                }
            ?>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <?php
            }
            ?>
            <div class="form-group mx-sm-3 mb-2">
                <label for="inputPasien" class="sr-only">Nama Pasien</label>
                <select class="form-control" name="id_pasien">
                    <?php
                    $pasien_query = mysqli_query($mysqli, "SELECT * FROM pasien");
                    while ($data = mysqli_fetch_array($pasien_query)) {
                        $selected = ($data['id'] == $pasien) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $data['id']; ?>" <?php echo $selected; ?>><?php echo $data['nama']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <label for="inputDokter" class="sr-only">Nama Dokter</label>
                <select class="form-control" name="id_dokter">
                    <?php
                    $dokter_query = mysqli_query($mysqli, "SELECT * FROM dokter");
                    while ($data = mysqli_fetch_array($dokter_query)) {
                        $selected = ($data['id'] == $dokter) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $data['id']; ?>" <?php echo $selected; ?>><?php echo $data['nama']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <label for="inputTglPeriksa" class="form-label fw-bold">HH/BB/TT</label>
                <input type="datetime-local" name="tgl_periksa" id="inputTglPeriksa" value="<?php echo $tgl_periksa; ?>">
            </div>
            <div class="col">
                <label for="inputCatatan" class="form-label fw-bold">Catatan</label>
                <input type="text" class="form-control" name="catatan" id="inputCatatan" placeholder="Catatan" value="<?php echo $catatan; ?>">
            </div>
            <div class="col">
                <label for="inputObat" class="form-label fw-bold">Obat</label>
                <input type="text" class="form-control" name="obat" id="inputObat" placeholder="Obat" value="<?php echo $obat; ?>">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
            </div>
        </form>

        <!--Tabel-->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Pasien</th>
                    <th scope="col">Nama Dokter</th>
                    <th scope="col">Tanggal Periksa</th>
                    <th scope="col">Catatan</th>
                    <th scope="col">Obat</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($mysqli, "SELECT pr.*, d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $no++; ?></th>
                        <td><?php echo $data['nama_pasien']; ?></td>
                        <td><?php echo $data['nama_dokter']; ?></td>
                        <td><?php echo $data['tgl_periksa']; ?></td>
                        <td><?php echo $data['catatan']; ?></td>
                        <td><?php echo $data['obat']; ?></td>
                        <td>
                            <a class="btn btn-success rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id']; ?>">Ubah</a>
                            <a class="btn btn-danger rounded-pill px-3" href="index.php?page=periksa&id=<?php echo $data['id']; ?>&aksi=hapus">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <?php
        if (isset($_POST['simpan'])) {
            if (isset($_POST['id'])) {
                $ubah = mysqli_query($mysqli, "UPDATE periksa SET
                    id_pasien = '" . $_POST['id_pasien'] . "',
                    id_dokter = '" . $_POST['id_dokter'] . "',
                    tgl_periksa = '" . $_POST['tgl_periksa'] . "',
                    catatan = '" . $_POST['catatan'] . "',
                    obat = '" . $_POST['obat'] . "'
                    WHERE id = '" . $_POST['id'] . "'");
            } else {
                $tambah = mysqli_query($mysqli, "INSERT INTO periksa(id_pasien, id_dokter, tgl_periksa, catatan, obat)
                    VALUES (
                        '" . $_POST['id_pasien'] . "',
                        '" . $_POST['id_dokter'] . "',
                        '" . $_POST['tgl_periksa'] . "',
                        '" . $_POST['catatan'] . "',
                        '" . $_POST['obat'] . "'
                    )");
            }

            echo "<script>
                    document.location='index.php?page=periksa';
                </script>";
        }

        if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
            $hapus = mysqli_query($mysqli, "DELETE FROM periksa WHERE id = '" . $_GET['id'] . "'");
            echo "<script>
                    document.location='index.php?page=periksa';
                </script>";
        }
        ?>
    </div>
</body>
</html>
