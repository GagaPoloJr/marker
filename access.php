<?php 
session_start();


if(isset($_SESSION['password'])){
    // set password here
    $previous_page = $_SERVER['HTTP_REFERER'];
    $path_parts = pathinfo($previous_page);
    $result = $path_parts['basename']; //index.php
    header("location:", $result);
}
else {
    $get_password = $_POST['password'];
    if(empty($get_password)){
        echo "halo";
    }
    $password = "admin_map123";
    $uuid = "1111";
    $pass = $get_password;
    if($pass == $password){
        $_SESSION['password'] = $pass;
        $_SESSION['id'] = $uuid;
    }
   
}



?>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script>
            let new_pass = prompt("enter a password:")
            if (new_pass == null || new_pass == "") {
                new_pass = prompt("password salah, silahkan masukkan lagi:")
           

            } else {
                $.ajax({
                    type: "POST",
                    url: "access.php",
                    data: {
                        password: new_pass
                    },
                    success: function(data) {
                        // window.location ="index.php"
                    },
                    error: function(xhr, status, error) {
                        new_pass = prompt("password salah, silahkan masukkan lagi:")
                    }
                })
            }
    </script>
