<?php
    
    require '_functions.php';
    $conn = db_connect();

    $admin_id = $_POST["admin_id"];
    $sql = "DELETE FROM users WHERE user_id = $admin_id";
    $result = mysqli_query($conn, $sql);
    if(!$result)
    {
            echo mysqli_error($conn) ;
    }
    else {
        
    header("location: ../../index.php");
        
    }
    
?>
