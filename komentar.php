<?php
//create_cat.php
include 'connect.php';
include 'header.php';

if(empty($_SESSION['signed_in'])){
  header("location:login.php");
}
if (isset($_GET['del'])) {
        $iddel = $_GET['del'];
        $querydel = mysql_query("DELETE FROM komentar WHERE komentar_id='$iddel'");
        if ($querydel) {
            echo '<script>alert(\'Berhasil menghapus Komentar\');history.go(-1);</script>';
        }
        else {
            echo '<script>alert(\'Gagal menghapus Komentar"\');history.go(-1);</script>';
        }
}

$result = mysql_query("SELECT komentar.*,users.user_id,users.user_namalengkap,artikel.artikel_judul,artikel.artikel_id FROM komentar INNER JOIN users ON komentar.komentar_nama = users.user_id INNER JOIN artikel ON komentar.komentar_artikel=artikel.artikel_id order by komentar_tgl DESC;");
?>

    <div id="profil">
      <h3>Daftar Komentar</h3>
      <table border =1>
      <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Komentar</th>
      <th>Tanggal</th>
      <th>Postingan</th>
      <th>Aksi</th>
      </tr>
    <?php
    $i=0;
    while($user_data = mysql_fetch_array($result)) {
      $tgl=date('H:i, d M Y', strtotime($user_data['komentar_tgl']));
      $i++;
    ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><a href="author.php?p=<?php echo $user_data['user_id'];  ?>"><?php echo $user_data['user_namalengkap']; ?></a></td>
        <td><?php echo $user_data['komentar_isi']; ?></td>
        <td><?php echo $tgl ?></td>
        <td><a href="article.php?p=<?php echo $user_data['artikel_judul'];  ?>"><?php echo $user_data['artikel_judul']; ?></a></td>
        <td>
          <a href="komentar.php?del=<?php echo $user_data['komentar_id'];  ?>">Hapus</a></td>
        </tr>
       <?php } ?>
    </table>
  </div>

<?php include 'footer.php'; ?>