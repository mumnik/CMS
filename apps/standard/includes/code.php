<?
die("asd");
//

//	require_once('conf/config.php');
	
echo "asd";
exit;
	$n=$_GET['n'];
	$sql="SELECT code FROM tmp_codes WHERE id='$n' LIMIT 1";
	$res = mysql_query($sql);
	
	$row = mysql_fetch_array($res);


	$dst_img = imagecreatetruecolor(60,21);
	$bg_color = imagecolorallocate ($dst_img, 235, 235, 235);
	imagefill ($dst_img, 0, 0, $bg_color);

	$dig=$row['code'];

for($e=0;$e<4;$e++){
	$typ=mt_rand(0, 3);
    $src="./i/digits/".$dig[$e]."_".$typ.".jpg";

	$rand_h=mt_rand(0, 4);
    $src_img = imagecreatefromjpeg($src);
    imagecopyresampled($dst_img, $src_img, $e*15, 1, 0, 0, 20, 21, 20, 21);
	
}

//header ("Content-type: image/jpeg");
//imagejpeg($dst_img);


?>