<?php 
$mysql = 5.3;
$php = 2.2;
$apache = 5.5;
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/styles.css">
<script src="js/jquery.tools.min.js"></script>
</head>
<body class='main-body'>
	<h1>Hostmon Installation</h1>
	<div class='install'>
		<table class='install_table'>
		<caption>Dependencies</caption>
			<tr>
				<td class='install_label'>PHP Version</td>
				<td class='install_value' id='install_red'><?php echo $php?></td>
			</tr>
			<tr>
				<td class='install_label'>MySQL Version</td>
				<td class='install_value' id='install_green'><?php echo $mysql?></td>
			</tr>
			<tr>
				<td class='install_label'>Apache Version</td>
				<td class='install_value' id='install_green'><?php echo $apache?></td>
			</tr>
		</table>
	</div>
</body>
</html>
