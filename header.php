<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    	<meta name="description" content="A short description." />
    	<meta name="keywords" content="put, keywords, here" />
		<title>DISTIN</title>
		<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="style/homepage.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="style/twd-menu.js" charset="utf-8"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
	</head>
	<body>
		<?php session_start();
		include 'connect.php'; ?>

			<div id="logo">
				<h1><a href="index.php"><img src="style/images/logo.png" alt="LOGO"></a></h1>
				<div id="adv">
				</div>
			</div>
			<div id="twd-menu" class="normal">
				<form action="search.php" method="GET">
					<a href="index.php"><i class="fas fa-home"></i></a>
					<input type="text" name="cari" placeholder="Cari Postingan" required="" class="kotak">
					<input type="submit" name="" value="Cari" class="cari">	
					<ul>
					<li class="buat-post"><a href="create-article.php"><i class="fas fa-edit"></i> Buat Post</a></li>
					</ul>
				</form>

				<?php
				if(empty($_SESSION['signed_in'])){
	
				echo '<ul>
						<li><a href="login.php">Login</a></li>
					  </ul>';



				}else{
						
						 
						$idxp=$_SESSION['user_id'];
						$result = mysql_query("SELECT * FROM users WHERE user_id=$idxp");
						$num = mysql_num_rows($result);

						    if($num<1){
						     header("location:login.php");
						    }
						while ($dataxp = mysql_fetch_array($result)) {
						?>
								
								<ul>
									<li><a href="profil.php"><img class="img-user" alt="fp" src="img-user/<?php echo $dataxp['user_image']; ?>" width="20px" height="20px"><i><?php echo $dataxp['user_namalengkap']; ?></i></a></li>

									<?php

				if(isset($dataxp['user_name']))
				{
				$nb_new_pm = mysql_fetch_array(mysql_query('SELECT count(*) as nb_new_pm from pm where ((user1="'.$_SESSION['user_id'].'" and user1read="no") or (user2="'.$_SESSION['user_id'].'" and user2read="no")) and id2="1"'));
				$nb_new_pm = $nb_new_pm['nb_new_pm'];
						}
					}
				
				?>

					<li><a href="message.php"><i class="fas fa-comments"></i>  Pesan(<?php echo $nb_new_pm; ?>)</a></li>
					<li><a href="notification.php"><i class="fas fa-bell"></i></a></li>
					<li><a href="logout.php"><i class="fas fa-sign-out"></i>  Keluar</a></li>
				</ul>
			<?php } ?>
			</div>
		<div id="wrapper">
			<div id="content">