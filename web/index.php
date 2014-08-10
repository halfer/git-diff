<?php

// Load useful classes here
$root = realpath(__DIR__ . '/..');
require_once $root . '/lib/DiffPage.php';
require_once $root . '/lib/DiffSection.php';
require_once $root . '/lib/DiffLine.php';

// Use only a-z chars for page name
$page = preg_replace('/[^a-z]+/', '', $_SERVER['REQUEST_URI']);
?>
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
		<script type="text/javascript" src="/js/jquery-1.10.2.min.js"></script>
		<link type="text/css" rel="stylesheet" href="/styles/compiled.css" />
	</head>
	<body>
		
		<?php include $root . '/templates/public/menu.php' ?>
		
		<?php include $root . "/templates/public/{$page}.php" ?>
	</body>
</html>
