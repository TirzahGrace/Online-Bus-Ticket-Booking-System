<!-- Show these admin pages only when the admin is logged in -->
<?php  require '../assets/partials/_userlogin-check.php';   ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings</title>
        <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d8cfbe84b9.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- External CSS -->
    <?php
        require '../assets/styles/admin.php';
        require '../assets/styles/admin-options.php';
        $page="booking";
    ?>
</head>
<body>
    <!-- Requiring the admin header files -->
    <?php require '../assets/partials/_user-header.php';?>
<!-- Add, Edit and Delete Bookings -->
<?php
        /*
            1. Check if an admin is logged in
            2. Check if the request method is POST
        */
        //defaulted values
        
        

        

        $customer_name=$user_name;
        $customer_id=$user_id;
        $customer_phone=$user_phone;
        if($user_loggedIn && $_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(isset($_POST["submit"]))
            {
                /*
                    ADDING Bookings
                 Check if the $_POST key 'submit' exists
                */
                // Should be validated client-side
                // echo "<pre>";
                // var_export($_POST);
                // echo "</pre>";
                // die;
                // $customer_id = $_POST["cid"];
                
                $sql = " SELECT * FROM customers WHERE customer_id = '$customer_id';" ;
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                
                if(!$num)
                    {
                    
                            echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Booking can be made only for Customers!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                            
                    }
                else {
                // $customer_name = $_POST["cname"];
                $route_id = $_POST["route_id"];
                    
                $sql = " SELECT * FROM routes WHERE route_id = '$route_id';" ;
                    $result = mysqli_query($conn, $sql);
                    
                    $num = mysqli_num_rows($result);
                    if(!$num)
                        {
                            
                            echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Booking can be made on existing Routes!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                            
                        }
                        else {
                            $route_source = $_POST["sourceSearch"];
                            $route_destination = $_POST["destinationSearch"];
                $route = $route_source . " &rarr; " . $route_destination;
                $booked_seat = $_POST["seatInput"];
                $amount = $_POST["bookAmount"];
                // $dep_timing = $_POST["dep_timing"];

                $booking_exists = exist_booking($conn,$customer_id,$route_id);
                $booking_added = false;
            
                $sql2 = "SELECT * FROM `seats` WHERE `route_id` = '$route_id'";
                $result2 = mysqli_query($conn, $sql2);
                $row2=mysqli_fetch_assoc($result2);
                $seats_filled= explode(",",$row2['seat_booked']);
                foreach($seats_filled as $single_seat)
                {
                    if($single_seat==$booked_seat)
                    {
                        $same_seat = true;
                        break;
                    }
                }

            
                if(!$same_seat)
                {
                    
                    // Gives back the Auto Increment id
                    $autoInc_id = mysqli_insert_id($conn);
                    
                    $key = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                        $code = "";
                        for($i = 0; $i < 5; ++$i)
                        $code .= $key[rand(0,strlen($key) - 1)];
                        
                        // Generates the unique bookingid
                        $booking_id = $code.$autoInc_id;
                        
                        $sql = "INSERT INTO `bookings` (`booking_id`, `customer_id`, `route_id`, `customer_route`, `booked_amount`, `booked_seat`, `booking_created`) VALUES ('$booking_id','$customer_id', '$route_id','$route', '$amount', '$booked_seat', current_timestamp());";
                    $result = mysqli_query($conn, $sql);

                    if($result)
                        $booking_added = true;
                    else{
                        echo "Error: " . mysqli_error($conn);
                        exit();
                    }
                }
                
                if($booking_added)
                {
                    // Show success alert
                    echo '<div class="my-0 alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Successful!</strong> Booking Added
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    
                    // Update the Seats table
                   
                    $seats = get_from_table($conn, "seats", "route_id", $route_id, "seat_booked");
                    if($seats)
                    {
                        $seats .= "," . $booked_seat;
                    }
                    else
                        $seats = $booked_seat;
                        
                    $updateSeatSql = "UPDATE `seats` SET `seat_booked` = '$seats' WHERE `seats`.`route_id` = '$route_id';";
                    mysqli_query($conn, $updateSeatSql);
                }
                else{
                    // Show error alert
                    echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Booking already exists
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }
        }
    }
    if(isset($_POST["delete"]))
    {
        // DELETE BOOKING
        $id = $_POST["id"];
                $route_id = $_POST["route_id"];
                // Delete the booking with id => id
                $deleteSql = "DELETE FROM `bookings` WHERE `bookings`.`id` = $id";

                $deleteResult = mysqli_query($conn, $deleteSql);
                $rowsAffected = mysqli_affected_rows($conn);
                $messageStatus = "danger";
                $messageInfo = "";
                $messageHeading = "Error!";

                if(!$rowsAffected)
                {
                    $messageInfo = "Record Doesn't Exist";
                }

                elseif($deleteResult)
                {
                    $messageStatus = "success";
                    $messageInfo = "Booking Details deleted";
                    $messageHeading = "Successfull!";

                    // Update the Seats table
                   
                    $seats = get_from_table($conn, "seats", "route_id", $route_id, "seat_booked");

                    // Extract the seat no. that needs to be deleted
                    $booked_seat = $_POST["booked_seat"];

                    $seats = explode(",", $seats);
                    $idx = array_search($booked_seat, $seats);
                    array_splice($seats,$idx,1);
                    $seats = implode(",", $seats);

                    $updateSeatSql = "UPDATE `seats` SET `seat_booked` = '$seats' WHERE `seats`.`route_id` = '$route_id';";
                    mysqli_query($conn, $updateSeatSql);
                }
                else{

                    $messageInfo = "Your request could not be processed due to technical Issues from our part. We regret the inconvenience caused";
                }

                // Message
                echo '<div class="my-0 alert alert-'.$messageStatus.' alert-dismissible fade show" role="alert">
                <strong>'.$messageHeading.'</strong> '.$messageInfo.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
            
        }
if(isset($_GET["from"]) && isset($_GET["to"]) &&  isset($_GET["busno"]) && isset($_GET["dep_date"]) && isset($_GET["dep_time"]) && isset($_GET["cost"]))
{
    
    $from = strtoupper(trim($_GET["from"]));
    $to = strtoupper(trim($_GET["to"]));
    $bus_no = strtoupper(trim($_GET["busno"]));
    $dep_date = $_GET["dep_date"];
    $dep_time = $_GET["dep_time"];
    $cost = trim($_GET["cost"]);
    
    
    
    $sql = "SELECT * FROM routes WHERE 1=1";
    
    if(empty($from) && empty($to) && empty($bus_no) && empty($dep_date) && empty($dep_time) && empty($cost))
        {
            echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
                 No Results!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    else {
    if (!empty($from)) {
         $sql.= " AND route_from = '$from'";
    }
    if (!empty($to)) {
         $sql.= " AND route_to = '$to'";
    }
    if (!empty($bus_no)) {
        $sql .= " AND bus_no = '$bus_no'";
    }
    if (!empty($dep_date)) {
        $sql .= " AND route_dep_date = '$dep_date'";
    }
    if (!empty($dep_time)) {
        $sql .= " AND route_dep_time = '$dep_time'";
    }
    if (!empty($cost)) {
        $sql .= " AND route_step_cost = '$cost'";
    }
    
    
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    
    if($num)
        {
            ?>
            
            <p></p>
            <table class="table table-hover table-bordered">
                <thead>
                    <th>ID</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Bus</th>
                    <th>Departure Date</th>
                    <th>Departure Time</th>
                    <th>Cost</th>
                    <th>Actions</th>
                </thead>
                <?php
                    while($row = mysqli_fetch_assoc($result))
                    {
                           
                        $id = $row["id"];
                        $route_id = $row["route_id"];
                        $from = $row["route_from"];
                        $to =  $row["route_to"];
                        $route_dep_time = $row["route_dep_time"];
                        $route_dep_date = $row["route_dep_date"];
                        $route_step_cost = $row["route_step_cost"];
                        $bus_no = $row["bus_no"];
                            ?>
                        <tr>
                            <td>
                                <?php
                                    echo $route_id;
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $from;
                                ?>
                            </td>
                            <td>
                            <?php
                                echo $to;
                            ?>
                           </td>
                            <td>
                                <?php
                                    echo $bus_no;
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $route_dep_date;
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $route_dep_time;
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo 'Rs '.$route_step_cost;?>
                            </td>
                            <td>
                            <button id="add-button" class="button btn-sm"type="button"data-bs-toggle="modal" data-bs-target="#addModal">Book your ticket<i class="fas fa-plus"></i></button>

                            </td>
                        </tr>
                    <?php
                    }
                ?>
            </table>
            <a href="user_booking.php" class="btn btn-primary">Back</a>
            <p></p>
      <?php  }
    else{
        echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> No Matching Records!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}
}
        ?>
    <p></p>
    
    <?php
            $resultSql = "SELECT * FROM `bookings` WHERE `customer_id`='$customer_id'";
                            
            $resultSqlResult = mysqli_query($conn, $resultSql);

            if(!mysqli_num_rows($resultSqlResult)){ ?>
                <!-- Bookings are not present -->
                <div class="container mt-4">
                    <div id="noCustomers" class="alert alert-dark " role="alert">
                        <h1 class="alert-heading">No Bookings Found!!</h1>
                        <p class="fw-light">Be the first person to add one!</p>
                        <hr>
                        <div id="addCustomerAlert" class="alert alert-success" role="alert">
                                Click on <button id="add-button" class="button btn-sm"type="button"data-bs-toggle="modal" data-bs-target="#addModal">ADD <i class="fas fa-plus"></i></button> to add a booking!
                        </div>
                    </div>
                </div>
            <?php }
            else { ?>
                
           <form method="GET" style = " display: flex;
  flex-direction: row;
  align-items: center;
  font-size: 10px;  ">
  <label for="from" style= "margin-right: 5px; " >From</label>
  <input type="text" name="from" id="from" placeholder="From Destination" style = "
           padding: 5px;
     margin: 5px;
       border-radius: 5px;
       border: 1px solid #ccc;
       
">
  <br>
<label for="to" style= "margin-right: 5px; " >To</label>
<input type="text" name="to" id="To" placeholder="to Destination" style = "
         padding: 5px;
   margin: 5px;
     border-radius: 5px;
     border: 1px solid #ccc;
     
">
<br>
  <label for="busno" style= "margin-right: 5px;">Bus Number</label>
  <input type="text" name="busno" id="busno"  placeholder="Bus Number" style = "  margin: 5px;
    padding: 5px;
    border-radius: 5px;
    border: 2px solid #ccc;
    "
  <br>
  <label for="date" style= "margin-right: 5px;">Departure Date</label>
  <input type="date" name="dep_date" id="date" style = "  margin: 5px;
    padding: 5px;
    border-radius: 5px;
    border: 2px solid #ccc;
   " >
  <br>
 <label for="time" style= "margin-right: 5px;">Departure Time</label>
 <input type="time" name="dep_time" id="time" style = "   margin: 5px;
    padding: 5px;
    border-radius: 5px;
    border: 2px solid #ccc;
    ">
 <br>
<label for="stepCost" style= "margin-right: 5px;">Cost</label>
<input type="stepCost" name="cost" id="stepCost" placeholder="Cost" style = "   margin: 5px;
   padding: 5px;
   border-radius: 5px;
   border: 2px solid #ccc;
   ">
<br>
  <input type="submit" value="Search" style = " background-color: #4CAF50;
    color: white;
       border-radius: 5px;
    cursor: pointer; ">
</form>

<p></p>
           
                <div id="booking-results">
                    <div>
                        <button id="add-button" class="button btn-sm"type="button"data-bs-toggle="modal" data-bs-target="#addModal">Add Bookings<i class="fas fa-plus"></i></button>
                    </div>
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
                            <th>Actions</th>
                        </thead>
                        <?php
                            while($row = mysqli_fetch_assoc($resultSqlResult))
                            {
                                    // echo "<pre>";
                                    // var_export($row);
                                    // echo "</pre>";
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
                            <td>
                           
                                <button class="button delete-button btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                data-id="<?php
                                                echo $id;?>" data-bookedseat="<?php
                                                echo $booked_seat;
                                            ?>" data-routeid="<?php
                                            echo $route_id;
                                        ?>"> Cancel Booking</button>
                            </td>
                        </tr>
                        <?php
                        }
                    ?>
                    </table>
                </div>
            </section>
            <?php } ?>
        </div>
    </main>


    <!-- Requiring _getJSON.php-->
    <!-- Will have access to variables
        1. routeJson
        2. customerJson
        3. seatJson
        4. busJson
        5. adminJson
        6. bookingJSON
    -->
    <?php require '../assets/partials/_getJSON.php';?>
    
    <!-- All Modals Here -->
    <!-- Add Booking Modal -->


    
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Booking Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addBookingForm" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                            <!-- Passing Route JSON -->
                            <input type="hidden" id="routeJson" name="routeJson" value='<?php echo $routeJson; ?>'>
                            <!-- Passing Customer JSON -->
                            <input type="hidden" id="customerJson" name="customerJson" value='<?php echo $customerJson; ?>'>
                            <!-- Passing Seat JSON -->
                            <input type="hidden" id="seatJson" name="seatJson" value='<?php echo $seatJson; ?>'>

                            <div class="mb-3">
                                <label for="cid" class="form-label">Customer ID</label>
                                <!-- Search Functionality -->
                                <div class="searchQuery">
                                    <input type="text" class="form-control searchInput" id="cid" name="cid" value="<?php echo $customer_id ?>" readonly>
                                    <div class="sugg">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="cname" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="cname" name="cname" value="<?php echo $customer_name ?>"readonly>
                            </div>
                            <div class="mb-3">
                                <label for="cphone" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" id="cphone" name="cphone" value="<?php echo $customer_phone ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="routeSearch" class="form-label">Route</label>
                                <!-- Search Functionality -->
                                <div class="searchQuery">
                                    <input type="text" class="form-control searchInput" id="routeSearch" name="routeSearch">
                                    <div class="sugg">
                                    </div>
                                </div>
                            </div>
                            <!-- Send the route_id -->
                            <input type="hidden" name="route_id" id="route_id">
                            <!-- Send the departure timing too -->
                            <input type="hidden" name="dep_timing" id="dep_timing">

                            <div class="mb-3">
                                <label for="sourceSearch" class="form-label">Source</label>
                                <!-- Search Functionality -->
                                <div class="searchQuery">
                                    <input type="text" class="form-control searchInput" id="sourceSearch" name="sourceSearch">
                                    <div class="sugg">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="destinationSearch" class="form-label">Destination</label>
                                <!-- Search Functionality -->
                                <div class="searchQuery">
                                    <input type="text" class="form-control searchInput" id="destinationSearch" name="destinationSearch">
                                    <div class="sugg">
                                    </div>
                                </div>
                            </div>
                            <!-- Seats Diagram -->
                            <div class="mb-3">
                                <table id="seatsDiagram">
                                <tr>
                                    <td id="seat-1" data-name="1">1</td>
                                    <td id="seat-2" data-name="2">2</td>
                                    <td id="seat-3" data-name="3">3</td>
                                    <td id="seat-4" data-name="4">4</td>
                                    <td id="seat-5" data-name="5">5</td>
                                    <td id="seat-6" data-name="6">6</td>
                                    <td id="seat-7" data-name="7">7</td>
                                    <td id="seat-8" data-name="8">8</td>
                                    <td id="seat-9" data-name="9">9</td>
                                    <td id="seat-10" data-name="10">10</td>
                                </tr>
                                <tr>
                                    <td id="seat-11" data-name="11">11</td>
                                    <td id="seat-12" data-name="12">12</td>
                                    <td id="seat-131" data-name="13">13</td>
                                    <td id="seat-14" data-name="14">14</td>
                                    <td id="seat-15" data-name="15">15</td>
                                    <td id="seat-16" data-name="16">16</td>
                                    <td id="seat-17" data-name="17">17</td>
                                    <td id="seat-18" data-name="18">18</td>
                                    <td id="seat-19" data-name="19">19</td>
                                    <td id="seat-20" data-name="20">20</td>
                                </tr>
                                <tr>
                                        <td class="space">&nbsp;</td>
                                        <td class="space">&nbsp;</td>
                                        <td class="space">&nbsp;</td>
                                        <td class="space">&nbsp;</td>
                                        <td class="space">&nbsp;</td>
                                        <td class="space">&nbsp;</td>
                                        <td class="space">&nbsp;</td>
                                        <td class="space">&nbsp;</td>
                                        <td class="space">&nbsp;</td>
                                        <td class="space">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td id="seat-21" data-name="21">21</td>
                                    <td id="seat-22" data-name="22">22</td>
                                    <td id="seat-23" data-name="23">23</td>
                                    <td id="seat-24" data-name="24">24</td>
                                    <td id="seat-25" data-name="25">25</td>
                                    <td id="seat-26" data-name="26">26</td>
                                    <td id="seat-27" data-name="27">27</td>
                                    <td class="space">&nbsp;</td>
                                    <td id="seat-28" data-name="28">28</td>
                                    <td id="seat-29" data-name="29">29</td>
                                </tr>
                                <tr>
                                    <td id="seat-30" data-name="30">30</td>
                                    <td id="seat-31" data-name="31">31</td>
                                    <td id="seat-32" data-name="32">32</td>
                                    <td id="seat-33" data-name="33">33</td>
                                    <td id="seat-34" data-name="34">34</td>
                                    <td id="seat-35" data-name="35">35</td>
                                    <td id="seat-36" data-name="36">36</td>
                                    <td class="space">&nbsp;</td>
                                    <td id="seat-37" data-name="37">37</td>
                                    <td id="seat-38" data-name="38">38</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="row g-3 align-items-center mb-3">
                                <div class="col-auto">
                                    <label for="seatInput" class="col-form-label">Seat Number</label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" id="seatInput" class="form-control" name="seatInput" readonly>
                                </div>
                                <div class="col-auto">
                                    <span id="seatInfo" class="form-text">
                                    Select from the above figure, Maximum 1 seat.
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="bookAmount" class="form-label">Total Amount</label>
                                <input type="text" class="form-control" id="bookAmount" name="bookAmount" readonly>
                            </div>
                            <button type="submit" class="btn btn-success" name="submit">Proceed to Pay</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!-- Add Anything -->
                    </div>
                    </div>
                </div>
        </div>
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2 class="text-center pb-4">
                    Are you sure?
                </h2>
                <p>
                    Do you really want to delete this booking? <strong>This process cannot be undone.</strong>
                </p>
                <!-- Needed to pass id -->
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="delete-form"  method="POST">
                    <input id="delete-id" type="hidden" name="id">
                    <input id="delete-booked-seat" type="hidden" name="booked_seat">
                    <input id="delete-route-id" type="hidden" name="route_id">
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="delete-form" name="delete" class="btn btn-danger">Delete</button>
            </div>
            </div>
        </div>
    </div>
    <script src="../assets/scripts/user_booking.js"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
