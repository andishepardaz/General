<?php namespace foundationphp;?> 
<html>
<head>
<meta charset="UTF-8">
</head>
<body>


<?php
use foundationphp\UploadFile;
use foundationphp\OCI;
require_once 'src/foundationphp/UploadFile.php';
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
$oci = new OCI();
$checkcodemelli = false;
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
		$codemellimd5=encrypt($codemelli,$codemelli);
		$checkcode = $oci->fetchRowAssoc($row,"*","T1","T1_1",$codemellimd5);
        if($checkcode!=0){
            while($row){
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
    }
}
if(!$checkcodemelli){
	if($firstname && $lastname && $password && $cpassword   &&  $father && $year && $month && $day){
        $firstnamet = test_input($firstname);
        // check if name only contains letters and whitespace
        if (!preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s]+$/u', $firstnamet)) {
            echo "فقط فارسی تایپ کنید";
        }else{
			$firstnamemd5=encrypt($firstname,$codemelli);
			$codemellimd5=encrypt($codemelli,$codemelli);
			$oci->update("T1","T1_2",$firstnamemd5,"T1_1",$codemellimd5);
		}
        $lastnamet = test_input($lastname);
        // check if name only contains letters and whitespace
        if (!preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s]+$/u', $lastnamet)) {
            echo "فقط فارسی تایپ کنید";
        }else{
			$lastnamemd5=encrypt($lastname,$codemelli);
			$codemellimd5=encrypt($codemelli,$codemelli);
			$oci->update("T1","T1_3",$lastnamemd5,"T1_1",$codemellimd5);
		}
        $fathert = test_input($father);
        // check if name only contains letters and whitespace
        if (!preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s]+$/u', $fathert)) {
            echo "فقط فارسی تایپ کنید";
        }else{
			$fathermd5=encrypt($father,$codemelli);
			$codemellimd5=encrypt($codemelli,$codemelli);
			$oci->update("T1","T1_10",$fathermd5,"T1_1",$codemellimd5);
		}
       $flagDate=0;
        if(!preg_match("([0-9]{4})", $year) && (int)$year <1320){
            echo "سال وارد شده معتبر نمی باشد";

        }else{
			$yearmd5=encrypt($year,$codemelli);
            $flagDate++;
		}
        if(!preg_match("([0-9]{2})", $month) &&(int)$month<01 &&(int)$month>12){
            echo "ماه وارد شده معتبر نمی باشد";
        }else{
			$monthmd5=encrypt($month,$codemelli);
            $flagDate++;
		}
        if(!preg_match("([0-9]{2})", $day) &&(int)$day<01 &&(int)$day>31){
            echo "روز وارد شده معتبر نمی باشد";
        }else{
			$daymd5=encrypt($day,$codemelli);
            $flagDate++;
		}
        if($flagDate==3) {
            $date = $yearmd5 . $monthmd5 . $daymd5;
            $codemellimd5 = encrypt($codemelli,$codemelli);
            $oci->update("T1","T1_6",$date,"T1_1",$codemellimd5);
            echo "your birthday date inserted successfully";
        }
	if($password==$cpassword){
		if(strlen($password)>4){
			$codemellimd5=encrypt($codemelli,$codemelli);
            $oci->insert("T3","T3_1",$codemellimd5);
            $passwordmd5=encrypt($password,$codemelli);
            $oci->update("T3","T3_3",$passwordmd5,"T3_1",$codemellimd5);
			}else{
				echo "your password is too short";
			}
			
			}else{
				echo "your passwords do not match";
			}
		}
		if(isset($_REQUEST['soal'])){
			$codemellimd5=encrypt($codemelli,$codemelli);
			$soalmd5=encrypt($soal,$codemelli);
			$oci->update("T3","T3_6",$soalmd5,"T3_1",$codemellimd5);
			echo "your question has been inserted successfully do not forget it please!";
            
		}else{
			echo "you have to choose one of the questions";
			echo "<br>";
		}
		if(empty($_POST['javab'])){
			echo "you have to answer to the question !";
			echo "<br>";
		}else{
			$codemellimd5=encrypt($codemelli,$codemelli);
			$javabmd5=encrypt($javab,$codemelli);
			$oci->update("T3","T3_7",$javabmd5,"T3_1",$codemellimd5);
			echo "your answer has been inserted successfully";
			echo "<br>";
		}
		//for inserting the values of the radio buttons.
        $codemellimd5=encrypt($codemelli,$codemelli);
			$sexmd5 = encrypt($sex,$codemellimd5);
        $oci->update("T1","T1_14",$sexmd5,"T1_1",$codemellimd5);
        echo "your sex has been inserted succesfully";
		
//Upload scan shenasname & scan carte melli
$max = 1024 * 200; //100 kilobyte
$result = array();
if(isset($_POST['submit'])){
	$destination = __DIR__ . '\profiles';
	$directory = $destination."\\$codemelli\\images";
    mkdir($directory,0777,true);
    try {
            $upload = new UploadFile($directory);
            $upload->setMaxsize($max); //Change the file size
            $upload->saveAndUpload($_FILES['scanp'],$codemelli,"T1","T1_15","T1_1",$codemellimd5);
            $upload->saveAndUpload($_FILES['scansh'],$codemelli,"T1","T1_16","T1_1",$codemellimd5);
            $upload->saveAndUpload($_FILES['scancm'],$codemelli,"T1","T1_17","T1_1",$codemellimd5);
            $result = $upload->getMessages();
        } catch(Exception $e) {
            $result[] = $e->getMessage();
			}
    
	}
 
 
 
 
 
 
 
 
 } else{
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