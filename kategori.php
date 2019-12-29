<?php
//create_cat.php
include 'connect.php';
include 'header.php';

if(empty($_SESSION['signed_in'])){
  header("location:login.php");
}
if (isset($_GET['del'])) {
        $iddel = $_GET['del'];
        $querydel = mysql_query("DELETE FROM kategori WHERE kategori_id='$iddel'");
        if ($querydel) {
            echo '<script>alert(\'Berhasil menghapus Kategori\');history.go(-1);</script>';
        }
        else {
            echo '<script>alert(\'Gagal menghapus Kategori"\');history.go(-1);</script>';
        }
}

if (isset($_POST['buat'])) {
        $iddel = $_POST['nama'];
        $querydel = mysql_query("INSERT INTO kategori(kategori_nama) VALUES ('$iddel')");
        if ($querydel) {
            echo '<script>alert(\'Berhasil Membuat Kategori\');history.go(-1);</script>';
        }
        else {
            echo '<script>alert(\'Gagal Menbuat Kategori"\');history.go(-1);</script>';
        }
}

$result = mysql_query("SELECT * FROM Kategori");
?>

    <div id="profil">
      <h3>Daftar Kategori</h3>
      <table border =1>
      <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Aksi</th>
      </tr>
    <?php
    $i=0;
    while($user_data = mysql_fetch_array($result)) {
      $i++;
    ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $user_data['kategori_nama']; ?></td>
        <td>
          <a href="kategori.php?del=<?php echo $user_data['kategori_id'];  ?>">Hapus</a></td>
        </tr>
       <?php } ?>
    </table>
    <h4>Tambah Kategori</h4>
    <form method="POST">
      <input type="text" name="nama" class="kotak" placeholder="Masukan Nama">
      <input type="submit" name="buat" class="cari" value="Buat">
    </form>
  </div>

<?php include 'footer.php'; ?>