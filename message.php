<?php
//create_cat.php
include 'connect.php';
include 'header.php';

    //shop not login  users from entering 
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        header("Location: index.php");
    }
?>  
    <div class="message-body">
        <div class="message-left">
            <label>Nama pengguna</label>
            <ul>
                <?php
                    //show all the users expect me
                    $q = mysql_query("SELECT * FROM users WHERE user_id!='$user_id'");
                    //display all the results
                    while($row = mysql_fetch_assoc($q)){
                        echo "<a href='message.php?id={$row['user_id']}'><li><img src='img-user/{$row['user_image']}'> {$row['user_namalengkap']}</li></a>";
                    }
                ?>
            </ul>
        </div>
        
        <div class="message-right">
            <!-- display message -->
            <div class="display-message">
         <?php
                //check $_GET&#91;'id'&#93; is set
                if(isset($_GET['id'])){
                    $user_two = trim(mysql_real_escape_string($_GET['id']));
                    //check $user_two is valid
                    $q = mysql_query("SELECT user_id FROM users WHERE user_id='$user_two' AND user_id!='$user_id'");
                    //valid $user_two
                    if(mysql_num_rows($q) == 1){
                        //check $user_id and $user_two has conversation or not if no start one
                        $conver = mysql_query("SELECT * FROM `conversation` WHERE (user_one='$user_id' AND user_two='$user_two') OR (user_one='$user_two' AND user_two='$user_id')");
 
                        //they have a conversation
                        if(mysql_num_rows($conver) == 1){
                            //fetch the converstaion id
                            $fetch = mysql_fetch_assoc($conver);
                            $conversation_id = $fetch['id'];
                        }else{ //they do not have a conversation
                            //start a new converstaion and fetch its id
                            $q = mysql_query("INSERT INTO conversation VALUES ('','$user_id','$user_two')");
                            $conversation_id = mysql_insert_id($q);
                        }
                    }else{
                        die("Invalid $_GET ID.");
                    }
                }else {
                    die("Klik pada Orang untuk memulai Chating.");
                }
            ?>

            </div>
            <!-- /display message -->
 
            <!-- send message -->
            <div class="send-message">
                <!-- store conversation_id, user_from, user_to so that we can send send this values to post_message_ajax.php -->
                <input type="hidden" id="conversation_id" value="<?php echo base64_encode($conversation_id); ?>">
                <input type="hidden" id="user_form" value="<?php echo base64_encode($user_id); ?>">
                <input type="hidden" id="user_to" value="<?php echo base64_encode($user_two); ?>">
                <div class="form-group">
                    <textarea class="form-control" id="message" placeholder="Tulis Pesan"></textarea>
                </div>
                <button class="btn btn-primary" id="reply">Kirim</button> 
                <span id="error"></span>
            </div>
            <!-- / send message -->
        </div>
    </div>

<?php
include 'footer.php';
?>
 