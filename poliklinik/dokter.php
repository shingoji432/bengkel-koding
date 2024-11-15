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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">

    <title>Dokter</title> <!--Judul halaman-->
</head>
<body>
    <div class="container">
    <h3>
        Dokter
    </h3>
    <hr>

    <!--form input data-->

    <form class="form-row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!--Kode PHP untuk menghubungkan form dengan database-->
        <?php
        $nama = '';
        $alamat = '';
        $no_hp = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli,
            "SELECT * FROM dokter
            WHERE id='" . mysqli_real_escape_string($mysqli, $_GET['id']) . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $nama = $row['nama'];
                $alamat = $row['alamat'];
                $no_hp = $row['no_hp'];
            }
            echo '<input type="hidden" name="id" value="' . $_GET['id'] . '">';
        }
        ?>
        <div class="col">
            <label for="inputNama" class="form-label fw-bold">
                Nama
            </label>
            <input type="text" class="form-control" name="nama" id="inputNama" placeholder="Nama" value="<?php echo $nama ?>">
        </div>
        <div class="col">
            <label for="inputAlamat" class="form-label fw-bold">
                Alamat
            </label>
            <input type="text" class="form-control" name="alamat" id="inputAlamat" placeholder="Alamat" value="<?php echo $alamat ?>">
        </div>
        <div class="col mb-2">
            <label for="inputNoHp" class="form-label fw-bold">
                No HP
            </label>
            <input type="text" class="form-control" name="no_hp" id="inputNoHp" placeholder="No HP" value="<?php echo $no_hp ?>">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
        </div>
    </form>

    <!--Tabel-->
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">No HP</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisikan isi tabel sesuai dengan judul atau head-->
        <tbody>
            <?php
            $result = mysqli_query(
                $mysqli, "SELECT * FROM dokter");
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data ['nama'] ?></td>
                    <td><?php echo $data ['alamat'] ?></td>
                    <td><?php echo $data ['no_hp'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>">Ubah</a>
                        <a class="btn btn-danger rounded-pill px-3" href="index.php?page=dokter&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    if (isset($_POST['simpan'])) {
        $nama = mysqli_real_escape_string($mysqli, $_POST['nama']);
        $alamat = mysqli_real_escape_string($mysqli, $_POST['alamat']);
        $no_hp = mysqli_real_escape_string($mysqli, $_POST['no_hp']);

        if (isset($_POST['id'])) {
            $ubah = mysqli_query($mysqli, "UPDATE dokter SET
                                            nama = '$nama',
                                            alamat = '$alamat',
                                            no_hp = '$no_hp'
                                            WHERE id = '" . mysqli_real_escape_string($mysqli, $_POST['id']) . "'");
        } else {
            $tambah = mysqli_query($mysqli, "INSERT INTO dokter (nama, alamat, no_hp)
                                                 VALUES ('$nama', '$alamat', '$no_hp')");
        }
        echo "<script>document.location='index.php?page=dokter';</script>";
    }

    if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
        $id = mysqli_real_escape_string($mysqli, $_GET['id']);
        $hapus = mysqli_query($mysqli, "DELETE FROM dokter WHERE id = '$id'");

        echo "<script>document.location='index.php?page=dokter';</script>";
    }
    ?>
    </div>
</body>
</html>