<?php

// Load useful classes here
$root = realpath(__DIR__ . '/..');
require_once $root . '/lib/DiffPage.php';
require_once $root . '/lib/DiffSection.php';
require_once $root . '/lib/DiffLine.php';

// Ignore query string
$baseUrl = strpos($_SERVER['REQUEST_URI'], '?') !== false ?
	substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?')) :
	$_SERVER['REQUEST_URI'];
// Use only a-z chars for page name
$page = preg_replace('/[^a-z]+/', '', $baseUrl);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Diff demo page</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css">
			/* This is the use-case specific container */
			.container {
				border: 1px solid silver;
				overflow: scroll;
				width: 1000px;
				height: 300px;
			}
			body > p {
				max-width: 1000px;
			}
		</style>
		<!-- This is for the web site itself -->
		<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="/js/main.js"></script>
		<link type="text/css" rel="stylesheet" href="/styles/main.css" />
		<!-- The compressed CSS file is for the diff library -->
		<link type="text/css" rel="stylesheet" href="/styles/compiled.css" />
	</head>
	<body>
		
		<?php include $root . '/templates/public/menu.php' ?>
		
		<?php include $root . "/templates/public/{$page}.php" ?>
	</body>
</html>
