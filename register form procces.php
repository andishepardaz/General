<?php
$codemelli=$_POST['codemelli'];
$email=$_POST['email'];
$cemail=$_POST['cemail'];
$checkcodemelli=false;
//چک کردن اینکه فیلد کد ملی حتما باید بر شده باشد در غیر این صورت قادر به ادامه ی کار نخواهد بود
if (empty($_POST["codemelli"])) {
    echo "کد ملی باید وارد شود";
    exit();
}
elseif(!preg_match("/^[0-9 ]*$/",$_POST["codemelli"])) {
    echo "کد ملی باید رقم باشد";
}
elseif(strlen($_POST["codemelli"]) <> 10){
    echo "کد ملی باید ده رقم باشد";
}

elseif(preg_match("([0]{10}|[1]{10}|[2]{10}|[3]{10}|[4]{10}|[5]{10}|[6]{10}|[7]{10}|[8]{10}|[9]{10})", $_POST["codemelli"])){
    echo "اعداد کد ملی نمی توانند برابر هم باشند";
}
else {
    $code = test_codemelli($_POST["codemelli"]);
    if(!$code)
    {
        echo "کد ملی وارد شده صحیح نمی باشد";
    }
    else{
        $con1=oci_connect("system","data1111224","192.168.137.1:1521/GENERAL");
		$codemellimd5=md5($codemelli);
        $rcode=oci_parse($con1,"SELECT * FROM T1 WHERE T1_1='$codemellimd5'");
        oci_execute($rcode);
        $checkcode=oci_fetch_row($rcode);
        if($checkcode!=0){
            echo "کد ملی قبلا وجود دارد";
        }
        else {
			$codemellimd5=md5($codemelli);
            $rcode2 = oci_parse($con1, "INSERT INTO T1(T1_1) VALUES ('$codemellimd5')");
            oci_execute($rcode2);
            echo "Your national code inserted successfully";
            $checkcodemelli=true;
        }
		oci_close($con1);
    }
}
if($checkcodemelli){
//    چک کردن اینکه تمامی فیلد ها بر شده باشد
if($email && $cemail ){
	//چک کردن اینکه ایمل های وارد شده در دو مرحله  با هم یکسان باشد
	if($email==$cemail){
		//چک کردن اینکه ایمیل وارد شده معتبر باشد
		$email=test_input($email);//چک کردن کرکترهای وارد شده در فیلد ایمیل
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			echo "your email address is invalid try again";
		}else{
		//برقراری اتصال به دیتابست
            $con=oci_connect("system","data1111224","192.168.137.1:1521/GENERAL");
			$emailmd5=md5($email);
            $remail=oci_parse($con,"SELECT T5_3 FROM T5 WHERE T5_3='$emailmd5' ");
            oci_execute($remail);
            $checkmail=oci_fetch_row($remail);
            if($checkmail!=0) {
                echo "this email is already existed";
            }else {
				$emailmd5=md5($email);
				$codemellimd5=md5($codemelli);
				$rcd2 = oci_parse($con, "INSERT INTO T5(T5_1) VALUES ('$codemellimd5')");
				oci_execute($rcd2);
                $remail2 = oci_parse($con,"UPDATE T5 SET T5_3='$emailmd5' WHERE T5_1='$codemellimd5'");
                oci_execute($remail2);
                echo "Your email inserted successfully";
                echo "<br>";
				//فرستادن ایمیل
				$mailto='$email';
				$body="<a href='register2.php'>click here</a>";
				$subject="your verify";
				$header="from : parniyan@hotmail.com";
				if(mail($mailto,$subject,$body,$header)){
					
					echo "your verify code has been send into ".$mailto;
				}else{
					echo "sending operation has been failed";
				}
            }
                      oci_close($con);
        }
	

}else{
        echo "your emails donot match";
    }
}else{
echo "please complete the form";

}

}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function test_codemelli($code)
{
    $codeArray = str_split($code);
    $j = 10;
    $sum = 0;
    for($i=0; $i<=8; $i++)
    {
        $sum +=((int)($codeArray[$i])) * $j;
        --$j;
    }
    $divid = $sum % 11;
    if ($divid <= 2)
    {
        if($codeArray[9]  == $divid)
        {
            return true;
        }
        return false;
    }
    else
    {
        $divid1 = 11 - $divid;
        if ($codeArray[9]  == $divid1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
	
}
?>