<?php
echo "<html>\n  <head>\n    <title>Forecast</title>\n  </head>\n  <body>\n  <p><pre>\n";

// on my example server I would change @SETHOME@ to /home/gng/Games
// remember, there are two places to change it in this script
putenv("GALAXYNGHOME=@SETHOME@");

$tmpfname = tempnam("/tmp", "galaxyng");

$fp = fopen($tmpfname, "w");

$orders = explode("\n", $_POST["orders"]);

for ($i = 0; $i < count($orders); $i++) {
  $line = rtrim($orders[$i]);
  fwrite($fp, $line);
  fwrite($fp, "\n");
}

fclose($fp);

passthru("@SETHOME@/galaxyng -webcheck < $tmpfname");

$command = "rm -f" . $tmpfname;
system($command);

echo "\n  </pre></p>";

echo "\n  </body>\n</html>";
?>