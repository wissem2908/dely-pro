<?php
session_start();

/* ===== 1. Generate code ===== */
$characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$length = 5;
$code = '';

for ($i = 0; $i < $length; $i++) {
    $code .= $characters[random_int(0, strlen($characters) - 1)];
}

$_SESSION['captcha_code'] = $code;

/* ===== 2. Create image ===== */
$width  = 170;
$height = 50;

$image = imagecreatetruecolor($width, $height);

/* Colors (soft & modern) */
$bgColor     = imagecolorallocate($image, 245, 246, 248);
$textColor   = imagecolorallocate($image, 55, 55, 55);
$lineColor   = imagecolorallocate($image, 180, 180, 180);

/* Background */
imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

/* Noise lines (subtle) */
for ($i = 0; $i < 4; $i++) {
    imageline(
        $image,
        rand(0, $width),
        rand(10, $height),
        rand(0, $width),
        rand(10, $height),
        $lineColor
    );
}

/* ===== 3. Draw spaced letters ===== */
$fontSize = 5;
$x = 20;

for ($i = 0; $i < strlen($code); $i++) {
    $y = rand(14, 18); // small vertical variation
    imagestring(
        $image,
        $fontSize,
        $x,
        $y,
        $code[$i],
        $textColor
    );
    $x += 26; // spacing between characters
}

/* ===== 4. Output ===== */
header('Content-Type: image/png');
header('Cache-Control: no-store, no-cache, must-revalidate');
imagepng($image);
imagedestroy($image);
exit;
