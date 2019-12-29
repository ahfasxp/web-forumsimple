<?php
//create_cat.php
include 'connect.php';
include 'header.php';

if(empty($_SESSION['signed_in'])){
  header("location:login.php");
}
if (isset($_GET['del'])) {
        $iddel = $_GET['del'];
        $querydel = mysql_query("DELETE FROM artikel WHERE artikel_id='$iddel'");
        if ($querydel) {
            echo '<script>alert(\'Berhasil menghapus postingan\');history.go(-1);</script>';
        }
        else {
            echo '<script>alert(\'Gagal menghapus Postingan"\');history.go(-1);</script>';
        }
}

$result = mysql_query("SELECT artikel.*,users.user_namalengkap,kategori.kategori_nama
            FROM ((artikel INNER JOIN users ON artikel.artikel_by=users.user_id)
                INNER JOIN kategori on artikel.artikel_kat=kategori.kategori_id)
                ORDER BY artikel_tgl DESC");
?>

    <div id="profil">
      <h3>Daftar Postingan</h3>
      <table border =1>
      <tr>
      <th>No</th>
      <th>Judul</th>
      <th>Tanggal</th>
      <th>Penulis</th>
      <th>Kategori</th>
      <th>Aksi</th>
      </tr>
    <?php
    $i=0;
    while($user_data = mysql_fetch_array($result)) {
      $tgl=date('H:i, d M Y', strtotime($user_data['artikel_tgl']));
      $i++;
    ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><a href="article.php?p=<?php echo $user_data['artikel_judul'];  ?>"><?php echo $user_data['artikel_judul']; ?></a></td>
        <td><?php echo $tgl ?></td>
        <td><a href="author.php?p=<?php echo $user_data['artikel_by'];  ?>"><?php echo $user_data['user_namalengkap']; ?></a></td>
        <td><?php echo $user_data['kategori_nama']; ?></td>
        <td>
          <a href="postingan.php?del=<?php echo $user_data['artikel_id'];  ?>">Hapus</a></td>
        </tr>
       <?php } ?>
    </table>
  </div>

<?php include 'footer.php'; ?>