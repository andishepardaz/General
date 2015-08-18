<?php
$name = $_FILES['file']['name'];
$extension = strtolower(substr($name, strpos($name, '.')+1));
$size = $_FILES['file']['size'];
$type = $_FILES['file']['type'];
$max_size = 204800;
$tmp_name = $_FILES['file']['tmp_name'];
if(isset($name)){
    if(!empty($name)){
        if(($extension=='jpg'||$extension=='jpeg') && $type=='image/jpeg' && $size<=$max_size){
            $con=oci_connect("system","data1111224","192.168.137.1:1521/GENERAL");
        $query=oci_parse($con,"INSERT INTO T1(T1_15,T1_16) VALUES()");
        }
        else{
            echo "The File must be jpeg/jpg and must be 200kb or less";
        }
    }
    else{
        echo "Please choose File";
    }
}

?>