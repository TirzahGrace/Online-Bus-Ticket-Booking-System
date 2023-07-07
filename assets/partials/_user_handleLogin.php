<?php
    require_once '_functions.php';
    $conn = db_connect();

    if(!$conn)
        die("Oh Shit!! Connection Failed");

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_submit"]))
    {                   
        $username = $_POST['user_username'];
        $password = $_POST['user_password'];
        $sql = "SELECT * FROM customers WHERE customer_name = '$username'";
        $result = mysqli_query($conn, $sql);
        echo $sql;
        if($row = mysqli_fetch_assoc($result)){
            $hash = $row['customer_password'];
            if($password==$hash)
            {
                // Login Sucessfull
                session_start();
                
                $_SESSION["user_loggedIn"] = true;
                $_SESSION["user_id"] = $row["customer_id"];

                header("Location: ../../admin/user_dashboard.php");
                exit;
            }else
            {
                // Login failure
                // echo "failed";
                header("location: ./user_password_mismatch.php");
                echo 'required password:'.$row['customer_password'].' ';
                // $error = true;
                // header("Location: index.php?error=$error");    
            }
            
        }else
        {
            //header("location: ./user_username_not_found.php");
            header("Location: ../../admin/user_dashboard.php");

        }
        
    }
?>