
<html>
<head>

</head>
<body dir="rtl">

</body>
</html>
<?php
$conn = oci_connect("system", "data1111224", "192.168.137.15:1521/GENERAL");
if (!$conn) {
    echo "connection failed";
}
$sql="select * from T14 ";
$result=oci_parse($conn,$sql);
oci_execute($result);


echo "<table>
<tr>
<th>رهگیری</th>
<th>واریز</th>
<th>برداشت</th>
<th>انده نقدی<</th>
<th>ارزش غیر نقدی</th>
<th>جمع کل</th>
</tr>";

$rows = oci_fetch_assoc($result);
while($rows){
    if ($rows['T14_2']!=null){
        $sum1=$sum1+(int)$rows['T14_2'];
    }
    if ($rows['T14_3']!=null){
        $sum2=$sum2+(int)$rows['T14_3'];
    }
}


$sub=$sum1-$sum2;
while($rows) {
    echo "<tr>";
    echo "<td>" . $rows['T14_1'] . "</td>";
    echo "<td>" . $rows['T14_2'] . "</td>";
    echo "<td>" . $rows['T14_3'] . "</td>";
    echo "<td>" . $sub . "</td>";
  //  echo "<td>" . $row['T14_1'] . "</td>";
   // echo "<td>" . $row['T14_1'] . "</td>";
    echo "</tr>";
}
echo "</table>";

?>