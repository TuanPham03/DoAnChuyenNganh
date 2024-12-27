<?php
$err = "";
$arrImg = array("image/png", "image/jpeg", "image/bmp","image/jpg");
$errFile = isset($_FILES["upload"]["error"])?$_FILES["upload"]["error"]:"";
if (isset($_FILES["upload"]) && isset($_FILES["upload"]["error"])) {
if ($errFile>0)
	$err .="Lỗi file hình <br>";
else
{
	$type =$_FILES["upload"]["type"];
	if (!in_array($type, $arrImg))
		$err .="Không phải file hình <br>";
	else
	{	$temp = $_FILES["upload"]["tmp_name"];
		$name = $_FILES["upload"]["name"];
		if (!move_uploaded_file($temp, "../images/".$name))
			$err .="Không thể lưu file<br>";
		
	}
}
}
?>