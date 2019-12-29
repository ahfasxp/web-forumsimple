<?php

include 'connect.php';
include 'header.php';


echo '<div id="postingan">';

$id = $_GET['p'];

$hasil = mysql_query("SELECT artikel.*,users.user_namalengkap,users.user_image,kategori.kategori_nama
						FROM ((artikel INNER JOIN users ON artikel.artikel_by=users.user_id)
      					INNER JOIN kategori on artikel.artikel_kat=kategori.kategori_id)
      					where artikel_judul='$id'");

$data=mysql_fetch_array($hasil);
$tgl=date('H:i, d M Y', strtotime($data['artikel_tgl']));

	echo '<a href=""><img src="img-user/'.$data['user_image'].'" id="img-author" alt="Fp"></a>
		  <a href="author.php?p='.$data['artikel_by'].'"><b class="author">'.$data['user_namalengkap'].'</b></a><br>
		  <label class="keterangan">'.$tgl.'</label>
		  <h2 class="judul">'.$data['artikel_judul'].'</h2>
		  <section>'.$data['artikel_isi'].'</section>
		  <a href=""><p class="keterangan" id="kategori"><i class="fas fa-tag" style="font-style: normal;"></i>'.$data['kategori_nama'].'</p><a/>
      <input type="button" value="Ke Atas" id="tombolScrollTop" onclick="scrolltotop()"> 
		';

echo '</div>';
?>
	<div id="komentar">

        <form method="POST">
        	<label>Komentar</label><br>
            <textarea name="komentar" placeholder="Tulis Komentar..." required=""></textarea><br>
            <input type="submit" name="comment" value="Post comment" class="cari">
        </form>
	<script type='text/javascript'>
    //<![CDATA[
    $(document).ready(function(){
     $('a[href^="#"]').on('click',function (e) {
         e.preventDefault();

         var target = this.hash,
         $target = $(target);

         $('html, body').stop().animate({
             'scrollTop': $target.offset().top -80
         }, 900, 'swing', function () {
             window.location.hash = target;
         });
     });
    });
    //]]>
    </script>
<?php  

    $komentar_artikel = $data['artikel_id'];
            
        if (isset($_POST['comment'])) {
            if(empty($_SESSION['user_id'])){
                echo "<script>alert('Gagal menambahkan komentar!. Silahkan Masuk untuk membuat postingan dan komentar.^-^');history.go(-1);</script>";
            }else{

              $nama = $_SESSION['user_id'];
              $komentar = $_POST['komentar'];
                $query_submit = mysql_query("INSERT INTO komentar(`komentar_id`, `komentar_artikel`, `komentar_nama`, `komentar_isi`, `komentar_tgl`, `komentar_refid`) VALUES ('','$komentar_artikel','$nama','$komentar',NOW(),0)");
                if ($query_submit) {
                    echo "<script>alert('Komentar berhasil dikirimkan !');history.go(-1);</script>";
                }
                else {
                    echo "<script>alert('Gagal menambahkan komentar !. Silahkan Masuk untuk membuat postingan dan komentar.^-^');history.go(-1);</script>";
                }
              }
          }

    //ini inputnya
    $query_komentar = mysql_query("SELECT komentar.*,users.user_id,users.user_namalengkap,users.user_image
	FROM komentar INNER JOIN users ON komentar.komentar_nama = users.user_id
	WHERE komentar_artikel = ".$komentar_artikel." and komentar_refid=0 order by komentar_id DESC;");

    $jumlah=mysql_query("SELECT COUNT(*) from komentar where komentar_artikel = ".$komentar_artikel);
    $jum=mysql_result($jumlah, 0);

    if (mysql_num_rows($query_komentar) == 0) {
            /*echo "";*/
    }
    else {
            echo "<p>".$jum." Komentar</p>";
    };
        
    if (mysql_num_rows($query_komentar) == 0) {
        echo '<br><br><br><center>"Tidak ada Komentar"</center><br><br><br>';
    }

	else{       
            while ($data_komentar = mysql_fetch_array($query_komentar)){
                    //Systax Tampilan Komentar
                    $tgl_kom=date('H:i, d M Y', strtotime($data_komentar['komentar_tgl']));
                    echo '<a href=""><img src="img-user/'.$data_komentar['user_image'].'" id="img-komen" alt="Fp"></a>
                    	<a href="author.php?p='.$data_komentar['user_id'].'"><b class="author">'.$data_komentar['user_namalengkap'].'</b></a><br>
		  				<label class="tgl">'.$tgl_kom.'</label>
		  				<p class="isi">'.$data_komentar['komentar_isi'].'</p>
                    ';
            }
                    
        }
    echo "</div>";
                                  
include 'footer.php';    
?>