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

switch ($req_type) {
 case "forecast":
   passthru("@SETHOME@/galaxyng -webcheck < $tmpfname");
   break;

 case "report":
   passthru("@SETHOME@/galaxyng -webreport < $tmpfname");
   break;
}

$command = "rm -f" . $tmpfname;
system($command);

echo "\n  </pre></p>";

echo "\n  </body>\n</html>";
?>