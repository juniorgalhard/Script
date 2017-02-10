#!/usr/bin/php

<?php

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db = "#";
$router_ip="#";
$router_port="#";
$router_secret="#";
$debug="FALSE";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT UserName FROM mikrotik_erp.radcheck WHERE value = 'Reject'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
       
       $login=$row['UserName'];

       echo "LOGIN : " . $login . "\n";

       $cmd="echo user-name=$login | radclient -x $router_ip:$router_port disconnect $router_secret";

       $disconnect=shell_exec($cmd);

       if ( $debug == "TRUE"){

      			echo $cmd."\n";
       			echo $disconnect."\n";

       		}

        }

} else {

    echo "not found username.\n";
}

$conn->close();

?>