<html>
	<head>
		<title>PingRIT Project - Hostnames</title>
		<link href="style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<h1>PingRIT Project</h1>
		<h3>IP Mapping Project for RIT<h3>
		<h4><a href="map.php">The Map</a> | <a href="hosts.php">Hostnames</a></h4>
		<?php
			// Connect to MySQL
			$timestart = microtime();			
			mysql_connect("localhost", "username", "password");
			mysql_select_db("database");

			// Just output the top levels if there's no GET['rootname']
			if(!isset($_GET['rootname'])) {
				// Generate and run a query to output root domains
				$query = "SELECT DISTINCT `rootname` FROM `ips` WHERE `rootname` != '' ORDER BY `rootname`";
				$result = mysql_query($query);
				
				while($root = mysql_fetch_array($result)) {
					echo("<a href='?rootname={$root[0]}'>{$root[0]}</a> | ");
				}
			} else {
			?>
		<ul>
			<?
				// Generate and run a query to output hostnames at a given domain
				$root = $_GET['rootname'];
				$root = mysql_real_escape_string($root);
				$hostquery = "SELECT * FROM `ips` WHERE `rootname` = '$root' ORDER BY `hostname`";
				$hostresult = mysql_query($hostquery) or die(mysql_error());
				while($row = mysql_fetch_array($hostresult)) {
					if($row['web'] != 0) {
						echo("<li>");
						echo("<a href='http://{$row['hostname']}.{$row['rootname']}'>");
						echo($row['hostname']);
						echo("</a>");
						echo("</li>\n");
					} else {
						?>
						<li><? echo($row['hostname']); ?></li>
						<?
					}
				}
			?>
		</ul>
			<?
			}
			$timeend = microtime();
			$timeelapsed = $timeend - $timestart;
		?>
		<h3>TIME ELAPSED: <? echo($timeelapsed); ms ?></h3>
	</body>
</html>
