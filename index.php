<?php

include "env.php";

if ($_POST["type"] and $_POST["orders"]) {

	header('Content-type: text/plain');

	$tmpfname = tempnam("/tmp", "galaxyng");
	
	$fp = fopen($tmpfname, "w"); 
	
	$lines = explode("\n", $_POST["orders"]);
	
	$line1 = preg_split("[\s]", $lines[0], -1, PREG_SPLIT_NO_EMPTY);
	
	for ($i = 0; $i < count($lines); $i++) {
	  $line = rtrim(str_replace("\\", "", "$lines[$i]"));
	  fwrite($fp, $line); 
	  fwrite($fp, "\n");
	}
	
	fclose($fp);
	
	switch ($_POST["type"]) {
		case "order":
			$filename=$line1[1] . "_" . $line1[2] . "_forecast_" . $line1[4] . ".txt";
			header("Content-disposition: attachment; filename=\"$filename\"");
			passthru("$NGpath/galaxyng -webcheck < $tmpfname  | awk 'sub(\"$\", \"\\r\")'");
		break;
		case "report":
			$filename=$line1[1] . "_" . $line1[2] . "_report_" . $line1[4] . ".txt";
			header("Content-disposition: attachment; filename=\"$filename\"");
			passthru("$NGpath/galaxyng -webreport < $tmpfname | awk 'sub(\"$\", \"\\r\")'");
		break;
	}
	
	$command = "rm -f" . $tmpfname;
	system($command);

} else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US">
	<?php include "head.php"; ?>
	<form action="<?php echo $PHP_SELF; ?>" method="post">
	<p><input type="radio" name="type" value="cmd_orders" checked>Orders <input type="radio" name="type" value="cmd_report"> Report
	<br/><textarea name="orders" rows="10" cols="80"></textarea>
	<br/><input type="submit" value="Submit"> <input type="reset"></p>
	</form>

<?php }

include "foot.php";

?>

</body>
</html>
