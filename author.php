<?php

include 'connect.php';
include 'header.php';
if(empty($_SESSION['signed_in'])){
  header("location:login.php");
}

if ($_GET['p']==$_SESSION['user_id']) {
  header("location:profil.php");
}


$id = $_GET['p'];
    $author=mysql_fetch_array(mysql_query("SELECT user_id,user_namalengkap,user_name,user_image,user_catatan FROM users WHERE user_id=$id"));
?>

    <div id="profil">
      <div id="profil-header">
        <img src="img-user/<?php echo $author['user_image']; ?>" class="img-circle"><br>
        <h2><?php echo $author['user_namalengkap']; ?></h2>
        <a href="message.php?id=<?php echo $author['user_id']; ?>" style="color: #FFFFFF;">Kirim Pesan <i class="fas fa-comment"></i></a>
      </div>
        <p><span>Catatan</span></p>
        <p class="catatan">" <?php echo $author['user_catatan']; ?> "</p>
      </div>

<?php
    $idd=$id;



    $has = mysql_query("SELECT artikel.*,users.user_namalengkap,users.user_image,kategori.kategori_nama
            FROM ((artikel INNER JOIN users ON artikel.artikel_by=users.user_id)
                INNER JOIN kategori on artikel.artikel_kat=kategori.kategori_id)
                WHERE artikel_by = $idd
                ORDER BY artikel_tgl DESC");

    $num = mysql_num_rows($has);

    if($num<1){
     echo'<center>Tidak Ada Artikel</center>';
    }
    else{
      while($data=mysql_fetch_array($has)){
      $jumlah=mysql_query("SELECT COUNT(*) from komentar where komentar_artikel = ".$data['artikel_id']);
        $jum=mysql_result($jumlah, 0);
      $art = substr($data['artikel_isi'],0,200);
      $tgl=date('H:i, d M Y', strtotime($data['artikel_tgl']));
      
      
      echo '<div id="postingan">
        <a href=""><img src="img-user/'.$data['user_image'].'" id="img-author" alt="Fp"></a>
          <a href="author.php?p='.$data['artikel_by'].'"><b class="author">'.$data['user_namalengkap'].'</b></a><br>
          <label class="keterangan">'.$tgl.'</label><br>
          <h2 class="judul"><a href="article.php?p='.$data['artikel_judul'].'">'.$data['artikel_judul'].'</a></h2>
          <section>'.$art.'...</section>
          <label class="keterangan" id="komen">'.$jum.' Komentar</label>
          <a href=""><p class="keterangan" id="kategori"><i class="fas fa-tag" style="font-style: normal;"></i>'.$data['kategori_nama'].'</p><a/>
            <a href="article.php?p='.$data['artikel_judul'].'" id="lihat" class="keterangan">Selengkapnya..</a>
        </div>
        <input type="button" value="Ke Atas" id="tombolScrollTop" onclick="scrolltotop()">';



      
      }
      //
      //PAGINASI
      //

    }





















include 'footer.php';  
?>