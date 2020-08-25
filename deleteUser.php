<?php
    session_start();

    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.php');
        exit();
    }

    if(!(isset($_GET['userName']))){
        header('Location: users.php');
        exit();
    }

    require_once "connect.php";

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0){
        echo "Error: ".$connection->connect_errno . "<br>";
        echo "Description: " . $connection->connect_error;
        exit();
    }

    $userName = $_GET['userName'];

    $deleteSQL = "DELETE FROM users WHERE username = '$userName'";
    $resultDelete = $connection->query($deleteSQL);

    header('Location: users.php');
    exit();
?>