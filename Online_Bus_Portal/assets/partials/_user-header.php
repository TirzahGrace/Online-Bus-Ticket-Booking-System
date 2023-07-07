<?php
    session_start();
    require_once '_user_handleLogin.php';
    require_once '_functions.php';
    $conn = db_connect();
    // Getting user details
    $user_id = $_SESSION['user_id'];    
    $sql = "SELECT * FROM customers WHERE customer_id = '$user_id';";
    $result = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($result))
    {
        $user_name = $row['customer_name'];
    }
?>

<!-- <header>
        <nav id="navbar">
            <ul>
                <li class="nav-item">
                    <?php 
                        echo $user_name;
                    ?>
                </li>
                <li class="nav-item">
                    <img class="adminDp" src="../assets/img/admin_pic.jpg" alt="Admin Profile Pic" width="22px" height="22px">
                </li>
            </ul>
        </nav>
    </header> -->
    <main id="container">
        <div id="sidebar">
            <h4><i class="fas fa-bus"></i> OBTBS</h4>
            <div>
                <img class="adminDp" src="../assets/img/userav-min.png" height="125px" alt="Admin Profile Pic">
                <p>
                    <?php  echo '@'.$user_name;  ?>
                </p>
                <p>Username</p>
            </div>
            <ul id="options">
                <li class="option <?php if($page=='dashboard'){ echo 'active';}?>"> 
                    <a href="./user_dashboard.php">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                
               
                <li class="option <?php if($page=='bus'){ echo 'active';}?>">
                    <a href="./user_bus.php">
                    <i class="fas fa-bus"></i> Buses
                    </a>
                </li>
                <li class="option <?php if($page=='route'){ echo 'active';}?>">
                    <a href="./user_route.php">
                    <i class="fas fa-road"></i> Routes    
                    </a>
                </li>
                
              
                <li class="option <?php if($page=='booking'){ echo 'active';}?>">
                    <a href="./user_booking.php">
                    <i class="fas fa-ticket-alt"></i> Bookings
                    </a>
                </li>
                
            </ul>
        </div>
        <div id="main-content">
            <section id="welcome">
                <ul>
                    <li class="welcome-item">Welcome to userpage, 
                        <span id="USER">
                            <?php 
                                echo $user_name;
                            ?>
                        </span>
                    </li>
                    <li class="welcome-item">
                        <button id="logout" class="btn-sm">
                            <a href="../assets/partials/_logout.php">LOGOUT</a>
                        </button>
                    </li>
                </ul>
            </section>