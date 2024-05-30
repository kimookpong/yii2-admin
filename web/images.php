<?php
$cfg = array();
$cfg = $_REQUEST;
switch ($cfg['style']) {

	case "fix":
		fix();
		break;
	case "ratio":
		ratio();
		break;
	case "ratio_in":
		ratio_in();
		break;
	case "fix_display":
		fix_display();
		break;
	case "cropImage":
		cropImage();
		break;
	case "cropImageIn":
		cropImageIn();
		break;
	default:
		original();
		break;
}
function original()
{
	global $cfg;
	$file = $cfg['src'];
	if (file_exists($file)) {
		list($width, $height, $type, $attr) = getimagesize($file);
		$s = filesize($file);
		if ($s > 102428) {
			$cfg['max_w'] = 1024;
			$cfg['max_h'] = 800;
			ratio();
			return;
		}
		header('Content-length: ' . filesize($file));
		header('Content-type: ' . $type);
		readfile($file);
	}
}
function fix()
{
	fix_display();
}
function fix_display()
{
	global $cfg;
	$max_x = $cfg['max_w'];
	$max_y = $cfg['max_h'];
	$file = $cfg['src'];
	$default = ($_GET['defaultpath']) ? $_GET['defaultpath'] : "images/nopic.jpg";
	if (!checkimageexists($file)) {
		$file = $default;
	}
	$info = pathinfo($file);
	$get_ext = $info['extension'];

	if ($get_ext == "jpg" or $get_ext == "jpeg") {
		$src = imagecreatefromjpeg($file);
		$size = getimagesize($file);
	} elseif ($get_ext == "gif") {
		$src = imagecreatefromgif($file);
		$size = getimagesize($file);
	} elseif ($get_ext == "png") {
		$src = imagecreatefrompng($file);
		$size = getimagesize($file);
	} else {
		$src = imagecreatefromjpeg($default);
		$size = getimagesize($default);
	}

	$x = $size[0];
	$y = $size[1];
	$x_ratio = $max_x / $x;
	$y_ratio = $max_y / $y;


	$new_x = $max_x;
	$new_y = $max_y;


	$dst = @imagecreatetruecolor($new_x, $new_y) or die('Cannot Initialize new GD image stream');

	imagealphablending($dst, false);
	imagesavealpha($dst, true);
	$transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
	imagefilledrectangle($dst, 0, 0, $new_x, $new_y, $transparent);
	imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_x, $new_y, $x, $y);
	header("Content-type: image/png");
	imagepng($dst);
	imagedestroy($src);
	imagedestroy($dst);
}
function ratio()
{
	global $cfg;
	$max_x = $cfg['max_w'];
	$max_y = $cfg['max_h'];
	$file = $cfg['src'];
	$default = ($_GET['defaultpath']) ? $_GET['defaultpath'] : "themes/default/images/nopic.jpg";
	if (!checkimageexists($file)) {
		$file = $default;
	}
	$info = pathinfo($file);
	$get_ext = $info['extension'];

	if ($get_ext == "jpg" or $get_ext == "jpeg") {
		$src = imagecreatefromjpeg($file);
		$size = getimagesize($file);
	} elseif ($get_ext == "gif") {
		$src = imagecreatefromgif($file);
		$size = getimagesize($file);
	} elseif ($get_ext == "png") {
		$src = imagecreatefrompng($file);
		$size = getimagesize($file);
	} else {
		$src = imagecreatefromjpeg($default);
		$size = getimagesize($default);
	}

	$x = $size[0];
	$y = $size[1];
	$x_ratio = $max_x / $x;
	$y_ratio = $max_y / $y;

	if (($x <= $max_x) && ($y <= $max_y)) {
		$new_x = $x;
		$new_y = $y;
	} else if (($x_ratio * $y) < $max_y) {
		$new_x = $max_x;
		$new_y = ceil($x_ratio * $y);
	} else {
		$new_x = ceil($y_ratio * $x);
		$new_y = $max_y;
	}

	$dst = @imagecreatetruecolor($new_x, $new_y) or die('Cannot Initialize new GD image stream');
	imagealphablending($dst, false);
	imagesavealpha($dst, true);
	$transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
	imagefilledrectangle($dst, 0, 0, $new_x, $new_y, $transparent);
	imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_x, $new_y, $x, $y);
	header("Content-type: image/png");
	imagepng($dst);
	imagedestroy($src);
	imagedestroy($dst);
}

