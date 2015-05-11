<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<ul>
		<?php
			$countItems = 10;
			for($flag=0;$flag<$countItems;$flag++){
				echo "<li>Item $flag</li>";
			}
		?>
	</ul>
</body>
</html>