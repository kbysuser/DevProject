<?php
require 'vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;


// サーバーのIPアドレスを取得
$ip = $_POST['ip_address'];
// $ip = getHostByName(getHostName());

// サーバーURL（ポート8080で動作している前提）
$server_url = "http://$ip:8080/index.html";

// QRコードを生成
$qrCode = new QrCode($server_url);
$qrCode->setSize(300);
$qrCode->setEncoding(new Encoding('UTF-8'));
// $qrCode->setEncoding('UTF-8');
$qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh());

// QRコードをPNG形式で生成
$writer = new PngWriter();
$pngData = $writer->write($qrCode)->getString();

// QRコードを出力
header('Content-Type: image/png');
echo $pngData;
?>