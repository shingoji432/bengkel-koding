<?php
include_once("koneksi.php");
include("index.php");
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

    <title>RegistrasiUser</title> <!--Judul halaman-->
</head>
<body>
    <div class="container">
    <h3>
        Register
    </h3>
    <hr>

    <!--form input data-->

    <form class="form-row" method="POST" action="" name="myForm" onsubmit="return(validate());">
        <!--Kode PHP untuk menghubungkan form dengan database-->
        <?php
        $username = '';
        $password = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli,
            "SELECT * FROM pengguna
            WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
                $username = $row['username'];
                $password = $row['password'];
            }
        
            echo '<input type="hidden" name="id" value="' 
           .  $_GET['id'] . '">';
        
        }
        ?>
        <div class="form-group">
            <label for="inputUsername" class="form-label fw-bold">
                Username
            </label>
            <input type="text" class="form-control" name="username" id="inputUsername" placeholder="Username" value="<?php echo $username ?>">
        </div>
        <div class="col">
            <label for="inputPassword" class="form-label fw-bold">
                Password
            </label>
            <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password" value="<?php echo $password ?>">
        </div>
        <div class="col mb-2">
            <label for="confirmPassword" class="form-label fw-bold">
                Konfirmasi Password
            </label>
            <input type="password" class="form-control" name="confirmPass" id="confirmPassword" placeholder="Konfirmasi Password" value="<?php echo $password ?>">
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary rounded-pill px-3" name="register">Register</button>
        </div>
    </form>

    <?php
        if (isset($_POST['register'])) {
            // Validate form inputs
            $username = mysqli_real_escape_string($mysqli, $_POST['username']);
            $password = $_POST['password'];
            $confirmPass = $_POST['confirmPass'];

            // Ensure passwords match
            if ($password !== $confirmPass) {
                echo '<div class="alert alert-danger mt-3">Password dan Konfirmasi Password tidak cocok.</div>';
            } else {
                // Hash the password before storing it
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                if (isset($_GET['id'])) {
                    // Update existing user data
                    $id = $_GET['id'];
                    $query = "UPDATE pengguna SET username='$username', password='$hashed_password' WHERE id='$id'";
                } else {
                    // Insert new user data
                    $query = "INSERT INTO pengguna (username, password) VALUES ('$username', '$hashed_password')";
                }

                // Execute the query
                if (mysqli_query($mysqli, $query)) {
                    echo "<script>
                            alert('User berhasil ditambahkan!');
                            document.location='index.php?page=loginUser.php';
                          </script>";
                } else {
                    echo '<div class="alert alert-danger mt-3">Terjadi kesalahan dalam pendaftaran. Silakan coba lagi.</div>';
                }
            }
        }
        ?>
    </div>
</body>
</html>