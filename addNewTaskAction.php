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
        $number = $_POST['number'];
        $subject = $_POST['subject'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $priority = $_POST['priority'];
        $status = $_POST['status'];
        $date = $_POST['date'];

        if($number === "all"){

            $usersSQL = "SELECT * FROM users WHERE admin = 'no'";
                                
            if($resultUsers = $connection->query($usersSQL)){

                $usersCount = $resultUsers->num_rows;
                if($usersCount>0){

                    while ($rowUsers = mysqli_fetch_array($resultUsers)) {

                        $currentNumber = $rowUsers['number'];
                        $addSQL = "INSERT INTO tasks (number, subject, title, description, priority, status, date) VALUES ('$currentNumber', '$subject', '$title', '$description', '$priority', '$status', '$date')";
                        $connection->query($addSQL);
                    }

                    $resultUsers->free_result();
                }

                header('Location: tasksAdmin.php');
            }else {
                echo "Problem with adding task.";
                $_SESSION['addTaskError'] = '<span class="error-msg">The task could not be added.</span>';
            }
        }else{
            $addSQL = "INSERT INTO tasks (number, subject, title, description, priority, status, date) VALUES ('$number', '$subject', '$title', '$description', '$priority', '$status', '$date')";

            if($connection->query($addSQL)){
                header('Location: tasksAdmin.php');
            }
            else {
                echo "Problem with adding task.";
                $_SESSION['addTaskError'] = '<span class="error-msg">The task could not be added.</span>';
            }
        }

        $connection->close();
    }
?>
