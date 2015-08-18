<?php
// Create connection
session_start();
if(isset($_SESSION['myusername'])){
	$id=$_SESSION['myusername'];
	$idmd5=md5($id);
$con=oci_connect("system","data1111224","192.168.137.1:1521/GENERAL");
$query=oci_parse($con,"SELECT T1_1,T1_2,T1_3,T1_10 FROM T1 WHERE T1_1='$idmd5'");
oci_execute($query);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
		echo "please check your connection later!";
}
$result = $con->query($query);
if ($result->oci_num_rows() > 0) {
    // output data of each row
    while($row = $result->oci_fetch_assoc()) {
        echo "id: " . $row["T1_1"]. "  Name: " . $row["T1_2"]. "Last name: " .$row["T1_3"]."father name: ". $row["T1_10"]. "<br>";
    }
} else {
    echo "0 results";
}
$con->close();
}
?> 
