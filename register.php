<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
	<head>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    	<meta name="description" content="A short description." />
    	<meta name="keywords" content="put, keywords, here" />
		<title>DISTIN</title>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="style/formulir.css">
	</head>
	<body>
		<div class="form">
			<p class="p">Daftar</p>
			<?php
				include 'connect.php';
				
				if($_SERVER['REQUEST_METHOD'] != 'POST')
				{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    				echo '<form method="post" action="">
        				<label>Nama Lengkap</label>
						<input type="text" name="user_namalengkap" class="kotak-isi" required="" maxlength="35"><br>
						<label>Username</label><br>
						<input type="text" name="user_name" class="kotak-isi" required="" maxlength="10"><br>
						<label>Password</label><br>
						<input type="password" name="user_pass" class="kotak-isi" required="" minlength="6"><br>
						<label>Password Again</label><br>
						<input type="password" name="user_pass_check" class="kotak-isi" required="" minlength="6"><br>
						<label>Email</label><br>
						<input type="email" name="user_email" class="kotak-isi" required=""><br>
						<input type="submit" name="kirim" class="submit" value="Daftar"><br>
						<label>*username dan password digunakan untuk masuk</label>
     				</form>';
				}
				else
					{
					    /* so, the form has been posted, we'll process the data in three steps:
					        1.  Check the data
					        2.  Let the user refill the wrong fields (if necessary)
					        3.  Save the data 
					    */
					    $errors = array(); /* declare the array for later use */
					     
					    if(isset($_POST['user_name']))
					    {
					        //the user name exists
					        if(!ctype_alnum($_POST['user_name']))
					        {
					            $errors[] = 'user name hanya bisa berisi huruf dan angka.!';
					        }
					        if(strlen($_POST['user_name']) > 10)
					        {
					            $errors[] = 'The username cannot be longer than 30 characters.';
					        }
					    }
					    else
					    {
					        $errors[] = 'The username field must not be empty.';
					    }
					     
					     
					    if(isset($_POST['user_pass']))
					    {
					        if($_POST['user_pass'] != $_POST['user_pass_check'])
					        {
					            $errors[] = 'Kedua kata sandi itu tidak cocok.';
					        }
					    }
					    else
					    {
					        $errors[] = 'The password field cannot be empty.';
					    }
					     
					    if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
					    {
					        echo 'Uh-oh .. beberapa bidang tidak diisi dengan benar ..';
					        echo '<ul>';
					        foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
					        {
					            echo '<li>' . $value . '</li>'; /* this generates a nice error list */
					        }
					        echo '</ul>';
					    }
					    else
					    {
					        //the form has been posted without, so save it
					        //notice the use of mysql_real_escape_string, keep everything safe!
					        //also notice the sha1 function which hashes the password
					        $sql = "INSERT INTO
					                    users(user_namalengkap, user_name, user_pass, user_email ,user_date, user_level)
					                VALUES('" . mysql_real_escape_string($_POST['user_namalengkap']) . "',
					                	   '" . mysql_real_escape_string($_POST['user_name']) . "',
					                       '" . md5($_POST['user_pass']) . "',
					                       '" . mysql_real_escape_string($_POST['user_email']) . "',
					                        NOW(),
					                        0)";
					                         
					        $result = mysql_query($sql);
					        if(!$result)
					        {
					            //something went wrong, display the error
					            echo 'Something went wrong while registering. Please try again later.';
					            //echo mysql_error(); //debugging purposes, uncomment when needed
					        }
					        else
					        {
					            echo 'Pendaftaran berhasil. Anda sekarang dapat masuk dan mulai memposting! :^-^) <a href="login.php">Masuk</a>';
					        }
					    }
					}
			?>
			<p><i class="far fa-copyright" style="font-style: normal;"> Copyright 2018 - DISTIN</i></p>
		</div>
	</body>
</html>