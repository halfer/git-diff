<?php
/*
 * Blocks removed go on the left
 * Blocks added go on the right
 * 
 * - What do the @@ mean?
 * 
 * Format: @@ a,b +x,y @@
 * 
 * Try: @@ -3,6 +3,8 @@
 * -3,6: new content added on line 6
 * +3,8: new block now 8 lines long
 * 
 * Try: @@ -10,21 +12,37 @@
 * 
 * 
 * The -3 and +3 are the lines of context
 */

// Load useful classes here
$root = realpath(__DIR__ . '/..');
require_once $root . '/lib/DiffPage.php';
require_once $root . '/lib/DiffSection.php';
require_once $root . '/lib/DiffLine.php';

use ilovephp\DiffPage;
use ilovephp\DiffLine;

// Here's the files and diffs to look at
$files = array(
	'/demo/example.diff', '/demo/example2.diff',
);

$pages = array();
$diffs = array();

// Set up demo pages
foreach ($files as $ord => $file)
{
	$pages[$ord] = new DiffPage();
	$diffs[$ord] = file_get_contents($root . $file);
	$pages[$ord]->parseDiff($diffs[$ord]);
}

?>

<html>
	<head>
		<title></title>
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
		<script type="text/javascript" src="/js/main.js"></script>
		<link type="text/css" rel="stylesheet" href="/styles/main.css" />
		<link type="text/css" rel="stylesheet" href="/styles/compiled.css" />
	</head>
	<body>

		<?php include $root . '/templates/public/menu.php' ?>

		<?php include $root . '/templates/public/toggle.html' ?>

		<p>
			This renders by section, and so does a better job of showing it's not the whole
			file:
		</p>

		<!-- Do by section -->
		<div class="container">
			<?php $pages[0]->render() ?>
		</div>

		<div class="raw-diff">
			<p>
				This is the raw diff:
			</p>

			<pre><?php echo htmlspecialchars($diffs[0]) ?></pre>
		</div>

		<p>
			This is a more complex diff, so copying it here to try it:
		</p>

		<div class="container">
			<?php $pages[1]->render() ?>
		</div>

		<div class="raw-diff">
			<p>
				This is the raw diff:
			</p>

			<pre><?php echo htmlspecialchars($diffs[1]) ?></pre>
		</div>

		<?php // So we can see the end of the demo better ?>
		<p style="clear: both;">&nbsp;</p>
	</body>
</html>
