<?php
    require_once("connect.php");
    if(isset($_GET['c_id'])){
        //get the conversation id and
        $conversation_id = base64_decode($_GET['c_id']);
        //fetch all the messages of $user_id(loggedin user) and $user_two from their conversation
        $q = mysql_query("SELECT * FROM `messages` WHERE conversation_id='$conversation_id'");
        //check their are any messages
        if(mysql_num_rows($q) > 0){
            while ($m = mysql_fetch_assoc($q)) {
                //format the message and display it to the user
                $user_form = $m['user_from'];
                $user_to = $m['user_to'];
                $message = $m['message'];
 
                //get name and image of $user_form from `user` table
                $user = mysql_query("SELECT user_id,user_namalengkap,user_image FROM users WHERE user_id='$user_form'");//tadinya USER_NAME
                $user_fetch = mysql_fetch_assoc($user);
                $user_form_username = $user_fetch['user_namalengkap'];//tadinya user_name
                $user_form_img = $user_fetch['user_image'];
                $userid = $user_fetch['user_id'];
 
                //display the message
                echo "
                            <div class='message'>
                                <div class='img-con'>
                                    <img src='img-user/{$user_form_img}'>
                                </div>
                                <div class='text-con'>
                                    <a href='author.php?p={$userid}'>{$user_form_username}</a>
                                    <p>{$message}</p>
                                </div>
                                <hr>
                            </div>";
 
            }
        }else{
            echo "Klik pada Orang untuk memulai Chating.";
        }
    }
 
?>