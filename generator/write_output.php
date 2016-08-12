<?php
//test vars
$output="Test";
$output_file="index.html";

$output_url="../$output_file";
//Open File
$output_filehandle=fopen($output_url, "w");
//Write final file
fwrite($output_filehandle, $output);
?>
