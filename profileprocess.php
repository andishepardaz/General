<html>
<head>
<meta charset="UTF-8">
</head>
<body>
<?php
// Create connection
namespace foundationphp;
use foundationphp\OCI;
require_once 'src/foundationphp/OCI.php';
$oci = new OCI();
session_start();
if(isset($_SESSION['myusername'])){
	$id=$_SESSION['myusername'];
$row = oci->fetchArray("T1_1","T5_3","T5","T1","T1_1","T5","T5_1",$idmd5);
while ($row ) {
  echo "id: " . decrypt($row["T1_1"],$id). "  Name: " .decrypt( $row["T1_2"],$id). "Last name: " .$id($row["T1_3"],$id)."Email:". ($row["T5_3"],$id). "<br>";
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
<body>
</html>