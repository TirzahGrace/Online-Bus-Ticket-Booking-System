
<!-- Show these admin pages only when the admin is logged in -->
<?php  require '../assets/partials/_admin-check.php';   ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins</title>
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
        $page="admin";
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
input[type="username"],
input[type="submit"] {
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 10px;
    margin-left: 20px;
   
}

input[type="submit"]:hover {
  background-color: #3e8e41;
}
</style>
</head>
<body>
    <!-- Requiring the admin header files -->
    <?php require '../assets/partials/_admin-header.php';?>

<?php

if($loggedIn && $_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["submit"]))
    {
        /*
            ADDING Customers
         Check if the $_POST key 'submit' exists
        */
        // Should be validated client-side
        
        
        
        $full_name = $_POST["fullname"];
        
        if (!preg_match("/^[a-zA-Z]+$/", $full_name)) {
            echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>Full Name should only consists of Alphabets!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
        else{
        
        $user_name = trim($_POST["username"]);
        
            if (!ctype_alnum($user_name)) {
                echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>User Name should only consists of AlphaNumericals!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
            else {
            
        $user_password = $_POST["userpassword"];
           
        if($full_name == "" || $user_name == "")
            {
                echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>User Name and Full Name should not be empty!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
        
        else {
        $admin_exists = exist_admin($conn,$user_name);
        $admin_added = false;

        if(!$admin_exists) {
           
            $hash = password_hash($user_password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_fullname`, `user_name`, `user_password`, `user_created`) VALUES ('$full_name', '$user_name', '$hash', current_timestamp());";
            $result = mysqli_query($conn, $sql);

            if(!$result) {
                // Handle errors
                echo "Error: " . mysqli_error($conn);
            }
            else {  $user_added = true;
                // Show success alert
                echo '<div class="my-0 alert alert-success alert-dismissible fade show" role="alert">
                <strong>Successful!</strong> User Added
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
            }
           
        else{
            // Show error alert
            echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> User already exists ( Username should be different! )
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }  }  } }
    }
    
    if(isset($_POST["delete"]))
    {
        
        $id = $_POST["id"];
        // echo $id ;
        
        $deleteSql = "DELETE FROM `users` WHERE user_id = $id";

        $deleteResult = mysqli_query($conn, $deleteSql);
        $rowsAffected = mysqli_affected_rows($conn);
        $messageStatus = "danger";
        $messageInfo = "";
        $messageHeading = "Error!";

        if(!$rowsAffected)
        {
            $messageInfo = "Record Doesnt Exist";
        }

        elseif($deleteResult)
        {
            $messageStatus = "success";
            $messageInfo = "Admin Details deleted";
            $messageHeading = "Successfull!";
        }
        else
        {

            $messageInfo = "Your request could not be processed due to technical Issues from our part. We regret the inconvenience caused";
        }

        // Message
        echo '<div class="my-0 alert alert-'.$messageStatus.' alert-dismissible fade show" role="alert">
        <strong>'.$messageHeading.'</strong> '.$messageInfo.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

   
}

if( $loggedIn && $_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["username"]))
{


$username = $_GET["username"];

    $username = trim($username) ;
if($username == "")
{
        echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>User Name should not be empty!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}
else
    {
        $sql = "SELECT * FROM users WHERE BINARY user_name = '$username'";


$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
$total_sales = 0 ;
if($num)
    {
        ?>
        
        
        <p></p>
        <table class="table table-hover table-bordered">
            <thead>
                <th>ID</th>
                <th>Full Name</th>
                <th>User_Name</th>
                <th>User_Password</th>
            </thead>
            <?php
                while($row = mysqli_fetch_assoc($result))
                {
                        // echo "<pre>";
                        // var_export($row);
                        // echo "</pre>";
                    $id = $row["user_id"];
                    $full_name = $row["user_fullname"];
                    $user_name = $row["user_name"];
                    $user_password = $row["user_password"];
            ?>
            <tr>
                <td>
                    <?php
                        echo $id;
                    ?>
                </td>
                <td>
                    <?php
                        echo $full_name;
                    ?>
                </td>
                <td>
                    <?php
                        echo $user_name;
                    ?>
                </td>
                    <td>
                        <?php
                            echo $user_password;
                        ?>
                    </td>
            </tr>
        <?php
            }
        ?>
        </table>
        <p> </p>
        <a href="admin.php" class="btn btn-primary">Back</a>
        <p> </p>
  <?php  }
else{
    echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> No Matching Records!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
}
}

$resultSql = "SELECT * FROM `users` ORDER BY user_id DESC";
                
$resultSqlResult = mysqli_query($conn, $resultSql);

if(!mysqli_num_rows($resultSqlResult)){ ?>
    <!-- Admins are not present -->
    <div class="container mt-4">
        <div id="noAdmins" class="alert alert-dark " role="alert">
            <h1 class="alert-heading">No Admins Found!!</h1>
            <p class="fw-light">Be the first person to add one!</p>
            <hr>
            <div id="addAdminAlert" class="alert alert-success" role="alert">
                    Click on <button id="add-button" class="button btn-sm"type="button"data-bs-toggle="modal" data-bs-target="#addModal">ADD <i class="fas fa-plus"></i></button> to add a customer!
            </div>
        </div>
    </div>
<?php }
else { ?>
<!-- If Admins are present -->
    
   
          
<section id="admin">
    <div id="head">
        <h4>Admin Status</h4>
    </div>
    <div id="admin-results">
    <form method="GET" >
      <label for="username">User_Name: </label>
      <input type="text" name="username" id="username"  placeholder="Enter Name" required>
      <br>
      <input type="submit" value="Search">
    </form>
          <p></p>
        <div>
            <button id="add-button" class="button btn-sm"type="button"data-bs-toggle="modal" data-bs-target="#addModal">Add Admin Details <i class="fas fa-plus"></i></button>
        </div>
          <p></p>
        <table class="table table-hover table-bordered">
            <thead>
                <th>ID</th>
                <th>Full_Name</th>
                <th>User_Name</th>
                <th>User_Password</th>
            </thead>
            <?php
                while($row = mysqli_fetch_assoc($resultSqlResult))
                {
                       
                    $id = $row["user_id"];
                    $full_name = $row["user_fullname"];
                    $user_name = $row["user_name"];
                    $user_password = $row["user_password"];
            ?>
            <tr>
                <td>
                    <?php
                        echo $id;
                    ?>
                </td>
                <td>
                    <?php
                        echo $full_name;
                    ?>
                </td>
                <td>
                    <?php
                        echo $user_name;
                    ?>
                </td>
                    <td>
                        <?php
                            echo $user_password;
                        ?>
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

<!-- All Modals Here -->
<!-- Add Admin Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAdminForm" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                        <div class="mb-3">
                            <label for="fullname" class="label">Full Name</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                        </div>
<br>
                        <div class="mb-3">
                            <label for="username" class="label">User Name </label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
<br>
                        <div class="mb-3">
                            <label for="userpassword" class="label">Password</label>
                            <input type="text" class="form-control" id="userpassword" name="userpassword" required>
                        </div>
                        <button type="submit" class="btn btn-success" name="submit">Submit</button>
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
                <strong>This process cannot be undone.</strong>
            </p>
            <!-- Needed to pass id -->
            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="delete-form"  method="POST">
                <input id="delete-id" type="hidden" name="id">
            </form>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" form="delete-form" name="delete" class="btn btn-danger">Delete</button>
        </div>
        </div>
    </div>
</div>

<script src="../assets/scripts/admin_admin.js"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>
