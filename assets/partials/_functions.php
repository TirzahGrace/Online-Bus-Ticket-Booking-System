<?php


function db_connect()
{
    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = 'root';
    $db_db = 'OBTBS';
    
    
    $conn = mysqli_connect($db_host, $db_user, $db_password,  $db_db );
    return $conn;
}

function same_booking($conn,$route_id,$booked_seat)
{
    $sql= "SELECT * FROM `seats` WHERE route_id='$route_id'";
    $result=mysqli($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $arr=explode(",",$row["seat_booked"]);
    echo 'words';
    foreach($arr as $seat)
    {
        if($seat==$booked_seat)
        {
            return true;
        }
    }
}


    function exist_user($conn, $username)
    {
        $sql = "SELECT * FROM `users` WHERE user_name='$username'";
        
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if($num)
            return true;
        return false;
    }
function exist_admin($conn, $username)
{
    $sql = "SELECT * FROM `users` WHERE BINARY user_name='$username'";
    
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if($num)
        return true;
    return false;
}

    function exist_admin_routes($conn, $from, $to, $depdate, $deptime, $busno)
    {
        $sql = "SELECT * FROM `routes` WHERE `route_from` ='$from' AND `route_to` ='$to' AND `bus_no` ='$busno' AND route_dep_date='$depdate' AND route_dep_time='$deptime'";

        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        
        if($num)
        {
            $row = mysqli_fetch_assoc($result);
            
            return $row["id"];
        }
        return false;
    }

function exist_routes($conn, $route_cities, $depdate, $deptime, $busno)
{
    $sql = "SELECT * FROM `routes` WHERE `route_cities` ='$route_cities'  AND `bus_no` ='$busno' AND route_dep_date='$depdate' AND route_dep_time='$deptime'";

    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    
    if($num)
    {
        $row = mysqli_fetch_assoc($result);
        
        return $row["id"];
    }
    return false;
}

    function exist_customers($conn, $name, $phone)
    {
        $sql = "SELECT * FROM `customers` WHERE customer_name='$name' AND customer_phone='$phone'";

        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if($num)
        {
            $row = mysqli_fetch_assoc($result);   
            return $row["customer_id"];
        }
        return false;
    }

    function exist_buses($conn, $busno)
    {
        $sql = "SELECT * FROM `buses` WHERE bus_no='$busno'";

        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if($num)
        {
            $row = mysqli_fetch_assoc($result);   
            return $row["id"];
        }
        return false;
    }

    function exist_booking($conn, $customer_id, $route_id)
    {
        $sql = "SELECT * FROM `bookings` WHERE customer_id='$customer_id' AND route_id='$route_id'";

        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if($num)
        {
            $row = mysqli_fetch_assoc($result);   
            return $row["id"];
        }
        return false;
    }

    function bus_assign($conn, $busno)
    {
        $sql = "UPDATE buses SET bus_assigned=1 WHERE bus_no='$busno'";
        $result = mysqli_query($conn, $sql);
    }

    function bus_free($conn, $busno)
    {
        $sql = "UPDATE buses SET bus_assigned=0 WHERE bus_no='$busno'";
        $result = mysqli_query($conn, $sql);
    }

    function busno_from_routeid($conn, $id)
    {
        $sql = "SELECT * from routes WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if($row)
        {
            return $row["bus_no"];
        }
        return false;
    }


    function get_from_table($conn, $table, $primaryKey, $pKeyValue, $toget)
    {
        $sql = "SELECT * FROM $table WHERE $primaryKey='$pKeyValue'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if($row)
        {
            return $row["$toget"];
        }
        return false;
    }
?>
