<!doctype html>
<html lang="id">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!--- CSS tambahan ---->
    <style type="text/css">
      .gambar{
        background-image: url('Background3.png');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
      }
      .nunito{
        font-family: nunito, sans-serif;
      }
      .biru_tua{
        color: #05019A;
      }
      .biru_agak_ungu{
        background-color: #78ACF1;
      }
      .roboto{
        font-family: roboto, sans-serif;
      }
      .biru_elektrik{
        background-color: #3FDBF0;
      }
    </style>

    <script type="text/javascript">
      function show_password() {
        var cek = document.getElementById('pass')
        if (cek.type === "password") {
          cek.type = "text";
        }

        else {
          cek.type = "password";
        }
      }
    </script>
    <title>uangKu</title>
  </head>
  <body>
    <div class="gambar">
      <!---- Navigation bar ---->
      <header>
        <nav class="navbar fixed-top" style="background-color: #78ACF1;">
          <div class="container-fluid justify-content-center">
            <a style="text-align: center; color: #F0EBCC; text-decoration: none; font-family: nunito, sans-serif; font-size: 1.7em;" class="fw-bold text-center" href="index.php">uangKu</a>
          </div>
        </nav>
      </header>
      <!---- Isi -------->
      <main class="container">
        <br><br><br><br><br>

        <div class="card p-2" style="background-color: #F0EBCC; margin-right: 25%; margin-left: 25%;">
          <div class="card-body">
            <h3 class="text-center nunito biru_tua fw-bold">Daftar</h3>
            <br>
            <form method="POST" action="">
              <!--- Username ---->
              <div>
                <span class="roboto biru_tua" id="inputGroup-sizing-default">Username</span>
                <input type="text" name="username" class="form-control biru_agak_ungu" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
              </div>
              <br>
              <!--- Password ---->
              <div>
                <span class="roboto biru_tua" id="inputGroup-sizing-default">Password</span>
                <input type="password" id="pass" name="password" class="form-control biru_agak_ungu" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
              </div>
              <br>
              <!---- Show/hide password ---->
              <div class="form-check">
                <input class="form-check-input biru_agak_ungu" type="checkbox" value="" id="flexCheckDefault" onclick="show_password()">
                <span class="roboto biru_tua" for="flexCheckDefault">Tampil password
                </span>
              </div>
              <br>
              <!---- submit button ------>
              <div class="text-center">
                <button type="submit" name="submit" class="btn btn-lg nunito biru_tua biru_elektrik">Daftar</button>
              </div>
            </form>
            <br><br>
            <span class="roboto biru_tua">Sudah punya akun?
              <a class="roboto biru_tua fw-bold" style="text-decoration: none;" href="index.php">Log in</a>
            </span>
          </div>
        </div>
      </main>
      <br><br><br><br>
      <!---- Footer ------>
      <footer style="background-color: #78ACF1; font-family: nunito;">
        <div style="color: #F0EBCC; font-family: nunito, sans-serif; font-size: 1em;" class="container text-center p-2">
          &copy; 2021, uangKu dibuat oleh Diyastri Khotimatul Huda
        </div>
      </footer>
    </div>
    <!--- Proses ---->
    <?php
    include 'koneksi.php';
    if (isset($_POST['submit'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $data_simpan = "INSERT INTO `pengguna`(`username`, `password`) VALUES ('$username', '$password')";
      $tabel = "CREATE TABLE `uangku`.`$username` ( `id` INT NOT NULL AUTO_INCREMENT , `tanggal` DATE NOT NULL , `nama_transaksi` VARCHAR(100) NOT NULL , `jenis_transaksi` VARCHAR(15) NOT NULL , `jumlah_uang` INT NOT NULL , PRIMARY KEY (`id`))";
      if (mysqli_query($conn, $tabel)) {
        if (mysqli_query($conn, $data_simpan)) {
          ?>
          <script>
            alert("Data tersimpan!");
            location = 'index.php';
          </script>
          <?php
        }
        else {?>
          <script>
            alert("<?php echo "Error: " . $data_simpan . "<br>" . mysqli_error($conn); ?>")
          </script>
          <?php
        }
        
      }

      else {?>
        <script>
          alert("<?php echo "Error: " . $tabel . "<br>" . mysqli_error($conn); ?>")
        </script>
        <?php
      }

    }

    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  </body>
</html>