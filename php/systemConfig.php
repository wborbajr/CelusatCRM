<?php

$title = "EasyPad";
$version = "1.0.0a";
$copyright = "(c) B&R Technology :)";

$return[] = array(
	"title" => utf8_encode($title),
	"version" => utf8_encode($version),
	"copyright" => utf8_encode($copyright)
);

echo json_encode($return);

?>