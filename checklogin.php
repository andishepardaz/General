<?php
//اضافه کردن کپچا به پروژه
include 'captcha.php';
//خوندن اطلاعات یه صورت کد
$myusername=md5($_POST['myusername']);
$mypassword=md5($_POST['mypassword']);
$userCaptcha = $_POST['captcha'];
$id=($_POST['id']);
session_start();
//چک کردن متن کپچا
if($_SESSION['captcha'] == $userCaptcha) {
//چک کردن این که تمامی فیلدها یر شده یاشه

if(!empty($_POST['myusername']) && !empty($_POST['mypassword'])){
    //یرقراری ارتیاط یا دیتاییس
    $conn = oci_connect("system", "data1111224", "192.168.137.1:1521/GENERAL");
    if (!$conn) {
        $e = oci_error();
        print htmlentities($e['message']);
        exit;
    } else {
        //چک کردن اینکه اطلاعات قیلا ثیت شده یاشد
       //چک کردن یوزرنیم براساس حقیقی یا حقوقی
        if ($id=='idcodemelli'){
           $query = "SELECT * FROM T3 WHERE T3_1='" . $myusername . "' and T3_3= '" . $mypassword . "' ";}
        else{
            $query = "SELECT * FROM T3 WHERE T3_2='" . $myusername . "' and T3_3= '" . $mypassword . "' ";}

        $stid = oci_parse($conn, $query);
        $result = oci_execute($stid);
        $count = oci_fetch_row($stid);
        if ($count == 1) {
            $_SESSION["myusername"]=$myusername;
            $_SESSION["mypassword"]=$mypassword;
            echo "خوش آمدید";
//    header("location:C:\wamp\www\test\login try\login_success.php");
        } else {
            echo "نام  کاربری یا پسورد اشتباه میباشد";
        }
    }
}
}
else {
	echo "کادر متنی اشتباه وارد شده";
}

   
		
		//set cookie:
		$cookie_name = $myusername;
$cookie_value = $mypassword;
// 86400 = 1 day
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 
if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
	//checking cookie:
	if(count($_COOKIE) > 0) {
    echo "Cookies are enabled.";
} else {
    echo "Cookies are disabled.";
}
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name];
}
?>
