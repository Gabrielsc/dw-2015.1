<?
	require "Ping.php";

	$ping = new Ping();
	$ping->loadData($_POST["domain"]);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		table {

		}
	</style>
</head>
<body>
	<table>
		<tr>
			<td>IP</td>
			<td id="ip"></td>
		</tr>
		<tr>
			<td>Pacotes Transmitidos</td>
			<td id="packetsTransmitted"></td>
		</tr>
		<tr>
			<td>Pacotes Recebidos</td>
			<td id="packetsReceived"></td>
		</tr>
	</table>
	<script>
		var ping = <?php echo $ping->request() ?>;
		document.querySelector("#ip").innerHTML = ping.ip;
		document.querySelector("#packetsTransmitted").innerHTML = ping.statistics.packetsTransmitted;
		document.querySelector("#packetsReceived").innerHTML = ping.statistics.packetsReceived;
	</script>	
</body>
</html>