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

    <title>LoginUser</title> <!--Judul halaman-->
</head>
<body>
    <div class="container">
    <h3>
        Login
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
        ?>
            <input type="hidden" name="id" value="<?php echo 
            $_GET['id'] ?>">
        <?php
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
        <div class="col">
            <button type="submit" class="btn btn-primary rounded-pill px-3" name="login">Login</button>
        </div>
    </form>

    <?php
    if (isset($_POST['login'])) {
        // Sanitize user inputs to prevent SQL injection
        $username = mysqli_real_escape_string($mysqli, $_POST['username']);
        $password = $_POST['password'];

        // Query to check if user exists
        $query = "SELECT * FROM pengguna WHERE username='$username'";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            $user = mysqli_fetch_array($result);

            // Check if user exists and verify password
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    // Start session and store user data
                    session_start();
                    $_SESSION['user'] = $user;

                    // Redirect to home page (index.php)
                    header("Location: index.php");
                    exit();
                } else {
                    // Invalid password
                    echo '<div class="alert alert-danger mt-3">Password salah!</div>';
                }
            } else {
                // User not found
                echo '<div class="alert alert-danger mt-3">Username tidak ditemukan!</div>';
            }
        } else {
            echo '<div class="alert alert-danger mt-3">Terjadi kesalahan, coba lagi!</div>';
        }
    }
    ?>
    </div>
</body>
</html>