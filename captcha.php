<?php
  session_start();
 // $captchaText = substr(md5(microtime()), 0, 5);
  $letters='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
 // $captchaText=substr(str_shufle($letters), 0, 6);
 //match all of the charecters together
  $captchaText=substr(str_shuffle(str_repeat($letters,5)),0,5);
  //baraye moghayeseye inke captchaye vared shode dar page dg baham barabar bashad
  $_SESSION['captcha'] = $captchaText;

  $image = imagecreate(120, 70);
  $background = imagecolorallocatealpha($image, 239, 239, 239, 1);
  $textColor = imagecolorallocatealpha($image, 0, 0, 0, 1);
  $x = 5;
  $y = 50;
  
  for($i = 0; $i < 7; $i++) {
    $fontSize = mt_rand(15, 20);
    $text = substr($captchaText, $i, 1);
    imagettftext($image, $fontSize, 0, $x, $y, $textColor, './impact.ttf', $text);
    
    $x = $x + 17 + mt_rand(0, 10);
    $y = mt_rand(40, 45);
  }
  
  header("Content-type: application/jpeg");
  imagejpeg($image);
  imagedestroy($image);
?>