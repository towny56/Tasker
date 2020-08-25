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
                            <a href="dashboardAdmin.php">
                                <img class = "iconButtons" id = "dashboardButton" src = "Pictures/dashboard.png">
                            </a>
                            <br/>
                            <label> Dashboard </label> 
                        </div>
                    </th>
                    <th class = "iconHoover">
                        <div>
                            <a href="tasksAdmin.php">
                                <img class = "iconButtons" id = "tasksButton" src = "Pictures/task.png">
                            </a>
                            <br/>
                            <label> Tasks </label> 
                        </div>
                    </th>
                    <th class = "iconHoover">
                        <div>
                            <a href="users.php">
                                <img class = "iconButtons" id = "usersButton" src = "Pictures/user.png">
                            </a>
                            <br/>
                            <label> Users </label> 
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

            <form class = "taskViewForm" method = "POST",  action = "addNewTaskAction.php">
                <fieldset>  
                    <h1> Add the content for the new task </h1>

                    <p class = "lableFields">
                        <label for = "number"> Number: </label>

                        <select class = "selectStyleClass" name="number" placeholder = "Number">
                            <?php

                                $userName = $_SESSION['user'];
                                $usersSQL = "SELECT * FROM users WHERE admin = 'no'";
                                
                                if($resultUsers = $connection->query($usersSQL)){

                                    $usersCount = $resultUsers->num_rows;
                                    if($usersCount>0){

                                        while ($rowUsers = mysqli_fetch_array($resultUsers)) {
                                            echo "<option value=".$rowUsers['number'].">".$rowUsers['number']."</option>";
                                        }

                                        $resultUsers->free_result();
                                    }
                                    else{
                                        echo "No users.";
                                    }
                                }

                                $allUsers = "all";
                                echo "<option value=".$allUsers.">".$allUsers."</option>";
                            ?>
                        </select> 
                    </p>

                    <p class = "lableFields">
                        <label for = "subject"> Subject: </label>
                        <input type = "text" name = "subject" placeholder = "Subject"/>
                    </p>
                    <p class = "lableFields">
                        <label for = "title"> Title: </label>
                        <input type = "text" name = "title" placeholder = "Title"/>
                    </p>
                    <p class = "lableFields">
                        <label for = "description"> Description: </label>
                        <input type = "text" name = "description" placeholder = "Description"/>
                    </p>
                    <p class = "lableFields">
                        <label for = "priority"> Priority: </label>
                        <select class = "selectStyleClass" name="priority" placeholder = "Priority">
                            <option value="low">low</option>
                            <option value="medium">medium</option>
                            <option value="height">hight</option>
                        </select> 
                    </p>
                    <p class = "lableFields">
                        <label for = "status"> Status: </label>
                        <select class = "selectStyleClass" name = "status" placeholder = "Status">
                            <option value="open">open</option>
                            <option value="closed">closed</option>
                        </select>
                    </p>
                    <p class = "lableFields">
                        <label for = "date"> Date: </label>
                        <input type = "date" name = "date" placeholder = "Date"/>
                    </p>
                    
                    <button class = "Button" type = "submit"> Add task </button>

                </fieldset>
            </form>

            <table id = "iconsTable">
                <tr>
                    <th class = "iconHoover">
                        <div>
                            <a href="tasksAdmin.php">
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