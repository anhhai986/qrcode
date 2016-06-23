<?php
// 包含 qrlib.php 或 phpqrcode.php
include('phpqrcode/phpqrcode.php');


 
//取得GET参数
$url        = isset($_GET["url"]) ? $_GET["url"] : 'help';
$errorLevel = isset($_GET["e"]) ? $_GET["e"] : 'L';
$PointSize  = isset($_GET["p"]) ? $_GET["p"] : '3';
$margin     = isset($_GET["m"]) ? $_GET["m"] : '0';
preg_match('/https:\/\/([\w\W]*?)\//si', $url, $matches);
 
//简单判断
//if ( $matches[1] != 'qqdie.com'|| $url == 'help') { //取消此行注释并注释下面一行，就能加入自定义的url过滤功能
if ( $url == 'help'){
    //简单的描述一下使用方法
    header("Content-type: text/html; charset=utf-8");
    echo '<title>在线二维码API接口| jrotty博客</title>';
    echo '<h1>欢迎使用jrotty博客在线二维码API服务！</h1>
    使用前请仔细查看参数说明：<br />
    <br />
    url: 二维码对应的网址<br /><br />
    m&nbsp&nbsp: 二维码白色边框尺寸,缺省值: 0px<br /><br />
    e&nbsp&nbsp: 容错级别(errorLevel)，可选参数如下(缺省值 L)：<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbspL水平    7%的字码可被修正<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbspM水平    15%的字码可被修正<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbspQ水平    25%的字码可被修正<br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbspH水平    30%的字码可被修正<br />
    p&nbsp&nbsp: 二维码尺寸，可选范围1-10(具体大小和容错级别有关)（缺省值：3）<br /><br />
  
    
    <b>目前仅自用，除允许外的链接无法生成二维码</b> ';
	exit();
} else  {

    //调用二维码生成函数
    createqr($url, $errorLevel, $PointSize, $margin);
}
 
//简单二维码生成函数
function createqr($value,$errorCorrectionLevel,$matrixPointSize,$margin) {
    QRcode::png($value,'qrcode.png', $errorCorrectionLevel, $matrixPointSize, $margin);
 $logo= 'logo.jpg';

$QR = 'qrcode.png';//已经生成的原始二维码图 
 
if ($logo !== FALSE) { 
 $QR = imagecreatefromstring(file_get_contents($QR)); 
 $logo = imagecreatefromstring(file_get_contents($logo)); 
 $QR_width = imagesx($QR);//二维码图片宽度 
 $QR_height = imagesy($QR);//二维码图片高度 
 $logo_width = imagesx($logo);//logo图片宽度 
 $logo_height = imagesy($logo);//logo图片高度 
 $logo_qr_width = $QR_width / 5; 
 $scale = $logo_width/$logo_qr_width; 
 $logo_qr_height = $logo_height/$scale; 
 $from_width = ($QR_width - $logo_qr_width) / 2; 
 //重新组合图片并调整大小 
 imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, 
 $logo_qr_height, $logo_width, $logo_height); 
} 
//输出图片 
Header("Content-type: image/png");
ImagePng($QR);
}
?>