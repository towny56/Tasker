<?php

    session_start();

    /*
    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.html');
        exit();
    }
    */

    require_once "connect.php";

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0){
        echo "Error: ".$connection->connect_errno . "<br>";
        echo "Description: " . $connection->connect_error;
        exit();
    }
    else{
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    
        if($result = $connection->query($sql)){
            $usersCount = $result->num_rows;
            if($usersCount>0){
                $_SESSION['logged-in'] = true;
                $row = $result->fetch_assoc();
                $user = $row['username'];
            
                $result->free_result();
            
                $_SESSION['user'] = $user;
                unset($_SESSION['loginError']);

                $roleSQL = "SELECT * FROM users WHERE username='$username'";
                $resultRole = $connection->query($roleSQL);
                $rowRole = $resultRole->fetch_assoc();

                if($rowRole['admin'] === 'yes'){
                    header('Location: homeAdmin.html');
                }
                else {
                    header('Location: homeUser.html');
                }
            }
            else{
                $_SESSION['loginError'] = '<span class="error-msg">Invalid inputs.</span>';
                if(isset($_SESSION['loginError'])){
                    echo $_SESSION['loginError'];
                }
                header('Location: login.html');
            }
        }
        $connection->close();
    }

    if(isset($_SESSION['loginError'])){
        echo $_SESSION['loginError'];
        exit();
    }

?>