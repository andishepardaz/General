<?php
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$password=$_POST['password'];
$cpassword=$_POST['cpassword'];
$men=$_POST['men'];
$famale=$_POST['famale'];
$soal=$_POST['soal'];
$javab=$_POST['javab'];
$codemelli=md5($_POST['codemelli']);
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
        $con1=oci_connect("system","data1111224","192.168.137.1:1521/GENERAL");
		$codemellimd5=md5($codemelli);
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
		$con=oci_connect("system","data1111224","198.168.137.1:1521/GENERAL");
        $firstname = test_input($firstname);
        // check if name only contains letters and whitespace
        if (!preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s]+$/u', $firstname)) {
            echo "فقط فارسی تایپ کنید";
        }else{
			$firstnamemd5=md5($firstname);
			$codemellimd5=md5($codemelli);
			$query=oci_parse($con,"UPDATE T1 SET T1_2='$firstnamemd5' WHERE T1_1='$codemellimd5'  ");
			oci_execute($query);
		}
        $lastname = test_input($lastname);
        // check if name only contains letters and whitespace
        if (!preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s]+$/u', $lastname)) {
            echo "فقط فارسی تایپ کنید";
        }else{
			$lastnamemd5=md5($lastname);
			$codemellimd5=md5($codemelli);
			$query1=oci_parse($con,"UPDATE T1 SET T1_3='$lastnamemd5' WHERE T1_1='$codemellimd5'");
			oci_execute($query1);
		}
        $father = test_input($father);
        // check if name only contains letters and whitespace
        if (!preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s]+$/u', $lastname)) {
            echo "فقط فارسی تایپ کنید";
        }else{
			$fathermd5=md5($father);
			$codemellimd5=md5($codemelli);
			$query2=oci_parse($con,"UPDATE T1 SET T1_10='$fathermd5' WHERE T1_1='$codemellimd5'");
			oci_execute($query1);
		}
        $year = test_input($year);
        //check if year only contains numbers
        if(!preg_match('[0-9]{4}', $year) && '$year'>1320){
            echo "سال وارد شده معتبر نمی باشد";
        }else{
			$yearmd5=md5($year);
		}
        if(!preg_match('[0-9]{2}', $month) && '$month'>=01 && '$month'<=12){
            echo "ماه وارد شده معتبر نمی باشد";
        }else{
			$monthmd5=md5($month);	
		}
        if(!preg_match('[0-9]{2}', $day) && '$day'>=01 && '$day'<=31){
            echo "روز وارد شده معتبر نمی باشد";
        }else{
			$daymd5=md5($day);
		}
		$date=$yearmd5 . $monthmd5 . $daymd5;
		$codemellimd5=md5($codemelli);
		$datemd5=md5($date);
		$querydate=oci_parse($con,"UPDATE T1 SET T1_6='$datemd5' WHERE T1_1='$codemellimd5'");
		oci_execute($querydate);
		echo "your birthday date inserted successfully";
	if($password==$cpassword){
		if(strlen($password)>4){
			$codemellimd5=md5($codemelli);
			$querycode=oci_parse($con,"INSERT INTO T3(T3_1)VALUES('$codemellimd5')");
            oci_execute($querycode);
            $passwordmd5=md5($password);
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
		
		if(isset($_RQUESTE['SOal'])){
			$con1=oci_connect("system","data1111224","198.168.137.1:1521/GENERAL");
			$codemellimd5=md5($codemelli);
			$soalmd5=md5($soal);
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
            $con1=oci_connect("system","data1111224","198.168.137.1:1521/GENERAL");
			$codemellimd5=md5($codemelli);
			$javabmd5=md5($javab);
			$queryjavab=oci_parse($con1,"UPDATE T3 SET T3_7='$javabmd5'WHERE T3_1='$codemellimd5'");
			oci_execute($queryjavab);
			echo "your answer has been inserted successfully";
			echo "<br>";
            oci_close($con1);
		}
	
	
      
    //for uploading of pics
    $namesh = $_FILES['scansh']['name'];
	//finding the place of file's format for uploading
    $extensionsh = strtolower(substr($namesh, strpos($namesh, '.')+1));
    $sizesh = $_FILES['scansh']['size'];
    $typesh = $_FILES['scansh']['type'];
	//choosing the max size for the file which we want to upload
    $max_sizesh = 102400;
    $errorsh = $_FILES['scansh']['error'];
    $tmp_namesh = $_FILES['scansh']['tmp_name'];
    if(isset($_GET["scansh"])){
        if(!empty($namesh)){
			//realizing the type of the file 
            if(($extensionsh=='jpg'||$extensionsh=='jpeg') && $typesh=='image/jpeg' && $sizesh<=$max_sizesh){
                move_uploaded_file($tmp_namesh, $namesh);
                $bin_string = file_get_contents($namesh);
				//for encryption of the file
                $hex_string = base64_encode($bin_string);
                $con2 = oci_connect("system","data1111224","192.168.137.1:1521/GENERAL");
                if(!$con2){
                    $e = oci_error();
                    trigger_error(htmlentities($e['message'],ENT_QUOTES), E_USER_ERROR);
                }
				$codemellimd5=md5($codemelli);
                $qrsh=oci_parse($con2,"UPDATE T1 SET T1_15='" . $hex_string . "' WHERE T1_1='$codemellimd5' ");
                oci_execute($qrsh);
                oci_close($con2);
            }
            else{
                echo "The File must be jpeg/jpg and must be 100kb or less";
            }
        }
        else{
            echo "Please choose File";
        }
    }
    else{
        if($errorsh > 0){
            echo "Error: " . $errorsh . "<br>";
        }
    }
    $namecm = $_FILES['scancm']['name'];
    $extensioncm = strtolower(substr($namecm, strpos($namecm, '.')+1));
    $sizecm = $_FILES['scancm']['size'];
    $typecm = $_FILES['scancm']['type'];
    $max_sizecm = 102400;
    $errorcm = $_FILES['scancm']['error'];

    $tmp_namecm = $_FILES['scancm']['tmp_name'];

    if(isset($_GET["scancm"])){
        if(!empty($namecm)){
            if(($extensioncm=='jpg'||$extensioncm=='jpeg') && $typecm=='image/jpeg' && $sizecm<=$max_sizecm){
                move_uploaded_file($tmp_namecm, $namecm);
                $con2 = oci_connect("system","data1111224","192.168.137.1:1521/GENERAL");
                $bin_string = file_get_contents($namecm);
                $hex_string = base64_encode($bin_string);
                if(!$con2){
                    $e = oci_error();
                    trigger_error(htmlentities($e['message'],ENT_QUOTES), E_USER_ERROR);
                }
				$codemellimd5=md5($codemelli);
                $qrcm=oci_parse($con2,"UPDATE  T1 SET T1_16='" . $hex_string . "' WHERE T1_1='$codemellimd5' ");
                oci_execute($qrcm);
                oci_close($con2);
            }
            else{
                echo "The File must be jpeg/jpg and must be 100kb or less";
            }
        }
        else{
            echo "Please choose File";
        }
    }
    else{
        if($errorcm > 0){
            echo "Error: " . $errorcm . "<br>";
        }
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



?>