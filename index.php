<?php
    require 'assets/partials/_functions.php';
    $conn = db_connect();    

    if(!$conn) 
        die("Connection Failed");
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
 
  require "./vendor/autoload.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket Bookings</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <!-- Font-awesome -->
    <script src="https://kit.fontawesome.com/d8cfbe84b9.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- CSS -->
    <?php 
        require 'assets/styles/styles.php'
    ?>
</head>
<body>
    <?php

// Bus-Search from and to Reply

if( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bus-search"]))
{
// retrieve the user's search inputs
$from = $_POST["from"];
$to = $_POST["to"];

$sql =  "SELECT * FROM  `routes` WHERE  `route_from` = '$from' AND `route_to` = '$to' ";

   
$result = mysqli_query($conn, $sql);

    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    
$num = mysqli_num_rows($result);

$from_to = $from . "→" . $to;
    $from_to = strtoupper($from_to) ;
if ($num) {
    
    ?>
    <div class="alert alert-dark alert-dismissible fade show" role="alert">
    
    <h4 class="alert-heading">Available Buses: <?php echo $from_to ;?> </h4>
    <hr>
    <?php
   
    echo "<table>";
    echo "<tr><th>Bus Number&nbsp;&nbsp;&nbsp;</th>"."  "."<th>Departure Date&nbsp;&nbsp;&nbsp;</th><th>Departure Time&nbsp;&nbsp;&nbsp;</th><th>Fare&nbsp;</th></tr>";
    
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["bus_no"] . "</td><td>" . $row["route_dep_date"] . "</td><td>" . $row["route_dep_time"] . "</td><td>" . $row["route_step_cost"] . "</td></tr>";
    }
    echo "</table>";
    ?>
    <hr>
    <p>
        <button class="btn btn-sm btn-success"><a href="assets/partials/_downloadbuses.php?bus-search=<?php echo $from_to; ?>&amp;from=<?php echo $from; ?>&amp;to=<?php echo $to; ?>" class="link-light">Download</a></button>
    </p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
}
else {
    echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
        No Available Buses!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["feedback-submit"])) {
    
    $email = $_POST["email"];
    $message = $_POST["message"];
    
    $mail = new PHPMailer(true);
     
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'obtbs.care@gmail.com';
        $mail->Password   = 'siuashvbcadisduo';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->addBCC('obtbs.care@gmail.com');

       
        $mail->Subject = 'Online Bus Ticket Portal Feedback' ;
        $mail->Body    = nl2br($message)."\n";
        $mail->Body    = $mail->Body . "<br>". " From : ". $email ;
        $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail->send();
        
        $mail_to = new PHPMailer(true);
        
        $mail_to->isSMTP();
        $mail_to->Host       = 'smtp.gmail.com';
        $mail_to->SMTPAuth   = true;
        $mail_to->Username   = 'obtbs.care@gmail.com';
        $mail_to->Password   = 'siuashvbcadisduo';
        $mail_to->SMTPSecure = 'tls';
        $mail_to->Port       = 587;

        $mail_to->addBCC($email) ;
        $mail_to->Subject = 'Online Bus Ticket Portal Feedback';
        $mail_to->Body    = "Feedback received. " ."<br>" ."Thank you for Contacting us!" ;
        $mail_to->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail_to->send();
        echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
        Feedback is submited successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    } catch (Exception $e) {
        echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
         Message could not be sent.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    
}
?>
    
    <header>
        <nav>
            <div>
                    <a href="./index.php" class="nav-item nav-logo">OBTBS</a>
            </div>
                
            <ul>
                <li><a href="./index.php" class="nav-item">Home</a></li>
                <li><a href="#about" class="nav-item">About</a></li>
                <li><a href="#contact" class="nav-item">Contact</a></li>
            </ul>
            <div>
                <a href="#" class="login nav-item" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt" style="margin-right: 0.4rem;"></i>Login</a>
                <a href="#" class="login nav-item" data-bs-toggle="modal" data-bs-target="#signupModal"><i class="fas fa-sign-in-alt" style="margin-right: 0.4rem;"></i>User signup</a>

            </div>
        </nav>
    </header>
    <!-- Login Modal -->
    <?php require 'assets/partials/_loginModal.php'; 
        require 'assets/partials/_getJSON.php';
        require 'assets/partials/_user_loginModal.php';
        require 'admin/user_signup.php';

        $routeData = json_decode($routeJson);
        $busData = json_decode($busJson);
        $customerData = json_decode($customerJson);
    ?>
     

    <section id="home">
        <div id="route-search-form">
            <h1>Online Bus Ticket Booking System</h1>

         <!--  <p class="text-center">Welcome to Online Bus Ticket Booking System. Login now to manage bus tickets and much more.</p>
          
-->

<center>
<div id="search-box">
<form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST">
  <div>
    <label for="from">From:</label>
    <input type="text" name="from" id="from" placeholder="Enter from destination" required>
   <label for="to">To:</label>
   <input type="text" name="to" id="to" placeholder="Enter to destination" required>
   <button type="submit" name="bus-search">Search</button>
  </div>
</form>
</div>
    </center>

              <br>

            <center>
                <button class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#loginModal">Administrator Login</button>
                
            </center>
            <br>
<center>
   <button class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#user_loginModal">User Login</button>
   
</center>
<br>
            
        </div>
    </section>
        <section id="about">
            <div>
                <h1>About Us</h1>
                <h4>IIT Kharagpur</h4>
                <p>
Welcome to our online bus booking portal, where you can easily book bus tickets from the comfort of your own home. Our team of three members has worked tirelessly to create an intuitive and user-friendly website that makes booking bus tickets a breeze.
</p>
<p>
Whether you are traveling for business or pleasure, our website has all the tools you need to plan your trip. You can easily search for available buses between your desired destinations, compare prices, and select the seat of your choice.
</p>
<p>
Thank you for choosing our online bus booking portal for your travel needs. We look forward to serving you and making your travel experience as hassle-free as possible.
                </p>
            </div>
        </section>
<section id="contact">
    <div id="contact-form" style="color: black">
        <h1 style="font-family: Helvetica ,sans-serif; color: red ; ">Contact Us</h1>
           <form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="POST">
            <div>
                <label for="email">Email</label>
                <input type="text" name="email" id="email">
            </div>
            <div>
                <label for="message">Feedback</label>
                <textarea name="message" id="message" cols="30" rows="10"></textarea>
            </div>
            <div>
                <button type="submit" name="feedback-submit">Submit</button>
            </div>
        </form>
    </div>
</section>
<?php
// Display a success message
   if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback-submit']))
        { echo "<p>Thank you for contacting us!</p>"; }
?>
        <footer>
        <p>
                        <i class="far fa-copyright"></i> <?php echo date('Y');?> - Online Bus Ticket Booking System | Made with &#10084;&#65039; by Ritesah, Tapaswini, Tirzah
                        </p>
        </footer>
    </div>
    
     <!-- Option 1: Bootstrap Bundle with Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <!-- External JS -->
    <script src="assets/scripts/main.js"></script>
</body>
</html>
