<?
	require "Ping.php";

	$ping = new Ping();
	$ping->loadData($_GET["domain"]);
	header("Content-type:application/json");
	echo $ping->request();
?>