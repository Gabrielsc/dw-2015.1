<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<pre>
	<?php
		$result = shell_exec("ping -c3 8.8.8.8");
		// echo $result;
		$result = explode("\n", $result);
		var_dump($result);
	?>
	</pre>
</body>
</html>