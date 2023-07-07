<?php
    require_once '_functions.php';
    $conn = db_connect();

    if(!$conn)
        die("Oh Shit!! Connection Failed");

    function countDigits($MyNum){
  $MyNum = (int)$MyNum;
  $count = 0;

  while($MyNum != 0){
    $MyNum = (int)($MyNum / 10);
    $count++;
  }
  return $count;
}


    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup_submit"]))
    {                   
        $username = $_POST['signup_username'];
        $password = $_POST['signup_password'];
        $phone = $_POST['signup_phone'];
        $sql = "SELECT * FROM customers WHERE customer_name = '$username'";
        $result = mysqli_query($conn, $sql);
        

        if(countDigits($phone)<10 || countDigits($phone)>10)
        {
            
            header("Location: ./wrong_number.php");
            
            
        }else
        {
            if($row = mysqli_fetch_assoc($result)){
                
                echo'<div class="container">
        <h1>The Username is already taken</h1>
        <p>Please choose another name </p>
        <a href="../../index.php">Go Back</a>
        </div>';
                
            }else
            {
                $customer_id="CUST-";
    
                $EightDigitRandomNumber = rand(1000000,9999999);
                $customer_id.=$EightDigitRandomNumber;
                echo $customer_id;

                $sqladd = "INSERT INTO `customers` (`customer_id`,`customer_name`,`customer_phone`,`customer_password`,`customer_created`) VALUES ('$customer_id','$username', '$phone','$password',current_timestamp());";
                $result=mysqli_query($conn,$sqladd);
                if($result)
                {
                    echo'<div class="container">
        <h1>Account Registered</h1>
        <p>User successfully created </p>
        <a href="../../index.php">Go Back</a>
        </div>';
                }
            }
            // header("Location: ../../admin/user_dashboard.php");           
        }


        
    }
?>


<style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
.container {
    margin: 0 auto;
    max-width: 600px;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
}

h1 {
    font-size: 28px;
    color: #555;
    margin-top: 0;
}

p {
    font-size: 18px;
    color: #555;
    margin-bottom: 20px;
}

a {
    color: #fff;
    background-color: #4CAF50;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
}

a:hover {
    background-color: #3e8e41;
}
</style>