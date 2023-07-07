<?php
require_once '_functions.php';
$conn = db_connect();

if (isset($_GET['bus-search']) && isset($_GET['from']) && isset($_GET['to'])) {
    
    $from = strtoupper($_GET["from"]);
    $to = strtoupper($_GET["to"]);

    $from_to = $from . "," . $to;

    // prepare file name
    $file_name = str_replace(',', '_', $from_to) . '.csv';

    // prepare headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $file_name . '"');

    // prepare CSV data
    $data = array(
        array('Bus Number', 'Departure Date', 'Departure Time', 'Fare'),
    );
    $sql = "SELECT * FROM routes WHERE route_from = '$from' AND route_to = '$to'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
        exit();
    }
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array($row["bus_no"],$row["route_dep_date"],$row["route_dep_time"],$row["route_step_cost"]);
    }


    // output CSV data
    $output = fopen('php://output', 'w');
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}
?>
