<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<?php


$file = base_url() . 'normas/amsterdam.pdf';
 
$filename = 'amsterdam.pdf';
 
echo ($file);
/*
header('Content-type: application/pdf');// esta linea fue mi dolor de cabeza
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file));
header('Accept-Ranges: bytes');
 
@readfile($file);
*/

?>
</body>
</html>
