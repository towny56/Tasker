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
                            <a href="dashboard.php">
                                <img class = "iconButtons" id = "dashboardButton" src = "Pictures/dashboard.png">
                            </a>
                            <br/>
                            <label> Dashboard </label> 
                        </div>
                    </th>
                    <th class = "iconHoover">
                        <div>
                            <a href="tasks.php">
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

            <form>
                <fieldset>                
                    <h1> Tasks </h1>

                    <table class = "tableFill">
                        <thead class = "tableHead">
                            <tr>
                                <th id = "tableHeadOne"> Number </th>
                                <th id = "tableHeadTwo"> Subject </th>
                                <th id = "tableHeadThree"> Title </th>
                                <th id = "tableHeadFour"> Priority </th>
                                <th id = "tableHeadFive"> Status </th>
                                <th id = "tableHeadSix"> Date </th>
                                <th id = "tableHeadSeven"> Action </th>
                            </tr>
                        </thead>

                        <tbody class = "tableBody">

                            <?php
                                $sql = "SELECT * FROM tasks";

                                if($result = $connection->query($sql)){

                                    $tasksCount = $result->num_rows;
                                    if($tasksCount>0){

                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "
                                            <tr class = 'tableRow'>
                                                <td>".($row['number'])."</td>
                                                <td>".($row['subject'])."</td>
                                                <td>".($row['title'])."</td>
                                                <td>".($row['priority'])."</td>
                                                <td>".($row['status'])."</td>
                                                <td>".($row['date'])."</td>
                                                <td>
                                                    <table class = 'buttonsTable'>
                                                        <tr>
                                                            <td href='eiewTask.php?id=".$row['id']."' class = 'buttonTableData'>
                                                                <button class = 'Button'> View </button>
                                                            </td>
                                                            <td href='editTask.php?id=".$row['id']."' class = 'buttonTableData'>
                                                                <button class = 'Button'> Edit </button>
                                                            </td>
                                                            <td href='diewTask.php?id=".$row['id']."' class = 'buttonTableData'>
                                                                <button class = 'Button'> Delete </button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>";
                                        }
                                        $result->free_result();
                                    }
                                    else{
                                        echo "No tasks.";
                                    }
                                }
                            ?>

                        </tbody>
                    </table>

                    <button id = "buttonAddTask" class = "Button"> Add task </button>

                </fieldset>
            </form>
        </main>
    </body>
</html>