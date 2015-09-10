<?php namespace foundationphp; ?>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>

<?php

use foundationphp\OCI;
require_once 'src/foundationphp/OCI.php';


//خوندن اطلاعات یه صورت کد
$myusername = encrypt($_POST['myusername'],$_POST['myusername']);
$mypassword = encrypt($_POST['mypassword'],$_POST['myusername']);
$userCaptcha = $_POST['captcha'];
$id=$_POST['id'];
$wrong=0;
$oci = new OCI();
session_start();
//چک کردن متن کپچا
if($_SESSION['captcha'] == $userCaptcha) {
//چک کردن این که تمامی فیلدها یر شده یاشه
if(!empty($_POST['myusername']) && !empty($_POST['mypassword'])) {

        //چک کردن اینکه اطلاعات قیلا ثیت شده یاشد
        //چک کردن یوزرنیم براساس حقیقی یا حقوقی
        if ($id == 'idcodemelli') {
			$count = $oci->fetchRow2("*","T3","T3_1",$myusername,"T3_3",$mypassword);
        } else {
			$count = $oci->FetchRow2("*","T3","T3_2",$myusername,"T3_3",$mypassword);
        }
        if ($count !=0) {
            $_SESSION["myusername"] = $myusername;
            $_SESSION["mypassword"] = $mypassword;
            echo "خوش آمدید";
			echo "<br>";
			echo "user name:<br>decrypt($myusername,$myusername)<br> password:decrypt($mypassword,$myusername)<br>";
//    header("location:C:\wamp\www\test\login try\login_success.php");
        }
        else {//تعداد دفعات وارد کردن اشتباه در دیتابیس ثبت میشود
            $wrong++;
            echo "کاربری با این مشخصات یافت نشد ";
            $count=$oci->insert("T1","T1_9","$wrong");

        }

}
else {
        echo "username or pasword <br>";
    }
}
else {
	echo "captcha <br>";
}
function encrypt($data, $secret)
{
    //Generate a key from a hash
    $key = md5(utf8_encode($secret), true);

    //Take first 8 bytes of $key and append them to the end of $key.
    $key .= substr($key, 0, 8);

    //Pad for PKCS7
    $blockSize = mcrypt_get_block_size('tripledes', 'ecb');
    $len = strlen($data);
    $pad = $blockSize - ($len % $blockSize);
    $data .= str_repeat(chr($pad), $pad);

    //Encrypt data
    $encData = mcrypt_encrypt('tripledes', $key, $data, 'ecb');

    return base64_encode($encData);
}

function decrypt($data, $secret)
{
    //Generate a key from a hash
    $key = md5(utf8_encode($secret), true);

    //Take first 8 bytes of $key and append them to the end of $key.
    $key .= substr($key, 0, 8);

    $data = base64_decode($data);

    $data = mcrypt_decrypt('tripledes', $key, $data, 'ecb');

    $block = mcrypt_get_block_size('tripledes', 'ecb');
    $len = strlen($data);
    $pad = ord($data[$len-1]);

    return substr($data, 0, strlen($data) - $pad);
}
		


?>
</body>
</html>