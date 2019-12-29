<?php
//create_cat.php
include 'connect.php';
include 'header.php';

if(empty($_SESSION['signed_in'])){
	header("location:login.php");
}
$id=$_SESSION['user_id'];
		$result = mysql_query("SELECT * FROM users WHERE user_id=$id");
		while ($dataxp = mysql_fetch_array($result)) {
?>
		<div id="profil">
			<div id="profil-header">
				<img src="img-user/<?php echo $dataxp['user_image']; ?>" class="img-circle"><br>
				<h2><?php echo $dataxp['user_namalengkap']; ?></h2>
				<a href="edit-profil.php"><i class="far fa-edit"> Edit Profil</i></a>
			</div>
				<p><span>Catatan</span></p>
				<p class="catatan"><?php echo $dataxp['user_catatan']; ?></p>
			</div>
<?php
	}
		$user=$_SESSION['user_id'];
		$arCount=mysql_fetch_array(mysql_query("SELECT COUNT(artikel_by) FROM artikel WHERE artikel_by=$user"));
		$banyakdata=$arCount[0];
		$page=isset($_GET['data'])?$_GET['data']:1;
		$limit=5;
		$mulai_dari=$limit * ($page-1);
		//Paginasi



		$has = mysql_query("SELECT artikel.*,users.user_namalengkap,users.user_image,kategori.kategori_nama
						FROM ((artikel INNER JOIN users ON artikel.artikel_by=users.user_id)
      					INNER JOIN kategori on artikel.artikel_kat=kategori.kategori_id)
      					WHERE artikel_by = $user
      					ORDER BY artikel_tgl DESC LIMIT $mulai_dari,$limit");

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
		  		<a href="profil.php?del='.$data['artikel_id'].'" id="del"><i class="fas fa-trash"></i></a>
		  		<label class="keterangan">'.$tgl.'</label><br>
		     	<h3 class="judul"><a href="article.php?p='.$data['artikel_judul'].'">'.$data['artikel_judul'].'</a></h3>
		     	<section>'.$art.'...</section>
		     	<label class="keterangan" id="komen">'.$jum.' Komentar</label>
		     	<a href=""><p class="keterangan" id="kategori"><i class="fas fa-tag" style="font-style: normal;"></i>'.$data['kategori_nama'].'</p><a/>
		        <a href="article.php?p='.$data['artikel_judul'].'" id="lihat" class="keterangan">Selengkapnya..</a>
				</div>';



			}
			//
			//PAGINASI
			//
			echo "<div id='paginasi'>";
			echo "</br><center>"; 
			$banyakHalaman = ceil($banyakdata / $limit);  
			echo 'Halaman : ';  
			for($i = 1; $i <= $banyakHalaman; $i++){  
			if($page != $i){  
			echo '[<a href="?data='.$i.'">'.$i.'</a>]';
			}else{  
			echo "[$i] ";  
			}  
			}
			echo "</center>";
			echo "</div>";
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
include 'footer.php';
?>