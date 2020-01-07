<?php
require_once 'includes/config.php';

// Connect to mysql server
$link = mysqli_connect(
    $config['db_host'],
    $config['db_user'],
    $config['db_pass'],
    $config['db_name']
);

if (mysqli_connect_errno()) {
    exit(mysqli_connect_error());
}

header('Content-type: application/json');
$getRow = array();
$i = 0;

$Query = "SELECT * FROM images;";
$result = $link->query($Query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $getRow[$i] = array($row);
        $i++;
    }
    echo json_encode($getRow);
} else {
    echo "No results";
}
$link->close();
?>