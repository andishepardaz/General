<html>
<head>
<meta charset="UTF-8">
</head>
<body>

<?php
use foundationphp\UploadFile;
//Upload scan shenasname & scan carte melli
$max = 1024 * 200; //100 kilobyte
$result = array();
if(isset($_POST['submit'])){
	require_once 'src/foundationphp/UploadFile.php';
	$destination = __DIR__ . '/uploaded';
    try {
            $codemellimd5=encrypt($codemelli,$codemelli);
            $upload = new UploadFile($destination);
            $upload->setMaxsize($max); //Change the file size
            $upload->save($_FILES['scanp'],"T1","T1_15","T1_1",$codemellimd5);
            $upload->save($_FILES['scansh'],"T1","T1_16","T1_1",$codemellimd5);
            $upload->save($_FILES['scancm'],"T1","T1_17","T1_1",$codemellimd5);
            $result = $upload->getMessages();
        } catch(Exception $e) {
            $result[] = $e->getMessage();
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