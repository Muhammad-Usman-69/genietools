<?php

/* $tempFilePath = 'C:\Users\lenovo\AppData\Local\Temp\ocrE365.tmp'; // Adjust this path as needed
if (file_exists($tempFilePath)) {
    echo '<br>Temp File Content: ' . file_get_contents($tempFilePath);
} else {
    echo '<br>Temp File does not exist.';
}
exit(); */
require "vendor/autoload.php";

use thiagoalessio\TesseractOCR\TesseractOCR;

try {
    // Perform OCR
    $ocr = (new TesseractOCR('./1543723594682.jpg'))
        ->run();

        $fp = fopen("./output.txt", "w");
        fwrite($fp, $ocr, 1000);
        fclose($fp);
        echo $ocr;
        
} catch (Exception $e) {
    // Handle any errors that occur during OCR
    echo 'Error: ' . $e->getMessage();
}

