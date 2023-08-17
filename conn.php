<?php

$db_host = "localhost";  // database host
$db_user = "root";   // database username
$db_pass = '';   // database password
$db_name = "products_collection"; // Your database name


$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name,"3307");


if ($conn) 
{
} else 
{
    echo '<div>
        Error - found databse not connected
       </div>';
    exit();
}


?>