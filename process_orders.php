<?php
echo "<html>\n  <head>\n    <title>Forecast</title>\n  </head>\n  <body>\n  <p><pre>\n";

putenv("GALAXYNGHOME=/home/gng/Games");

$tmpfname = tempnam("/tmp", "galaxyng");

$fp = fopen($tmpfname, "w");

$orders = explode("\n", $_POST["orders"]);

for ($i = 0; $i < count($orders); $i++) {
  $line = rtrim($orders[$i]);
  fwrite($fp, $line);
  fwrite($fp, "\n");
}

fclose($fp);

passthru("/home/gng/Games/galaxyng -webcheck < $tmpfname");


echo "\n  </pre></p>";

echo "\n  </body>\n</html>";
?>