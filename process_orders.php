<?php
	function usage() {
		echo "Usage: #galaxy game_name race_name password turn_number [FinalOrders]\n";
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

	echo "$first_line";
	if ( $finalOrders != null) {
		echo " FinalOrders";
        }
	echo "\n";
	for ($i = 1; $i < count($orders); $i++) {
		echo "$orders[$i]";
	}
	echo "</pre></p>";

	if ( $orders[0][0] != '#') {
		echo "first character is not an octothorp\n";
	}

	echo "</body></html>";
?>