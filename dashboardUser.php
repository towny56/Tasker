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

<?php include 'closeTaskOutOfDate.php';?>

<!doctype html>

<html>
    <head>
        <meta charset = "UTF-8">
        <title> Dashboard </title>
        <link rel = "stylesheet" href = "dashboard.css">
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

            <form>
                <fieldset>                
                    <h1> Dashboard </h1>

                    <table class = "tableFill">
                        <thead class = "tableHead">
                            <tr>
                                <th id = "tableHeadOpen"> Open </th>
                                <th id = "tableHeadClosed"> Closed </th>
                            </tr>
                        </thead>

                        <tbody class = "tableBody">
                            <tr class = "tableRow">
                                <td class = "textData">
                                    <img class = "iconButtons" id = "openButton" src = "Pictures/open.png">
                                </td>
                                <td class = "textData">
                                    <img class = "iconButtons" id = "closedButton" src = "Pictures/close.png"> 
                                </td>
                            </tr>
                            <tr>
                                
                                <?php

                                    $sql = "SELECT * FROM tasks";

                                    if($result = $connection->query($sql)){

                                        $userName = $_SESSION['user'];
                                        $userSQL = "SELECT * FROM users WHERE username = '$userName'";
                                        $resultUser = $connection->query($userSQL);
                                        $rowUser = $resultUser->fetch_assoc();

                                        $userNumber = $rowUser['number'];

                                        $sumOpenSQL = "SELECT count(*) as tasksOpen FROM tasks WHERE status = 'open' AND number = '$userNumber'";
                                        $resultOpen = $connection->query($sumOpenSQL);
                                        $rowOpen = $resultOpen->fetch_assoc();

                                        $sumClosedSQL = "SELECT count(*) as tasksClosed FROM tasks WHERE status = 'closed' AND number = '$userNumber'";
                                        $resultClosed = $connection->query($sumClosedSQL);
                                        $rowClosed = $resultClosed->fetch_assoc();
                                        
                                        echo "
                                            <td name = 'counterOpen'>".$rowOpen['tasksOpen']."</td>
                                            <td name = 'counterClosed'>".$rowClosed['tasksClosed']."</td>";
                                        
                                        $result->free_result();
                                    }

                                ?>

                            </tr>
                            <tr>
                                <td>
                                    <form></form>
                                    <form class = "formButton" method = "POST" action = "tasksOpenUser.php">
                                        <button class = 'Button' type = 'submit'> Open tasks </button>
                                    </form>
                                </td>
                                <td>
                                    <form class = "formButton" method = "POST" action = "tasksClosedUser.php">
                                        <button class = 'Button' type = 'submit'> Closed tasks </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </fieldset>
            </form>
        </main>
    </body>
</html>