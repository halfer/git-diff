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

// Set up demo pages
$page1 = new DiffPage();
$page1->parseDiff(file_get_contents($root . '/demo/example.diff'));

$page2 = new DiffPage();
$page2->parseDiff(file_get_contents($root . '/demo/example2.diff'));

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
		</style>
		<link type="text/css" rel="stylesheet" href="/styles/git-diff.css" />
	</head>
	<body>
		<p>
			This rendering is at file level, though it doesn't make it clear it's not the whole
			file:
		</p>

		<div class="container">
			<div class="file">
				<div class="left side">
					<div class="line-numbers">
						<?php foreach ($page1->getLeftLineNumbers() as $number): ?>
							<?php if ($number): ?>
								<div class="line line-number-line">
									<pre><?php echo $number ?></pre>
								</div>
							<?php else: ?>
								<div class="line line-number-empty">
									<pre>&nbsp;</pre>
								</div>
							<?php endif ?>
						<?php endforeach ?>
					</div>
					<div class="diff-content">
						<?php foreach ($page1->getLeftLines() as $line): ?>
							<?php if ($line instanceof DiffLine): ?>
								<div class="line diff-line <?php echo $line->getTypeName() ?>">
									<pre><?php echo htmlentities($line->getText()) ?></pre>
								</div>
							<?php else: ?>
								<div class="line diff-line-empty">
									<pre></pre>
								</div>
							<?php endif ?>
						<?php endforeach ?>
					</div>
				</div>
				<div class="right side">
					<div class="line-numbers">
						<?php foreach ($page1->getRightLineNumbers() as $number): ?>
							<?php if ($number): ?>
								<div class="line line-number-line">
									<pre><?php echo $number ?></pre>
								</div>
							<?php else: ?>
								<div class="line line-number-empty">
									<pre>&nbsp;</pre>
								</div>
							<?php endif ?>
						<?php endforeach ?>
					</div>
					<div class="diff-content">
						<?php foreach ($page1->getRightLines() as $line): ?>
							<?php if ($line instanceof DiffLine): ?>
								<div class="line diff-line <?php echo $line->getTypeName() ?>">
									<pre><?php echo htmlentities($line->getText()) ?></pre>
								</div>
							<?php else: ?>
								<div class="line diff-line-empty">
									<pre></pre>
								</div>
							<?php endif ?>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>

		<p>
			This renders by section, and so does a better job of showing it's not the whole
			file:
		</p>

		<!-- Do by section -->
		<div class="container">
			<?php $page1->render() ?>
		</div>

		<p>
			This is a problematic diff, so copying it here to test:
		</p>

		<div class="container">
			<?php $page2->render() ?>
		</div>

		<?php // So we can see the end of the demo better ?>
		<p style="clear: both;">&nbsp;</p>
	</body>
</html>