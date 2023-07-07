<?php
    require '_functions.php';
    $conn = db_connect();    

    if(!$conn) 
        die("Connection Failed");


if(isset($_GET["pnr"])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="booking_details.csv"');
    $pnr = $_GET["pnr"];

    $sql = "SELECT * FROM bookings WHERE booking_id='$pnr'";
    $result = mysqli_query($conn, $sql);

    if($result) {
        $row = mysqli_fetch_assoc($result);
        $route_id = $row["route_id"];
        $customer_id = $row["customer_id"];
        
        $customer_name = get_from_table($conn, "customers", "customer_id", $customer_id, "customer_name");
        $customer_phone = get_from_table($conn, "customers", "customer_id", $customer_id, "customer_phone");
        $customer_route = $row["customer_route"];
        $booked_amount = $row["booked_amount"];
        $booked_seat = $row["booked_seat"];
        $booked_timing = $row["booking_created"];
        $dep_date = get_from_table($conn, "routes", "route_id", $route_id, "route_dep_date");
        $dep_time = get_from_table($conn, "routes", "route_id", $route_id, "route_dep_time");
        $bus_no = get_from_table($conn, "routes", "route_id", $route_id, "bus_no");

        $data = array(
            array("PNR", "Customer Name", "Customer Phone", "Route", "Bus Number", "Booked Seat Number", "Departure Date", "Departure Time", "Booked Timing"),
            array($pnr, $customer_name, $customer_phone, str_replace('&rarr;', '→', $customer_route), $bus_no, $booked_seat, $dep_date, $dep_time, $booked_timing)
        );

        $fp = fopen('php://output', 'w');
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
        exit;
    }
}
?>
