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
        $confirmPassword = $_POST['confirmPassword'];
        $email = $_POST['email'];
        $facultyNumber = $_POST['facultyNumber'];
        $admin = 'no';

        if(!$username || !$email || !$password || !$confirmPassword || !$facultyNumber){
            $_SESSION['registrationError'] = '<span class="error-msg">Invalid inputs.</span>';
            header('Location: registration.html');
            exit();
        }

        if($password !== $confirmPassword){
            $_SESSION['registrationError'] = '<span class="error-msg">Invalid inputs.</span>';
            header('Location: registration.html');
            exit();
        }

        $sql = "SELECT * FROM users WHERE username='$username'";
    
        if($result = $connection->query($sql)){
            $usersCount = $result->num_rows;
            if($usersCount>0){
                $_SESSION['registrationError'] = '<span class="error-msg">Username exists.</span>';
                header('Location: registration.html');
            }
        }

        $sql = "INSERT INTO users VALUES (NULL, '$facultyNumber', '$username', '$email', '$password', '$admin')";

        if($connection->query($sql)){
            $_SESSION['newUserSuccess'] = '<span class="success-msg">User is added successfully.</span>';
            unset($_SESSION['addUserError']);
            header('Location: login.html');
        }
        else {
            $_SESSION['addUserError'] = '<span class="error-msg">The user could not be added.</span>';
        }

        $connection->close();
    }

    if(isset($_SESSION['addUserError'])){
        echo $_SESSION['addUserError'];
        unset($_SESSION['addUserError']);
    }

?>