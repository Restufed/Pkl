<?php
require_once 'database/koneksi.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="asset_login/icomoon/style.css">
    <link rel="stylesheet" href="asset_login/css/owl.carousel.min.css">
    <link rel="stylesheet" href="asset_login/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset_login/css/style.css">

    <title>Login</title>
  </head>
  <body>

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('asset_login/images/bg_1.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Login <strong>sistem manajemen</strong></h3>
            <form action="" method="post">
              <div class="form-group first">
                <label for="username">Username</label>
                <input type="text" class="form-control" placeholder="" id="username" name="pengguna" required>
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="" id="password" name="sandi" required>
              </div>
              <input type="submit" name="btn-login" value="Login" class="btn btn-block btn-primary">
            </form>

            <?php
            if (isset($_POST['btn-login'])) {
                $pengguna   = trim(mysqli_real_escape_string($db, $_POST['pengguna']));
                $sandi      = sha1(trim(mysqli_real_escape_string($db, $_POST['sandi'])));

                $cek_query_pengguna = mysqli_query($db, "SELECT * FROM tb_pengguna WHERE username = '$pengguna' AND sandi = '$sandi'") or die(mysqli_error($db));
                $rv = mysqli_num_rows($cek_query_pengguna);

                if ($rv == 1) {
                    $data  = mysqli_fetch_assoc($cek_query_pengguna);
                    $user  = $data['username'];
                    $peran = $data['peran'];
                    $nama  = $data['nama'];
                    $pin   = $data['pin'];

                    if (!isset($_SESSION)) {
                        session_start();
                    }
                    $_SESSION['user']  = $user;
                    $_SESSION['peran'] = $peran;
                    $_SESSION['nama']  = $nama;
                    $_SESSION['pin']   = $pin;

                    if ($peran == 'S') {
                        echo '<script>window.location.href="2fa"</script>';
                    } elseif ($peran == 'D') {
                        echo '<script>window.location.href="2fa"</script>';
                    } elseif ($peran == 'M') {
                        echo '<script>window.location.href="2fa"</script>';
                    } else {
                        echo '<script>alert("Pengguna tidak ditemukan");</script>';
                        echo '<script>window.location.href="../pkl";</script>';
                    }
                } else {
                    
                    echo '<script>alert("Username atau Password salah!");</script>';
                    echo '<script>window.location.href="index.php";</script>';
                }
            }
            ?>
          </div>
        </div>
      </div>
    </div>

  </div>

    <script src="asset_login/jquery-3.3.1.min.js"></script>
    <script src="asset_login/popper.min.js"></script>
    <script src="asset_login/bootstrap.min.js"></script>
    <script src="asset_login/main.js"></script>
  </body>
</html>