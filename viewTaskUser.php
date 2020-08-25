<?php
    session_start();
    
    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.php');
        exit();
    }

    if(!(isset($_GET['taskId']))){
        header('Location: tasksUser.php');
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
?>

<!doctype html>

<html>
    <head>
        <meta charset = "UTF-8">
        <title> Tasks </title>
        <link rel = "stylesheet" href = "tasks.css">
    </head>

    <body>
        <header id = "header">
            <div>
                <img class = "icon" id = "wolf" src = "Pictures/wolf.png">
                <h1 id = "garib"> GARIB </h1>
            </div>
        </header>

        <main>
            <table id = "iconsTable">
                <tr>
                    <th class = "iconHoover">
                        <div>
                            <a href="dashboardUser.php">
                                <img class = "iconButtons" id = "dashboardButton" src = "Pictures/dashboard.png">
                            </a>
                            <br/>
                            <label> Dashboard </label> 
                        </div>
                    </th>
                    <th class = "iconHoover">
                        <div>
                            <a href="tasksUser.php">
                                <img class = "iconButtons" id = "tasksButton" src = "Pictures/task.png">
                            </a>
                            <br/>
                            <label> Tasks </label> 
                        </div>
                    </th>
                    <th class = "iconHoover">
                        <div>
                            <a href="logout.php">
                                <img class = "iconButtons" id = "logoutButton" src = "Pictures/logout.png">
                            </a>
                            <br/>
                            <label> Logout </label> 
                        </div>
                    </th>
                </tr>
            </table>

            <form class = "taskViewForm" method = "POST",  action = "closeTaskUser.php" enctype="multipart/form-data">
                <fieldset>  
                    <h1> Details for the chosen task </h1>

                    <?php

                        $_SESSION['taskId'] = $taskId;

                        $userName = $_SESSION['user'];
                        $taskSQL = "SELECT * FROM tasks WHERE id = '$taskId'";
                        $resultTask = $connection->query($taskSQL);
                        $rowTask = $resultTask->fetch_assoc();

                        echo 
                        "
                        <p class = 'lableFields'>
                            <label for = 'Number'> Number: </label>
                            <text class = 'textView' name = 'number' placeholder = 'Number'> </br>".$rowTask['number']."</text>
                        </p>
                        <p class = 'lableFields'>
                            <label for = 'subject'> Subject: </label>
                            <text class = 'textView' name = 'subject' placeholder = 'Subject'> </br>".$rowTask['subject']."</text>
                        </p>
                        <p class = 'lableFields'>
                            <label for = 'title'> Title: </label>
                            <text class = 'textView' name = 'title' placeholder = 'Title'> </br>".$rowTask['title']."</text>
                        </p>
                        <p class = 'lableFields'>
                            <label for = 'description'> Description: </label>
                            <text class = 'textView' name = 'description' placeholder = 'Description'> </br>".$rowTask['description']."</text>
                        </p>
                        <p class = 'lableFields'>
                            <label for = 'priority'> Priority: </label>
                            <text class = 'textView' name = 'priority' placeholder = 'Priority'> </br>".$rowTask['priority']."</text>
                        </p>
                        <p class = 'lableFields'>
                            <label for = 'status'> Status: </label>
                            <text class = 'textView' name = 'status' placeholder = 'Status'> </br>".$rowTask['status']."</text>
                        </p>
                        <p class = 'lableFields'>
                            <label for = 'date'> Date: </label>
                            <text class = 'textView' type = 'date' name = 'date' placeholder = 'Date'> </br>".$rowTask['date']."</text>
                        </p>
                        ";
                        
                        if($rowTask['status'] === 'open'){
                            echo 
                            "<p class = 'lableFields'>
                            <label for = 'file'> File: </label>
                            <input type = 'file' name = 'file' placeholder = 'File'/>
                            </p>";
                            echo "<button class = 'Button' type = 'submit' value = 'Register'> Close the task</button>";
                        }

                        $resultTask->free_result();
                    ?>
    
                </fieldset>
            </form>

            <table id = "iconsTable">
                <tr>
                    <th class = "iconHoover">
                        <div>
                            <a href="tasksUser.php">
                                <img class = "iconButtons" id = "dashboardButton" src = "Pictures/back.png">
                            </a>
                            <br/>
                            <label> Back </label> 
                        </div>
                    </th>
                </tr>
            </table>

        </main>
    </body>
</html>