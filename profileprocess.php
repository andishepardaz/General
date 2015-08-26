<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<?php
// Create connection
session_start();
if(isset($_SESSION['myusername'])){
	$id=$_SESSION['myusername'];
	$idmd5=base64_encode($id);
$conn = oci_connect("system","data1111224","192.168.137.15:1521/GENERAL")or die("problem with connection try it later");
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
$stid = oci_parse($conn, "SELECT T1_1,T5_3 FROM T1 INNER JOIN T5 ON T1.T1_1=T5.T5_1 WHERE T1_1='$idmd5'");
oci_execute($stid);

while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
  echo "id: " . base64_decode($row["T1_1"]). "  Name: " .base64_decode( $row["T1_2"]). "Last name: " .base64_decode($row["T1_3"])."Email:". base64_decode($row["T5_3"]). "<br>";
}
oci_free_statement($stid);
oci_close($conn);
}
?> 
<body>
</html>