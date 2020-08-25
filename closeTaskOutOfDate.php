<?php
    
    $sql = "SELECT * FROM tasks";

    if($result = $connection->query($sql)){

        $tasksCount = $result->num_rows;

        if($tasksCount>0){
            
            $nowDate = strftime('%F');

            while ($row = mysqli_fetch_array($result)) {

                $rowId = $row['id'];
                $rowDate = $row['date'];

                $closeSQL = "UPDATE tasks SET status = 'closed' WHERE id = '$rowId'";

                if($rowDate < $nowDate){
                    $connection->query($closeSQL);
                }

            }

            $result->free_result();
        }
    }

?>
