<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <script type="text/javascript">
        function showUser(str) {
            if (str == "") {
                document.getElementById("name").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("name").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","checkpeyment.php?q="+str,true);
                xmlhttp.send();
            }
        }
    </script>

</head>

<body>
<table>
    <form method="post" action="<?php echo $_SERVER['php_self']?>">
        <tr>
            <td><label>ID خود را وارد کنید :</label></td>
            <td><input type="text" name="ID" onchange="showUser(this.value)"></td>
        </tr>
        <tr>
            <td><label>نام سرمایه گذار</label></td>
            <td><label id="name"></label></td>
        </tr>
        <tr>
            <td><label>مبلغ :</label></td>
            <td><input type="text" name="cash"> </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="تایید"></td>
        </tr>

    </form>
</table>

</body>
</html>

<?php
$conn = oci_connect("system", "data1111224", "192.168.137.15:1521/GENERAL");
if (!$conn) {
    echo "connection failed";
}
$id=$_GET['q'];
$sql="select T1_2,T1_3 from T1 WHERE T1_1='$id'";
$result=oci_parse($conn,$sql);
oci_execute($result);
if(oci_fetch_assoc($result)>0){
    $row=oci_fetch_assoc($result);
    echo $row['T1_2'],$row['T1_3'];
}


if(isset($_POST['submit'])) {

    $ID=$_POST['ID'];
    $cash=$_POST['cash'];
    $execute=oci_parse($conn,"insert into T4 (T4_1,T4_4) VALUES ('$ID',DATE )");
    oci_execute($execute);

    $execute=oci_parse($conn,"select T4_3 from T4 WHERE T4_1='$ID'");
    oci_execute($execute);
    $rows=oci_fetch_assoc($execute);
    $contractID=$rows['T4_3'];


    $execute=oci_parse($conn,"insert into T29 (T29_1,T29_2,T29_3) VALUES ('$contractID','1','کد رهگیری')");
    oci_execute($execute);

    $execute=oci_parse($conn,"insert into T14 (T14_1, T14_2,T14_5) VALUES ('کد رهگیری','$cash',DATe )");
    oci_execute($execute);
    oci_close($conn);
}
?>
