<?php
include 'koneksi.php';
if (isset($_POST['submit'])){
  session_start();
  $username = $_POST['username'];
  $pass = $_POST['password'];
  $ambil="SELECT * FROM `pengguna` WHERE (`username`='$username')"; 
  $data = $conn->query($ambil);
  if ($data->num_rows > 0) {
    while ($row = $data->fetch_assoc()) {
      $username=$row["username"];
      $password=$row["password"];
    }
  }
  $cek = $conn->query("SELECT * FROM `pengguna` WHERE (`username`='$username') AND (`password`='$pass')");
  if (mysqli_num_rows($cek) > 0){
    password_verify($password, $pass);
    $_SESSION['login'] = true;
  }

  else{?>
    <script>
      alert('Username atau password salah!');
      location='index.php';
    </script>
    <?php
  }
}
?>

<!doctype html>
<html lang="id">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
    <script src="//apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//apps.bdimg.com/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <!--- CSS tambahan ---->
    <style type="text/css">
      .kuning_agak_krem{
        color: #F0EBCC;
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
      .bg_kuning_agak_krem{
        background-color: #F0EBCC;
      }
      .tabel_border{
        border-color: #3FDBF0;
        border-width: 0.3em;
      }
    </style>

    <script>
      $(function() {
        $( "#date" ).datepicker({ 
          format:'dd-mm-yyyy'
        });
      });
    </script>

    <title>uangKu</title>
  </head>
  <body>
    <div class="bg_kuning_agak_krem">
      <!---- Navigation bar ---->
      <header>
        <nav>
          <ul class="nav navbar-expand-lg fixed-top justify-content-center biru_agak_ungu p-2">
            <li class="nav-item">
              <a style="font-size: 1.5em;" class="nav-link roboto kuning_agak_krem" aria-current="page" href="#tambahkan">Transaksi baru</a>
            </li>
            <li class="nav-item">
              <a style="font-size: 1.5em;" class="nav-link roboto kuning_agak_krem" href="#transaksi">Transaksi</a>
            </li>
            <li class="nav-item">
              <a style="font-size: 1.5em;"  class="nav-link roboto kuning_agak_krem" href="#pengembang">Pengembang</a>
            </li>
            <li class="nav-item">
              <a style="font-size: 1.5em;" class="nav-link roboto kuning_agak_krem" href="logout.php">Log out</a>
            </li>
          </ul>
        </nav>
      </header>
      <!---- Isi -------->
      <main class="container">
        <!---- Tambahkan data baru ----->
        <div id="tambahkan">
          <br><br><br><br><br><br>
          <div class="card p-2 biru_elektrik" style="margin-right: 25%; margin-left: 25%;">
            <div class="card-body">
              <h3 class="text-center nunito biru_tua fw-bold">Data baru</h3>
              <br>
              <form method="POST" action="">
                <!--- Nama tabel ---->
                <div>
                  <span class="roboto biru_tua" id="inputGroup-sizing-default">Username</span>
                  <input type="text" name="username" class="form-control bg_kuning_agak_krem" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
                <br>
                <!--- Tanggal ---->
                <div>
                  <span class="roboto biru_tua" id="inputGroup-sizing-default">Tanggal</span>
                  <input type="text" id="date" name="tanggal" class="form-control bg_kuning_agak_krem" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
                <br>
                <!---- Nama transaksi ---->
                <div>
                  <span class="roboto biru_tua" id="inputGroup-sizing-default">Nama transaksi</span>
                  <input type="text" name="nama_transaksi" class="form-control bg_kuning_agak_krem" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
                <br>
                <!--- Jenis transaksi ---->
                <select class="form-select form-select-lg roboto biru_tua bg_kuning_agak_krem" name="pilihan" aria-label=".form-select-lg example">
                  <option selected>Jenis transaksi</option>
                  <option value="masuk">Penerimaan</option>
                  <option value="keluar">Pengeluaran</option>
                </select>
                <br>
                <!---- Uang yang dikeluarkan ----->
                <div>
                  <span class="roboto biru_tua" id="inputGroup-sizing-default">Jumlah uang (Rp)</span>
                  <input type="text" name="uang" class="form-control bg_kuning_agak_krem" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                </div>
                <br>
                <!---- submit button ------>
                <div class="text-center">
                  <button type="submit" name="tambah" class="btn btn-lg nunito biru_tua biru_agak_ungu">tambah</button>
                </div>
              </form>
              <!----- Proses Tambahkan data ---->
              <?php
              if (isset($_POST['tambah'])) {
                $username = $_POST['username'];
                $tanggal = $_POST['tanggal'];
                $tanggal_db =  date("Y-m-d", strtotime($tanggal));
                $nama = $_POST['nama_transaksi'];
                if ($_POST['pilihan'] == 'masuk'){
                  $jenis = "penerimaan";
                }
                elseif ($_POST['pilihan']=='keluar') {
                  $jenis = "pengeluaran";
                }
                $jumlah = $_POST['uang'];
                $data_simpan = "INSERT INTO $username (`tanggal`, `nama_transaksi`, `jenis_transaksi`, `jumlah_uang`) VALUES ('$tanggal_db', '$nama', '$jenis', '$jumlah')";
                if (mysqli_query($conn, $data_simpan)) {
                  ?>
                  <br>
                  <span class="roboto biru_tua"><strong>Data tersimpan!</strong></span><br><br>
                  <?php
                }
                else{ ?>
                  <script>alert("<?php echo "Error: " . $data_simpan . "<br>" . mysqli_error($conn); ?>")</script> <?php

                }
              }
              ?>
            </div>
          </div>
        </div>
        <!----- Tampilkan transaksi ----->
        <!---- Function hitung awal setelah submit form ----->
        <?php
        function debit($nama_tbl){
          include 'koneksi.php';
          if (isset($_POST['submit'])) {
            $nama_tbl = $_POST['username'];
            $jumlah_uang_msk = $conn->query("SELECT *, SUM(`jumlah_uang`) AS debit FROM $nama_tbl WHERE `jenis_transaksi`='penerimaan';")->fetch_array()['debit'];
            echo $jumlah_uang_msk;
          }
        }
        function kredit($nama_tbl){
          include 'koneksi.php';
          if (isset($_POST['submit'])) {
            $nama_tbl = $_POST['username'];
            $jumlah_uang_klr = $conn->query("SELECT *, SUM(`jumlah_uang`) AS kredit FROM $nama_tbl WHERE `jenis_transaksi`='pengeluaran';")->fetch_array()['kredit'];
            echo $jumlah_uang_klr;
          }
        }
        function saldo($nama_tbl){
          include 'koneksi.php';
          if (isset($_POST['submit'])) {
            $nama_tbl = $_POST['username'];
            $jumlah_uang_msk = $conn->query("SELECT *, SUM(`jumlah_uang`) AS debit FROM $nama_tbl WHERE `jenis_transaksi`='penerimaan';")->fetch_array()['debit'];
            $jumlah_uang_klr = $conn->query("SELECT *, SUM(`jumlah_uang`) AS kredit FROM $nama_tbl WHERE `jenis_transaksi`='pengeluaran';")->fetch_array()['kredit'];
            $saldo = $jumlah_uang_msk-$jumlah_uang_klr;
            echo $saldo;
          }
        }
        ?>
        <!---- Function hitung setelah tambah ---->
        <?php
        function debit_tambah($nama_tbl){
          include 'koneksi.php';
          if (isset($_POST['tambah'])) {
            $nama_tbl = $_POST['username'];
            $jumlah_uang_msk = $conn->query("SELECT *, SUM(`jumlah_uang`) AS debit FROM $nama_tbl WHERE `jenis_transaksi`='penerimaan';")->fetch_array()['debit'];
            echo $jumlah_uang_msk;
          }
        }
        function kredit_tambah($nama_tbl){
          include 'koneksi.php';
          if (isset($_POST['tambah'])) {
            $nama_tbl = $_POST['username'];
            $jumlah_uang_klr = $conn->query("SELECT *, SUM(`jumlah_uang`) AS kredit FROM $nama_tbl WHERE `jenis_transaksi`='pengeluaran';")->fetch_array()['kredit'];
            echo $jumlah_uang_klr;
          }
        }
        function saldo_tambah($nama_tbl){
          include 'koneksi.php';
          if (isset($_POST['tambah'])) {
            $nama_tbl = $_POST['username'];
            $jumlah_uang_msk = $conn->query("SELECT *, SUM(`jumlah_uang`) AS debit FROM $nama_tbl WHERE `jenis_transaksi`='penerimaan';")->fetch_array()['debit'];
            $jumlah_uang_klr = $conn->query("SELECT *, SUM(`jumlah_uang`) AS kredit FROM $nama_tbl WHERE `jenis_transaksi`='pengeluaran';")->fetch_array()['kredit'];
            $saldo = $jumlah_uang_msk-$jumlah_uang_klr;
            echo $saldo;
          }
        }
        ?>
        <div id="transaksi">
          <?php
          if (isset($_POST['submit'])) {
            ?>
            <br><br><br><br>
            <h1 class="text-center nunito biru_tua fw-bold">Data transaksi</h1>
            <div>
              <h5 class="text-center roboto biru_tua">Jumlah uang masuk: <?php debit($username)?></h5>
              <h5 class="text-center roboto biru_tua">Jumlah uang keluar: <?php kredit($username) ?> </h5>
              <h5 class="text-center roboto biru_tua">Uang yang tersisa: <?php saldo($username) ?> </h5>
            </div>
            <br>
            <div class="table-responsive">
              <table class="table table-bordered tabel_border">
                <thead class="text-center tabel_border">
                  <tr class="tabel_border roboto biru_tua">
                    <th>Tanggal</th>
                    <th>Nama transaksi</th>
                    <th>Jenis transaksi</th>
                    <th>Jumlah uang</th>
                  </tr>
                </thead>
                <tbody class="text-center tabel_border">
                  <?php
                  if (isset($_POST['submit'])) {
                    $username = $_POST['username'];
                    $tabel = mysqli_query($conn,"SELECT * FROM $username");
                    while ($data_tbl = mysqli_fetch_array($tabel)) {?>
                      <tr class="tabel_border roboto biru_tua">
                        <td><?php echo $data_tbl['tanggal']; ?></td>
                        <td><?php echo $data_tbl['nama_transaksi']; ?></td>
                        <td><?php echo $data_tbl['jenis_transaksi']; ?></td>
                        <td><?php echo $data_tbl['jumlah_uang']; ?></td>
                      </tr> <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div> <?php
          }
          else{ ?>
            <br><br><br><br>
            <h1 class="text-center nunito biru_tua fw-bold">Data transaksi</h1>
            <div>
              <h5 class="text-center roboto biru_tua">Jumlah uang masuk: <?php debit_tambah($username)?></h5>
              <h5 class="text-center roboto biru_tua">Jumlah uang keluar: <?php kredit_tambah($username) ?> </h5>
              <h5 class="text-center roboto biru_tua">Uang yang tersisa: <?php saldo_tambah($username) ?> </h5>
            </div>
            <br>
            <div class="table-responsive">
              <table class="table table-bordered tabel_border">
                <thead class="text-center tabel_border">
                  <tr class="tabel_border roboto biru_tua">
                    <th>Tanggal</th>
                    <th>Nama transaksi</th>
                    <th>Jenis transaksi</th>
                    <th>Jumlah uang</th>
                  </tr>
                </thead>
                <tbody class="text-center tabel_border">
                  <?php
                  if (isset($_POST['tambah'])) {
                    $username = $_POST['username'];
                    $tabel = mysqli_query($conn,"SELECT * FROM $username");
                    while ($data_tbl = mysqli_fetch_array($tabel)) {?>
                      <tr class="tabel_border roboto biru_tua">
                        <td><?php echo $data_tbl['tanggal']; ?></td>
                        <td><?php echo $data_tbl['nama_transaksi']; ?></td>
                        <td><?php echo $data_tbl['jenis_transaksi']; ?></td>
                        <td><?php echo $data_tbl['jumlah_uang']; ?></td>
                      </tr> <?php
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <?php
          }
          ?>
          
        </div>
        <!----- Tentang Pengembang ------->
        <div id="pengembang">
          <br><br><br><br>
          <h1 class="text-center nunito biru_tua fw-bold">Tentang Pengembang</h1>
          <br>
          <div class="card mb-3 bg_kuning_agak_krem justify-content-center p-4 border-0" style="max-width: 100%;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="diyas.png" class="img-fluid rounded-start justify-content-center" alt="Diyastri Khotimatul Huda">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <p class="card-text roboto biru_tua">
                    Diyastri Khotimatul Huda. Memiliki hobi membaca, menulis, dan akhir-akhir ini suka membuat dan mengoperasikan website. Semoga karya yang diberikan dapat memberikan manfaat bagi penggunanya. Untuk kritik, saran, dan masukkan bisa disampaikan melalui linkdIn atau whatsapp
                    <br><br><strong>
                    "Raih impianmu dengan mengelola keunganmu!"</strong>
                    <br>
                    <br><a class="roboto biru_tua" style="text-decoration: none;" href="https://www.linkedin.com/in/diyastri-khotimatul-huda-6568171b7/">LinkdIn : Diyastri Khotimatul Huda</a>
                    <br><a class="roboto biru_tua" style="text-decoration: none;" href="https://github.com/askhda">Github: askhda</a>
                    <br><a class="roboto biru_tua" style="text-decoration: none;" href="https://wa.me/+6282337142808">Whatsapp: 0823337142808</a>
                    <br></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br><br><br><br>
      </main>
      <!---- Footer ------>
      <footer style="background-color: #78ACF1; font-family: nunito;">
        <div style="color: #F0EBCC; font-family: nunito, sans-serif; font-size: 1em;" class="container text-center p-2">
          &copy; 2021, uangKu dibuat oleh Diyastri Khotimatul Huda
        </div>
      </footer>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  </body>
</html>