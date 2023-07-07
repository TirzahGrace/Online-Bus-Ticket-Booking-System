<!-- Show these admin pages only when the admin is logged in -->
<?php  require '../assets/partials/_admin-check.php';   ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
        <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d8cfbe84b9.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- CSS -->
    <?php
        require '../assets/styles/admin.php';
        require '../assets/styles/admin-options.php';
        $page="sales";
    ?>
<style>
form {
  display: flex;
  flex-direction: row;
  align-items: center;
  font-size: 16px;
}

label {
    padding: 5px ;
  margin-top: 10px;
  margin-bottom: 5px;
}

input[type="text"],
input[type="date"],
input[type="submit"] {
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  cursor: pointer;
  border-radius: 10px;
  margin: 10px;
}

</style>
</head>
<body>
    <!-- Requiring the admin header files -->
    <?php require '../assets/partials/_admin-header.php';?>

    
    <?php
        /*
            1. Check if an admin is logged in
            2. Check if the request method is POST
        */
     
    if(isset($_GET["busno"]) && isset($_GET["dep_date"]) )
{
    $bus_no = strtoupper(trim($_GET["busno"]));
    $dep_date = $_GET["dep_date"];
    $sql = "SELECT * FROM routes WHERE 1=1";
    
    if (!empty($bus_no)) {
        $sql .= " AND bus_no = '$bus_no'";
    }
    if (!empty($dep_date)) {
        $sql .= " AND route_dep_date = '$dep_date'";
    }
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    $total_sales = 0 ;
    if($num)
        {
            $sql = "SELECT * FROM bookings WHERE 1=1";
            
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $route_id = $row["route_id"];
                        $sql .= " AND route_id = '$route_id'";
                    }
            $result1 = mysqli_query($conn, $sql);
            $num1 = mysqli_num_rows($result);
            
            if($num1)
             {
                
                    ?>
                 <p></p>
                 
                     <table class="table table-hover table-bordered">
                         <thead>
                             <th>PNR</th>
                             <th>Name</th>
                             <th>Contact</th>
                             <th>Bus</th>
                             <th>Route</th>
                             <th>Seat</th>
                             <th>Amount</th>
                             <th>Departure</th>
                             <th>Booked</th>
                         </thead>
                         <?php
                             while($row = mysqli_fetch_assoc($result1))
                             {
                                 $id = $row["id"];
                                 $customer_id = $row["customer_id"];
                                 $route_id = $row["route_id"];

                                 $pnr = $row["booking_id"];

                                 $customer_name = get_from_table($conn, "customers","customer_id", $customer_id, "customer_name");
                                 
                                 $customer_phone = get_from_table($conn,"customers","customer_id", $customer_id, "customer_phone");

                                 $bus_no = get_from_table($conn, "routes", "route_id", $route_id, "bus_no");

                                 $route = $row["customer_route"];

                                 $booked_seat = $row["booked_seat"];
                                 
                                 $booked_amount = $row["booked_amount"];
                                 
                                 $total_sales = $total_sales + $booked_amount ;

                                 $dep_date = get_from_table($conn, "routes", "route_id", $route_id, "route_dep_date");

                                 $dep_time = get_from_table($conn, "routes", "route_id", $route_id, "route_dep_time");

                                 $booked_timing = $row["booking_created"];
                         ?>
                         <tr>
                             <td>
                                 <?php
                                     echo $pnr;
                                 ?>
                             </td>
                             <td>
                                 <?php
                                     echo $customer_name;
                                 ?>
                             </td>
                             <td>
                                 <?php
                                     echo $customer_phone;
                                 ?>
                             </td>
                             <td>
                                 <?php
                                     echo $bus_no;
                                 ?>
                             </td>
                             <td>
                                 <?php
                                     echo $route;
                                 ?>
                             </td>
                             <td>
                                 <?php
                                     echo $booked_seat;
                                 ?>
                             </td>
                             <td>
                                 <?php
                                     echo '$'.$booked_amount;
                                 ?>
                             </td>
                             <td>
                                 <?php
                                     echo $dep_date . " , ". $dep_time;
                                 ?>
                             </td>
                             <td>
                                 <?php
                                     echo $booked_timing;
                                 ?>
                             </td>
                         </tr>
                         <?php
                         }
                     ?>
                     </table>
                 <p></p>
              
                 <?php
                 echo " Total Sales = Rs. $total_sales! ";
                 
                 ?>
                 <br>
                 <p></p>
                 <a href="sales.php" class="btn btn-primary">Back</a>
                 <p></p>
                 
      <?php  }
            }
    else{
        echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> No Matching Records!
            Total Sales = 0 !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
}
        ?>

<form method="GET" >
  <label for="busno" >Bus Number: </label>
  <input type="text" name="busno" id="busno"  placeholder="Bus Number" >
  <br>
  <label for="date" >Departure Date: </label>
  <input type="date" name="dep_date" id="date"  >
  <br>
  <input type="submit" value="Search">
</form>
      
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
