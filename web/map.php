<html>
	<head>
		<title>PingRIT Project - The Map</title>
		<link href="style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<h1>PingRIT Project</h1>
		<h3>IP Mapping Project for RIT<h3>
		<h4><a href="map.php">The Map</a> | <a href="hosts.php">Hostnames</a></h4>
		<table>
			<!-- Data rows -->			
			<?php	
				$timestart = microtime();			
				mysql_connect("localhost", "username", "password");
				mysql_select_db("database");

				for( $i = 1; $i < 255; $i++ ) {
					echo("<tr>\n");
					//echo("\t<td class='headerthird'>".$i."</td>\n");

					// Build a query
					$query = "SELECT * FROM ips WHERE `thirdo`=$i";
					$result = mysql_query($query);
					// No results
					if(mysql_affected_rows() == 0) {
						for( $j = 1; $j < 255; $j++ ) {
							echo("\t<td class='nodata'></td>\n");
						}
					} else {
						while($row = mysql_fetch_array($result)) {
							if($row['exists'] == "PING") {
								echo("\t<td class='exists'></td>\n");
							} elseif($row['exists'] == "REG") {
								echo("\t<td class='registered'></td>\n");
							} else {
								echo("\t<td class='doesnotexist'></td>\n");
							}
						}
					}
					echo("</tr>\n");
				}
				$timeend = microtime();
				$timeelapsed = $timeend - $timestart;
			?>
		</table>
		<h3>TIME ELAPSED: <? echo($timeelapsed); ms ?></h3>
		<div style="position:fixed; bottom:0px; left:0px; witdh:100%; height:20px; text-align:center; backround-color:grey;">Fuck bitches</div>
	</body>
</html>
