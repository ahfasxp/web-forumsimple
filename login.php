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
			<p class="p">Masuk<p>
			<?php
				include 'connect.php';
				session_start();

    				if($_SERVER['REQUEST_METHOD'] != 'POST')
    				{
        /*the form hasn't been posted yet, display it
          note that the action="" will cause the form to post to the same page it is on */
        				echo '<form method="post" action="">
            			<label>Username</label><br>
						<input type="text" name="user_name" class="kotak-isi" required=""><br>
						<label>Password</label><br>
						<input type="password" name="user_pass" class="kotak-isi" required=""><br>
						<input type="submit" name="kirim" class="submit" value="Masuk">
         				</form>';
    				}
					else
				    {
				        /* so, the form has been posted, we'll process the data in three steps:
				            1.  Check the data
				            2.  Let the user refill the wrong fields (if necessary)
				            3.  Varify if the data is correct and return the correct response
				        */
				        $errors = array(); /* declare the array for later use */
				         
				        if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
				        {
				            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
				            echo '<ul>';
				            foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
				            {
				                echo '<li>' . $value . '</li>'; /* this generates a nice error list */
				            }
				            echo '</ul>';
				        }
				        else
				        {
				            //the form has been posted without errors, so save it
				            //notice the use of mysql_real_escape_string, keep everything safe!
				            //also notice the sha1 function which hashes the password
				            $sql = "SELECT 
				                        user_id
				                    FROM
				                        users
				                    WHERE
				                        user_name = '" . mysql_real_escape_string($_POST['user_name']) . "'
				                    AND
				                        user_pass = '" . md5($_POST['user_pass']) . "'";
				                         
				            $result = mysql_query($sql);
				            if(!$result)
				            {
				                //something went wrong, display the error
				                echo 'Something went wrong while signing in. Please try again later.';
				                //echo mysql_error(); //debugging purposes, uncomment when needed
				            }
				            else
				            {
				                //the query was successfully executed, there are 2 possibilities
				                //1. the query returned data, the user can be signed in
				                //2. the query returned an empty result set, the credentials were wrong
				                if(mysql_num_rows($result) == 0)
				                {
				                    echo 'Username / kata sandi tidak ada. Silakan coba lagi.';
				                }
				                else
				                {
				                    //set the $_SESSION['signed_in'] variable to TRUE

				                    $_SESSION['signed_in'] = true;
				                     
				                    //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
				                    while($row = mysql_fetch_assoc($result))
				                    {
				                        $_SESSION['user_id'] = $row['user_id'];
				                    }

				                	header('location:index.php');
				                	
				                }
				            }
				        }
				    }
			?>
			<hr>
			<label>Belum Punya Akun ?</label><br>
			<a href="register.php">Daftar</a>
			<p style="font-size: 14px;"><i class="far fa-copyright" style="font-style: normal;"> Copyright 2018 - DISTIN</i></p>
		</div>
	</body>
</html>