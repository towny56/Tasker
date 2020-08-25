<?php
    session_start();

    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.php');
        exit();
    }

    if(!(isset($_GET['taskId']))){
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

    $taskId = $_GET['taskId'];

    $deleteSQL = "DELETE FROM tasks WHERE id = '$taskId'";
    $resultDelete = $connection->query($deleteSQL);

    header('Location: tasksAdmin.php');
    exit();
?>