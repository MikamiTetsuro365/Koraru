<?php
date_default_timezone_set('Asia/Tokyo');

function deleteFile(){

	$timeLimit = strtotime("10 minutes ago");//今より30分後の時間を取得
	$dir = dirname(__FILE__).'/img/';//削除対象のディレクトリ 
	
	$listFile = scandir($dir);//削除対象のディレクトリ内のファイルを検索し配列で返す。
	
	foreach($listFile as $hoge){
		$dirFile = $dir . $hoge;//削除ファイル
		if(!is_file($dirFile)){
			continue;//次へ
		}//見つかったファイルがファイルであるか？ファイルでなければ削除しない( ´_ゝ｀)
		$timeFile = filemtime($dirFile);//ファイルの最終更新日を取得
		if($timeFile < $timeLimit){//最終更新日
			unlink($dirFile);
		}
	}
}


deleteFile();//out内の不要なファイルを一掃
//ここから
$inFile = $_FILES['my_img']['tmp_name'];

$name =$_FILES['my_img']["name"];

$size =$_FILES['my_img']["size"];

//$error = $_FILES['my_img']["error"];

$end=0;

// ファイルアップロードの処理
if($size <= 1024000 ){
$ext = substr($name, -4);
$fileName= substr($inFile,-6);
if ( $ext == '.gif' || $ext == '.jpg') {
	$filePath = "img/{$fileName}{$ext}";
	move_uploaded_file($inFile, $filePath);
	
	$changeImg = new Imagick();

	$changeImg -> readImage($filePath);

	$changeImg -> setImageFormat("png");

	$changeImg -> writeImage("img/{$fileName}.png");
	
	unlink($filePath);
	
	$filePath = "img/{$fileName}.png";
	
}else if($ext == '.png' || $ext == '.PNG'){
	$filePath = "img/{$fileName}{$ext}";
	move_uploaded_file($inFile, $filePath);
}else {
	
	$end=1;
	
}

if($end == 1){
	
	echo 'エラー ：ファイルの拡張子(.jpg .png .gif は可)やファイルサイズを見なおしてください.';
	
}else{

	//$reImgSize = resize($filePath);
	$file = new Imagick($filePath);//画像読み込みfu~↑
	$imgWidth = $file->getImageWidth();
	$imgHeight= $file->getImageHeight();
	$file -> setFormat('png');
	
		if(($imgWidth > 640) || ($imgHeight > 640)){
			if($imgWidth > $imgHeight){
				$file -> thumbnailImage(640, 0);
				$imgHeight = $imgHeight * (640/$imgWidth);
				$imgWidth  =640;
			}else if($imgWidth < $imgHeight){
				$file -> thumbnailImage(0, 640);
				$imgWidth 	= $imgWidth * (640/$imgHeight);
				$imgHeight  =640;				
			}
		}else{
		}
	
	$file -> writeImage("$filePath");
	
	echo $filePath;
	
}

}
?>