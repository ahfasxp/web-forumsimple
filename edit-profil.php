<?php
//create_cat.php
include 'connect.php';
include 'header.php';

if(empty($_SESSION['signed_in'])){
	header("location:login.php");
}
$id=$_SESSION['user_id'];
	if(isset($_POST['upload'])){
		$ekstensi_diperbolehkan	= array('png','jpg');
		$nama = $_FILES['file']['name'];
		$x = explode('.', $nama);
		$ekstensi = strtolower(end($x));
		$ukuran	= $_FILES['file']['size'];
		$file_tmp = $_FILES['file']['tmp_name'];	
			if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
			    if($ukuran < 1044070){			
				move_uploaded_file($file_tmp, 'img-user/'.$nama);
				$query = mysql_query("UPDATE users SET user_image='$nama' WHERE user_id=$id");
				if($query){
					echo '<script>alert(\'FILE BERHASIL DIUPLOAD\');history.go(-1);</script>';
				}else{
					echo '<script>alert(\'GAGAL MENGUPLOAD GAMBAR\');history.go(-1);</script>';
				}
			    }else{
					echo '<script>alert(\'UKURAN FILE TERLALU BESAR\');history.go(-1);</script>';
			    }
		       }else{
		       		echo '<script>alert(\'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN\');history.go(-1);</script>';
		       }
	    }

if (isset($_POST['kirim'])) {
	$namalengkap=$_POST['user_namalengkap'];
	$email=$_POST['user_email'];
	$catatan=$_POST['user_catatan'];
	$querydel = mysql_query("UPDATE users SET user_namalengkap='$namalengkap', user_email='$email', user_catatan='$catatan'  WHERE user_id='$id'");
        if ($querydel) {
            echo '<script>alert(\'Berhasil Mengedit Profil\');history.go(-1);</script>';
        }
        else {
            echo '<script>alert(\'Gagal Mengedit Profil"\');history.go(-1);</script>';
        }
					 
}


$result = mysql_query("SELECT * FROM users WHERE user_id=$id");
while ($dataxp = mysql_fetch_array($result)) {
	    
?>

<div id="buat-post">
	<h3>Edit Profil</h3>
	<form method="post" action="" enctype="multipart/form-data">
		<img src="img-user/<?php echo $dataxp['user_image']; ?>" class="img-circle"><br>
		<input type="file" name="file">
		<input type="submit" name="upload" value="Upload" class="cari"><br>
	</form>
	<form method="POST">
        <label>Nama Lengkap</label><br>
		<input type="text" name="user_namalengkap" class="judul-post" required="" maxlength="35" value="<?php echo $dataxp['user_namalengkap']; ?>"><br>
		<label>Email</label><br>
		<input type="email" name="user_email" class="judul-post" required="" value="<?php echo $dataxp['user_email']; ?>"><br>
		<label>Catatan</label><br>
		<input type="text" name="user_catatan" class="judul-post" required="" value="<?php echo $dataxp['user_catatan']; ?>"><br>
		<input type="submit" name="kirim" class="cari" value="Kirim"><br>
     </form>
 </div>

 <?php
 } include 'footer.php'; 
 ?>