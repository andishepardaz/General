<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<form action="uploadprocess.php" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value=""/>
<label>اسکن عکس</label><input type="file" name="scanp"/><br/>
<label>اسکن شناسنامه</label><input type="file" name="scansh"><br/>
<label>اسکن کارت ملی</label></label><input type="file" name="scancm"/>
<br/><br/>
<input type="submit" name="submit" value="ثبت"/>
</form>

<?php
session_start();
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$password=$_POST['password'];
$cpassword=$_POST['cpassword'];
$sex=$_POST['sex'];
$soal=$_POST['soal'];
$javab=$_POST['javab'];
$codemelli=$_POST['codemelli'];
$father=$_POST['father'];
$year=$_POST['year'];
$month=$_POST['month'];
$day=$_POST['day'];
if (empty($_POST["codemelli"])) {
    echo "کد ملی باید وارد شود";
    echo "<br>";
    echo "operation failed";
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
        $con1=oci_connect("system","data1111224","192.168.137.15:1521/GENERAL");
		$codemellimd5=encrypt($codemelli,$codemelli);
       $ecode=oci_parse($con1,"SELECT * FROM T1 WHERE T1_1='$codemellimd5'");
				oci_execute($ecode);
        $checkcode=oci_fetch_row($ecode);
        if($checkcode!=0){
            while($row=oci_fetch_assoc($ecode)){
				$dbcode=$row['codemelli'];
				if($dbcode==$codemelli){
				echo "your code is right";
				
				
				
				}
				else{
					echo "this code is not inserted";
				}
			}
			
        }
        else {
            
            $checkcodemelli=true;
        }
		oci_close($con1);
    }
	
}
if($checkcodemelli){
	if($firstname && $lastname && $password && $cpassword   &&  $father && $year && $month && $day){
		$con=oci_connect("system","data1111224","192.168.137.15:1521/GENERAL");
        $firstnamet = test_input($firstname);
        // check if name only contains letters and whitespace
        if (!preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s]+$/u', $firstnamet)) {
            echo "فقط فارسی تایپ کنید";
        }else{
			$firstnamemd5=encrypt($firstname,,$codemelli);
			$codemellimd5=encrypt($codemelli,$codemelli);
			$query=oci_parse($con,"UPDATE T1 SET T1_2='$firstnamemd5' WHERE T1_1='$codemellimd5'  ");
			oci_execute($query);
		}
        $lastnamet = test_input($lastname);
        // check if name only contains letters and whitespace
        if (!preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s]+$/u', $lastnamet)) {
            echo "فقط فارسی تایپ کنید";
        }else{
			$lastnamemd5=encrypt($lastname,$codemelli);
			$codemellimd5=encrypt($codemelli,$codemelli);
			$query1=oci_parse($con,"UPDATE T1 SET T1_3='$lastnamemd5' WHERE T1_1='$codemellimd5'");
			oci_execute($query1);
		}
        $fathert = test_input($father);
        // check if name only contains letters and whitespace
        if (!preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s]+$/u', $fathert)) {
            echo "فقط فارسی تایپ کنید";
        }else{
			$fathermd5=encrypt($father,$codemelli);
			$codemellimd5=encrypt($codemelli,$codemelli);
			$query2=oci_parse($con,"UPDATE T1 SET T1_10='$fathermd5' WHERE T1_1='$codemellimd5'");
			oci_execute($query1);
		}
       $flagDate=0;
        if(!preg_match('[0-9]{4}', $year) && (int)$year >1320){
            echo "سال وارد شده معتبر نمی باشد";

        }else{
			$yearmd5=encrypt($year,$codemelli);
            $flagDate++;
		}
        if(!preg_match('[0-9]{2}', $month) &&(int)$month>=01 &&(int)$month<=12){
            echo "ماه وارد شده معتبر نمی باشد";
        }else{
			$monthmd5=encrypt($month,$codemelli);
            $flagDate++;
		}
        if(!preg_match('[0-9]{2}', $day) &&(int)$day>=01 &&(int)$day<=31){
            echo "روز وارد شده معتبر نمی باشد";
        }else{
			$daymd5=encrypt($day,$codemelli);
            $flagDate++;
		}
        if($flagDate==3) {
            $date = $yearmd5 . $monthmd5 . $daymd5;
            $codemellimd5 = encrypt($codemelli,$codemelli);
            $querydate = oci_parse($con, "UPDATE T1 SET T1_6='$date' WHERE T1_1='$codemellimd5'");
            oci_execute($querydate);
            echo "your birthday date inserted successfully";
        }
	if($password==$cpassword){
		if(strlen($password)>4){
			$codemellimd5=encrypt($codemelli,$codemelli);
			$querycode=oci_parse($con,"INSERT INTO T3(T3_1)VALUES('$codemellimd5')");
            oci_execute($querycode);
            $passwordmd5=encrypt($password,$codemelli);
            $querypass=oci_parse($con,"UPDATE T3 SET T3_3='$passwordmd5' WHERE T3_1='$codemellimd5' ");
            oci_execute($querypass);
			}else{
				echo "your password is too short";
			}
			
			}else{
				echo "your passwords do not match";
			}

        oci_close($con);
		}
		
		if(isset($_REQUEST['soal'])){
			$con1=oci_connect("system","data1111224","192.168.137.15:1521/GENERAL");
			$codemellimd5=encrypt($codemelli,$codemelli);
			$soalmd5=encrypt($soal,$codemelli);
			$querysoal=oci_parse($con1,"UPDATE T3 SET T3_6='$soalmd5'WHERE T3_1='$codemellimd5'");
			oci_execute($querysoal);
			echo "your question has been inserted successfully do not forget it please!";
            oci_close($con1);
		}else{
			echo "you have to choose one of the questions";
			echo "<br>";
		}
		if(empty($_POST['javab'])){
			echo "you have to answer to the question !";
			echo "<br>";
		}else{
            $con1=oci_connect("system","data1111224","192.168.137.15:1521/GENERAL");
			$codemellimd5=encrypt($codemelli,$codemelli);
			$javabmd5=encrypt($javab,$codemelli);
			$queryjavab=oci_parse($con1,"UPDATE T3 SET T3_7='$javabmd5'WHERE T3_1='$codemellimd5'");
			oci_execute($queryjavab);
			echo "your answer has been inserted successfully";
			echo "<br>";
            oci_close($con1);
		}

		//for inserting the values of the radio buttons.
        $sex=$_POST['sex'];
        $conn=oci_connect("system","data1111224","192.168.137.15:1521/GENERAL");
        $query="INSERT INTO T1(T1_14)VALUES(':sex')";
        $result=oci_parse($conn,$query);
        oci_bind_by_name($result,":sex",$sex);
        oci_execute($result,oci_DEFAULT);
        oci_commit($conn);
        echo "your sex has been inserted succesfully";
 }

      
}else{
		echo "please complete the form!";
		echo "<br>";
	}




//تابع ورودی رو تبدیل به html میکند
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//تابع فرمول چک کد ملی
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

 


?>
</body>
</html>