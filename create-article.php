<?php
include 'connect.php';
include 'header.php';
echo '<div id="buat-post">';

  if(empty($_SESSION['user_id'])){
    header('location:index.php');
  }

  echo '<form method="POST">
          <h3>Buat Postingan</h3>
          <label>Judul</label><br>
          <input type="text" name="judul_artikel" class="judul-post" placeholder="Masukan Judul" required=""<br>
          <label>Kategori</label><br>
            <select class="kategori" name="kat_artikel" required="">
                  <option value=”” disabled selected>Pilih Kategori</option>';
                  $a="SELECT * FROM kategori";
                  $sql=mysql_query($a);
                  while($data=mysql_fetch_array($sql)){
                    echo '<option value="'.$data[0].'">'.$data[1].'</option>';       
                  }
              echo '</select><br>
          <label>Isi</label><br>
          <textarea class="ckeditor" id="ckedtor" name="isi_artikel"></textarea><br>
          <input type="submit" name="save" value="Post article" class="cari">
        </form>';

  if(isset($_POST['save'])) {

    $judulartikel = $_POST['judul_artikel'];
    $kategori = $_POST['kat_artikel'];
    $isiartikel = $_POST['isi_artikel'];
    $penulisartikel = $_SESSION['user_id'];
 
  $query = mysql_query("INSERT INTO artikel(artikel_judul, artikel_isi, artikel_tgl, artikel_kat, artikel_by) VALUES ('$judulartikel', '$isiartikel', NOW(), '$kategori', '$penulisartikel')");
      
      if ($query) {
        echo '<script>alert(\'Berhasil membuat artikel "'.$judulartikel.'"\');history.go(-1);</script>';
      }
      else {
        echo '<script>alert(\'Gagal membuat artikel dengan judul "'.$judulartikel.'"\');history.go(-1);</script>';
      }
  }
  
  echo '</div>';
  include 'footer.php';
?>