<!DOCTYPE html>
    <html>
<meta charset="UTF-8">
<body>
<form method="post" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
    سرمایه گذار ID:<input type="text" name="ID"><br>
    اسم سرمایه گذار:<br>
    مبلغ:<input type="text" name="cash"><br>
    <input type="submit" name="submit" value="تایید">
</form>
<?php
if(isset($_POST['submit'])) {
    $conn = oci_connect("system", "data1111224", "192.168.137.15:1521/GENERAL");
    if (!$conn) {
        echo "connection failed";
    }
    $ID=$_POST['ID'];
    $cash=$_POST['cash'];
    $execute=oci_parse($conn,"UPDATE T4 SET T4_5='$cash' WHERE T4_1='$ID'");
    oci_execute($execute);
    oci_close($conn);
}
?>
</body>
    </html>