<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US">

<?php

include "head.php";

if ($type and $orders) {  

// Change the path to your galaxyng home directory on the next line.
	putenv("GALAXYNGHOME=/home/user/Games");

	$tmpfname = tempnam("/tmp", "galaxyng");
	
	$fp = fopen($tmpfname, "w"); 
	
	$orders = explode("\n", $_POST["orders"]);
	
	for ($i = 0; $i < count($orders); $i++) {
	  $line = rtrim($orders[$i]);
	  fwrite($fp, $line); 
	  fwrite($fp, "\n");
	}
	
	fclose($fp);
	
	echo "<pre>\n";
	
	switch ($type) {
		case "order":
// Change the path to your galaxyng home directory on the next line.
			passthru("$NGpath/galaxyng -webcheck < $tmpfname");
		break;
		case "report":
// Change the path to your galaxyng home directory on the next line.
			passthru("$NGpath/galaxyng -webreport < $tmpfname");
		break;
	}
	
	$command = "rm -f" . $tmpfname;
	system($command);
	
	echo "\n</pre></p>";

} else { ?>

	<form action="<?php echo $PHP_SELF; ?>" method="post">
	<p><input type="radio" name="type" value="order" checked>Order <input type="radio" name="type" value="report"> Report
	<br/><textarea name="orders" rows="10" cols="80"></textarea>
	<br/><input type="submit" value="Submit"> <input type="reset"></p>
	</form>

<?php }

include "foot.php";

?>

</body>
</html>