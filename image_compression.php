<?php

if (!function_exists("imagecreatefrombmp")) {
	function imagecreatefrombmp( $filename ) {
		$file = fopen( $filename, "rb" );
		$read = fread( $file, 10 );
		while( !feof( $file ) && $read != "" )
		{
			$read .= fread( $file, 1024 );
		}
		$temp = unpack( "H*", $read );
		$hex = $temp[1];
		$header = substr( $hex, 0, 104 );
		$body = str_split( substr( $hex, 108 ), 6 );
		if( substr( $header, 0, 4 ) == "424d" )
		{
			$header = substr( $header, 4 );
			// Remove some stuff?
			$header = substr( $header, 32 );
			// Get the width
			$width = hexdec( substr( $header, 0, 2 ) );
			// Remove some stuff?
			$header = substr( $header, 8 );
			// Get the height
			$height = hexdec( substr( $header, 0, 2 ) );
			unset( $header );
		}
		$x = 0;
		$y = 1;
		$image = imagecreatetruecolor( $width, $height );
		foreach( $body as $rgb )
		{
			$r = hexdec( substr( $rgb, 4, 2 ) );
			$g = hexdec( substr( $rgb, 2, 2 ) );
			$b = hexdec( substr( $rgb, 0, 2 ) );
			$color = imagecolorallocate( $image, $r, $g, $b );
			imagesetpixel( $image, $x, $height-$y, $color );
			$x++;
			if( $x >= $width )
			{
				$x = 0;
				$y++;
			}
		}
		return $image;
	}
}

$name = ''; $type = ''; $size = ''; $error = '';
function compress_image($source_url, $destination_url, $quality) {
	$info = getimagesize($source_url);
	if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
	elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
	elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
	imagejpeg($image, $destination_url, $quality);
	return $destination_url;
}

if ($_POST) {
	if ($_FILES["file"]["error"] > 0) { $error = $_FILES["file"]["error"]; }
	else if (($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/bmp") ) {

		$url = 'destination .jpg';
		$filename = compress_image($_FILES["file"]["tmp_name"], $url, 65);
		$buffer = file_get_contents($url);
		/* Force download dialog... */
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		/* Don't allow caching... */
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		/* Set data type, size and filename */
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . strlen($buffer));
		header("Content-Disposition: attachment; filename=$url");
		/* Send our file... */
		echo $buffer;

	}
	else { $error = "Uploaded image should be jpg, gif, bmp or png"; }
} ?>

<html>
<head> <title>Php code compress the image</title> </head>
<body> <div class="message"> <?php if($_POST){ if ($error) { ?> <label class="error"><?php echo $error; ?></label> <?php } } ?> </div> <fieldset class="well"> <legend>Upload Image:</legend> <form action="" name="myform" id="myform" method="post" enctype="multipart/form-data"> <ul> <li> <label>Upload:</label> <input type="file" name="file" id="file"/> </li> <li> <input type="submit" name="submit" id="submit" class="submit btn-success"/> </li> </ul> </form> </fieldset> </body>
</html>