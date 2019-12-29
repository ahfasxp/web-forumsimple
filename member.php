<?php
//create_cat.php
include 'connect.php';
include 'header.php';

if(empty($_SESSION['signed_in'])){
  header("location:login.php");
}
if (isset($_GET['del'])) {
        $iddel = $_GET['del'];
        $querydel = mysql_query("DELETE FROM `users` WHERE user_id='$iddel'");
        if ($querydel) {
            echo '<script>alert(\'Berhasil menghapus Member\');history.go(-1);</script>';
        }
        else {
            echo '<script>alert(\'Gagal menghapus Member"\');history.go(-1);</script>';
        }
}
    
if (isset($_GET['adm'])) {
        $iddel = $_GET['adm'];
        $querydel = mysql_query("UPDATE users SET user_level=1 WHERE user_id='$iddel'");
        if ($querydel) {
            echo '<script>alert(\'Berhasil Menjadi Admin\');history.go(-1);</script>';
        }
        else {
            echo '<script>alert(\'Gagal Menjadikan Admin"\');history.go(-1);</script>';
        }
 }

 if (isset($_GET['del_adm'])) {
        $iddel = $_GET['del_adm'];
        $querydel = mysql_query("UPDATE users SET user_level=0 WHERE user_id='$iddel'");
        if ($querydel) {
            echo '<script>alert(\'Berhasil Hapus Admin\');history.go(-1);</script>';
        }
        else {
            echo '<script>alert(\'Gagal Hapus Admin"\');history.go(-1);</script>';
        }
 }

$result = mysql_query("SELECT * FROM users ORDER BY user_id");
?>

    <div id="profil">
      <h3>Daftar Member</h3>
      <table border =1>
      <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Bergabung</th>
      <th>Status</th>
      <th>Aksi</th>
      </tr>
    <?php
    $i=0;
    while($user_data = mysql_fetch_array($result)) {
      $i++;
    ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><a href="author.php?p=<?php echo $user_data['user_id'];  ?>"><?php echo $user_data['user_namalengkap']; ?></td>
        <td><a href="#"><?php echo $user_data['user_email']; ?></a></td>
        <td><?php echo $user_data['user_date']; ?></td>
        <td><?php echo $user_data['user_level']; ?></td>
        <td>
          <?php 
            if ($user_data['user_level']==0) { ?>
               <a href="member.php?adm=<?php echo $user_data['user_id'];  ?>">Jadikan Admin</a>

          <?php  } else{ ?>
              <a href="member.php?del_adm=<?php echo $user_data['user_id'];  ?>">Hapus Admin</a>
          <?php } ?>
          | <a href="member.php?del=<?php echo $user_data['user_id'];  ?>">Hapus</a></td>
        </tr>
       <?php } ?>
    </table>
  </div>

<?php include 'footer.php'; ?>