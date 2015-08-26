<html>
<head>
<meta charset="UTF-8">
</head>
<body>

<?php
//اضافه کردن کپچا به پروژه
//include 'captcha.php';
//خوندن اطلاعات یه صورت کد
$myusername=base64_encode($_POST['myusername']);
$mypassword=base64_encode($_POST['mypassword']);
$userCaptcha = $_POST['captcha'];
$id=($_POST['id']);
session_start();
//چک کردن متن کپچا
if($_SESSION['captcha'] == $userCaptcha) {
//چک کردن این که تمامی فیلدها یر شده یاشه
if(!empty($_POST['myusername']) && !empty($_POST['mypassword'])) {
    //یرقراری ارتیاط یا دیتاییس
    $conn = oci_connect("system", "data1111224", "192.168.137.15:1521/GENERAL");
    if (!$conn) {
        $e = oci_error();
        print htmlentities($e['message']);
        exit;
    } else {
        //چک کردن اینکه اطلاعات قیلا ثیت شده یاشد
        //چک کردن یوزرنیم براساس حقیقی یا حقوقی
        if ($id == 'idcodemelli') {
            $query = "SELECT * FROM T3 WHERE T3_1='" . $myusername . "' and T3_3= '" . $mypassword . "' ";
        } else {
            $query = "SELECT * FROM T3 WHERE T3_2='" . $myusername . "' and T3_3= '" . $mypassword . "' ";
        }

        $stid = oci_parse($conn, $query);
        $result = oci_execute($stid);
        $count = oci_fetch_row($stid);
        if ($count !=0) {
            $_SESSION["myusername"] = $myusername;
            $_SESSION["mypassword"] = $mypassword;
            echo "خوش آمدید";
			echo "<br>";
			echo "user name:<br>base64_decode($myusername)<br> password:base64_decode($mypassword)<br>";
//    header("location:C:\wamp\www\test\login try\login_success.php");
        }
        else {
            echo "کاربری با این مشخصات یافت نشد ";
        }
    }
}
else {
        echo "username or pasword <br>";
    }
}
else {
	echo "captcha <br>";
}


		


?>
</body>
</html>