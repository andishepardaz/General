<!DOCTYPE html>
    <html>
<meta charset="UTF-8">
<body>
<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <table style="width: 20%">
        <tr>
            <td>ورود ID:</td>
            <td><input type="text" name="ID"> </td>
        </tr>
        <tr>
            <td>نام:</td>
            <td></td>
        </tr>
        <tr>
            <td>نوع فاکتور:</td>
            <td><input type="radio" name="invoice">خرید</td>
            <td><input type="radio" name="invoice" >فروش</td>
        </tr>
        <tr>
            <td>نوع پرداخت:</td>
            <td><input type="radio" name="paymenttype">نقدی</td>
            <td><input type="radio" name="paymenttype">غیرنقدی </td>
        </tr>
        <tr>
            <td>مبلغ:</td>
            <td><input type="text" name="مبلغ" </td>
        </tr>
    </table>
    <input type="submit" name="submit" value="تایید">
</form>
<?php
if(isset($_POST['submit'])){
    $conn=oci_connect("system", "data1111224", "192.168.137.15:1521/GENERAL");
    if(!$conn){
        echo "connection failed";
    }
else{
    $ID=$_POST['ID'];
        if(isset($_POST['invoice'])=="خرید"){
        $sql="SELECT T20_1 FROM T20 WHERE T20_2='buy'";
        $execute=oci_parse($conn,$sql);
        oci_execute($execute);
        $row=oci_fetch_assoc($execute);
        $x=$row['T20_1'];
            var_dump($x);
        $script="INSERT INTO T21 (T21_1, T21_3, T21_4, T21_5)VALUES ($ID,$x,'2014','3')";
        $ex=oci_parse($conn,$script);
        oci_execute($ex);
        $paymenttype=$_POST['مبلغ'];
        $sqli="INSERT INTO T14(T14_2,T14_4)VALUES ('$paymenttype','68')";
           $v =oci_parse($conn,$sqli);
            oci_execute($v);
    }else{
        $sql="SELECT T20_1 FROM T20 WHERE T20_2 IS 'sell'";
        $exe=oci_parse($conn,$sql);
        oci_execute($exe);
        $rows=oci_fetch_assoc($exe);
        $X=$rows;
        $oci="INSERT INTO T21(T21_1,T21_3,T21_4)VALUES ('$ID','$X','date')";
        $ex=oci_parse($conn,$oci);
        oci_execute($ex);
        $paymenttype=$_POST['مبلغ'];
        $sqli="INSERT INTO T14(T14_2,T14_4)VALUES ('$paymenttype','date')";
            $v=oci_parse($conn,$sqli);
            oci_execute($v);
    }

    oci_close($conn);
}
}

?>
</body>
</html>
