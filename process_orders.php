<?php
function usage() {
  echo "Usage: #galaxy game_name race_name password turn_number [FinalOrders]\n";
}

function mkDirE($dir,$dirmode=700) {
  if (!empty($dir)) {
    if (!file_exists($dir)) {
      preg_match_all('/([^\/]*)\/?/i', $dir,$atmp);
      $base="";
      foreach ($atmp[0] as $key=>$val) {
	$base=$base.$val;
	if(!file_exists($base))
	  if (!mkdir($base,$dirmode)) {
	    echo "Error: Cannot create ".$base;
	    return -1;
	  }
      }
    }
    else
      if (!is_dir($dir)) {
	echo "Error: ".$dir." exists and is not a directory";
	return -2;
      }
  }
  
  return 0;
  
}

echo "<html>\n<head><title>Forecast</title></head><body>";
$orders = explode("\n", $_POST['orders']);

echo "<p><pre>";
$first_line = rtrim($orders[0]);
$line1 = explode(" ", $first_line);

if (count($line1) < 5) {
  echo "Invalid first line: $orders[0]\n";
  usage();
  return 1;
 }

if (strcasecmp($line1[0], "#galaxy") != 0) {
  echo "Invalid first line: $orders[0]\n";
  usage();
  echo "Line must begin with #galaxy\n";
  return 1;
 }

echo "$first_line\n";

for ($i = 1; $i < count($orders); $i++) {
  echo "$orders[$i]";
 }
echo "</pre></p>";

$docRoot=$_SERVER['DOCUMENT_ROOT'];

mkDirE("$docRoot/orders/$line1[1]", 0777);

$ordersFile = "$docRoot" . "/orders/". $line1[1] . "/" . $line1[2];
if (count($line1) == 6) {
  $ordersFile = $ordersFile . "_final";
}
$ordersFile = $ordersFile . "." . $line1[4];

$of = fopen($ordersFile, "w");

for ($i = 0; $i < count($orders); $i++)
  fwrite($of, $orders[$i]);

fclose($of);

$command = $_SERVER["CGI-BIN"] . "/galaxyng -webcheck < $ordersFile";
echo "command: $command";
passthru($command);

echo "</body></html>";
?>