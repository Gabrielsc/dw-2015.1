<?php
			$countItems = 10;
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<ul>
		<?php for($flag=0;$flag<$countItems;$flag++){?>
				<li>Item <?php echo $flag?></li>
		<?php } ?>
	</ul>
</body>
</html>