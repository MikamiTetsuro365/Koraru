<?php

$filePath   = $_POST['original'];
$img   = new Imagick($filePath);
$sozai = array('../sozai/don.png','../sozai/bokaboka.png','../sozai/byun.png','../sozai/goo.png','../sozai/ohoho.png','../sozai/ooo.png','../sozai/button.png','../sozai/youtube.png','../sozai/vuvuvu.png');

$x 	   = array_values($_POST['x1']);
$y	   = array_values($_POST['y1']);
$sizex = array_values($_POST['sizex']);
$sizey = array_values($_POST['sizey']);
$sozaiNum = array_values($_POST['sozaiNum']);
$angel = array_values($_POST['angel']);

//$pasteDate = array(array_values($_POST['x1']),array_values($_POST['y1']),array_values($_POST['sizex']),array_values($_POST['sizey']),array_values($_POST['sozaiNum']));

while((list(,$X) = each($x)) && (list(,$Y) = each($y)) && (list(,$SIZEX) = each($sizex)) && (list(,$SIZEY) = each($sizey)) && (list(,$SOZAINUM) = each($sozaiNum)) && (list(,$ANGEL) = each($angel))){
		if($SOZAINUM == 0){
			
		}else{
		$pasteImg = new Imagick($sozai[$SOZAINUM-1]);
		$pasteImg -> thumbnailImage($SIZEX,$SIZEY);
		if(!($ANGEL == 0)){
			$pasteImg -> rotateImage(new ImagickPixel('none'),$ANGEL);
			$imgWidth = $pasteImg -> getImageWidth();
			$imgHeight= $pasteImg -> getImageHeight();
			$pastePointX  = $X - (($imgWidth - $SIZEX)/2);
			$pastePointY  = $Y - (($imgHeight - $SIZEY)/2);
		}else{
			$pastePointX  = $X;
			$pastePointY  = $Y;
		}
		
		$img -> compositeImage($pasteImg,Imagick::COMPOSITE_DEFAULT,$pastePointX,$pastePointY);
		
		}
		
	}
	$img->writeImage("$filePath");
	
	echo $filePath;

?>