<?php
    session_start();
    
    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.php');
        exit();
    }

    /*
    if(!(isset($_GET['taskId']))){
        header('Location: tasksUser.php');
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

    /*
    $taskId = $_GET['taskId'];
    */
    $taskId = $_SESSION['taskId'];

    $userName = $_SESSION['user'];
    $taskSQL = "UPDATE tasks SET status = 'closed' WHERE id = '$taskId'";
    $resultTask = $connection->query($taskSQL);

    $targetDir = "Uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array('jpg','png','pdf','docx');

    if(!empty($_FILES["file"]["name"])){
        if(in_array($fileType, $allowTypes)){
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                $insertSQL = "INSERT into files (name, number, task) VALUES ('$fileName', '$number', '$taskId')";
                $connection->query($insertSQL);
            }
        }
    }

    if($resultTask){
        header('Location: tasksUser.php');
        exit();
    }
    else{
        echo '<span class="error-msg">SQL error. </span>';
    }
?>