function ratio_in()
{
	global $cfg;

	$max_x = $cfg['max_w'];
	$max_y = $cfg['max_h'];
	$file = $cfg['src'];
	$default = ($_GET['defaultpath']) ? $_GET['defaultpath'] : "images/nopic.jpg";
	if (!checkimageexists($file)) {
		$file = $default;
	}
	$info = pathinfo($file);
	$get_ext = $info['extension'];

	if ($get_ext == "jpg" or $get_ext == "jpeg") {
		$src = imagecreatefromjpeg($file);
		$size = getimagesize($file);
	} elseif ($get_ext == "gif") {
		$src = imagecreatefromgif($file);
		$size = getimagesize($file);
	} elseif ($get_ext == "png") {
		$src = imagecreatefrompng($file);
		$size = getimagesize($file);
	} else {
		$src = imagecreatefromjpeg($default);
		$size = getimagesize($default);
	}

	$x = $size[0];
	$y = $size[1];

	$img_ratio = $x / $y;
	$new_max_y = $max_y + 30;
	if (($x <= $max_x) && ($y <= $max_y)) {
		$new_x = $x;
		$new_y = $y;
	} else if ($img_ratio > 1) {
		$new_x = $max_x;
		$new_y = $max_x / $img_ratio;
	} else {
		$new_y = $max_x / $img_ratio;
		if ($new_y > $new_max_y) {
			$new_y = $new_max_y;
			$new_x = $new_max_y * $img_ratio;
		} else {
			$new_x = $max_x;
			$new_y = $max_x / $img_ratio;
		}
	}
	$dst = @imagecreatetruecolor($new_x, $new_y) or die('Cannot Initialize new GD image stream');
	imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_x, $new_y, $x, $y);
	header("Content-type: image/png");
	imagepng($dst);
	imagedestroy($src);
	imagedestroy($dst);
}

function checkimageexists($path)
{
	return file_exists($path);
}

function cropImage()
{
	global $cfg;
	$nw = $cfg['max_w'];
	$nh = $cfg['max_h'];
	$file = $cfg['src'];
	$default = ($_GET['defaultpath']) ? $_GET['defaultpath'] : "images/nopic.jpg";
	if (!checkimageexists($file)) {
		$file = $default;
	}
	$info = pathinfo($file);
	$get_ext = $info['extension'];

	if ($get_ext == "jpg" or $get_ext == "jpeg") {
		$simg = imagecreatefromjpeg($file);
		$size = getimagesize($file);
	} elseif ($get_ext == "gif") {
		$simg = imagecreatefromgif($file);
		$size = getimagesize($file);
	} elseif ($get_ext == "png") {
		$simg = imagecreatefrompng($file);
		$size = getimagesize($file);
	} else {
		$simg = imagecreatefromjpeg($default);
		$size = getimagesize($default);
	}

	$w = $size[0];
	$h = $size[1];

	$wm = $w / $nw;
	$hm = $h / $nh;


	$dimg = imagecreatetruecolor($nw, $nh);
	$whiteBackground = imagecolorallocate($dimg, 255, 255, 255);
	imagefill($dimg, 0, 0, $whiteBackground);

	$h_height = $nh / 2;
	$w_height = $nw / 2;

	if ($wm > $hm) {
		$adjusted_width = $w / $hm;
		$half_width = $adjusted_width / 2;
		$int_width = $half_width - $w_height;

		imagecopyresampled($dimg, $simg, -$int_width, 0, 0, 0, $adjusted_width, $nh, $w, $h);
	} else {
		$adjusted_height = $h / $wm;
		$half_height = $adjusted_height / 2;
		$int_height = $half_height - $h_height;

		imagecopyresampled($dimg, $simg, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
	}
	header("Content-type: image/jpeg");
	imagejpeg($dimg);
	imagedestroy($simg);
}
function cropImageIn()
{
	global $cfg;
	$nw = $cfg['max_w'];
	$nh = $cfg['max_h'];
	$file = $cfg['src'];
	$default = ($_GET['defaultpath']) ? $_GET['defaultpath'] : "images/nopic.jpg";
	if (!checkimageexists($file)) {
		$file = $default;
	}
	$info = pathinfo($file);
	$get_ext = $info['extension'];

	if ($get_ext == "jpg" or $get_ext == "jpeg") {
		$simg = imagecreatefromjpeg($file);
		$size = getimagesize($file);
	} elseif ($get_ext == "gif") {
		$simg = imagecreatefromgif($file);
		$size = getimagesize($file);
	} elseif ($get_ext == "png") {
		$simg = imagecreatefrompng($file);
		$size = getimagesize($file);
	} else {
		$simg = imagecreatefromjpeg($default);
		$size = getimagesize($default);
	}
	$w = $size[0];
	$h = $size[1];


	$dimg = imagecreatetruecolor($nw, $nh);

	$wm = $w / $nw;
	$hm = $h / $nh;

	$h_height = $nh / 2;
	$w_height = $nw / 2;


	$adjusted_height = $h / $wm;
	$adjusted_width = $w / $hm;
	$half_width = $adjusted_width / 2;
	$half_height = $adjusted_height / 2;
	$int_width = $half_width - $w_height;
	$int_height = $half_height - $h_height;

	if ($wm < $hm) {
		imagecopyresampled($dimg, $simg, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
		for ($i = 0; $i < 10; $i++) {
			imagefilter($dimg, IMG_FILTER_GAUSSIAN_BLUR);
		}
		//imagefilter($dimg, IMG_FILTER_GRAYSCALE);
		imagecopyresampled($dimg, $simg, -$int_width, 0, 0, 0, $adjusted_width, $nh, $w, $h);
	} else {
		imagecopyresampled($dimg, $simg, -$int_width, 0, 0, 0, $adjusted_width, $nh, $w, $h);
		for ($i = 0; $i < 10; $i++) {
			imagefilter($dimg, IMG_FILTER_GAUSSIAN_BLUR);
		}
		imagecopyresampled($dimg, $simg, 0, -$int_height, 0, 0, $nw, $adjusted_height, $w, $h);
	}

	header("Content-type: image/jpeg");
	imagejpeg($dimg);
	imagedestroy($simg);
}


