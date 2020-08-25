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
        <title> Users </title>
        <link rel = "stylesheet" href = "users.css">
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

            <form>
                <fieldset>
                    <form> </form>           
                    <h1> Users </h1>

                    <table class = "tableFill">
                        <thead class = "tableHead">
                            <tr>
                                <th id = "tableHeadOne"> Faculty number </th>
                                <th id = "tableHeadTwo"> Username </th>
                                <th id = "tableHeadThree"> Email </th>
                                <th id = "tableHeadFour"> Action </th>
                            </tr>
                        </thead>

                        <tbody class = "tableBody">

                            <?php
                                $sql = "SELECT * FROM users";

                                if($result = $connection->query($sql)){

                                    $usersCount = $result->num_rows;
                                    if($usersCount>0){

                                        while ($row = mysqli_fetch_array($result)) {
                                            echo "
                                            <tr class = 'tableRow'>
                                                <td>".($row['number'])."</td>
                                                <td>".($row['username'])."</td>
                                                <td>".($row['email'])."</td>
                                                <td>
                                                    <form class = 'formButton' method = 'POST' action = 'deleteUser.php?userName=".$row['username']."'>
                                                        <button class = 'Button' type = 'submit'> Delete </button>
                                                    </form>
                                                </td>
                                            </tr>";
                                        }
                                        $result->free_result();
                                    }
                                    else{
                                        echo "No users.";
                                    }
                                }
                            ?>

                        </tbody>
                    </table>
                </fieldset>
            </form>
        </main>
    </body>
</html>