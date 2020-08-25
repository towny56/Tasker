<?php
    session_start();
    
    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.php');
        exit();
    }
    
    require_once "connect.php";

    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0){
        echo "Error: ".$connection->connect_errno . "<br>";
        echo "Description: " . $connection->connect_error;
        exit();
    }
    else {
        $taskId = $_SESSION['taskId'];
        $number = $_POST['number'];
        $subject = $_POST['subject'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $priority = $_POST['priority'];
        $status = $_POST['status'];
        $date = $_POST['date'];

        $editSQL = "UPDATE tasks SET number = '$number', subject = '$subject', title = '$title', description = '$description', priority = '$priority', status = '$status', date = '$date' WHERE id = '$taskId'";
        
        if($connection->query($editSQL)){
            header('Location: tasksAdmin.php');
        }
        else {
            $_SESSION['editTaskError'] = '<span class="error-msg">The task could not be edited.</span>';
        }

        $connection->close();
    }
?>
