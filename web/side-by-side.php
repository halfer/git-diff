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
	'/test/diffs/add-lines1', '/test/diffs/del-lines1', '/test/diffs/add-del1',
	'/test/diffs/modify-lines1',
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
						<?php foreach ($pages[0]->getLeftLineNumbers() as $number): ?>
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
						<?php foreach ($pages[0]->getLeftLines() as $line): ?>
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
						<?php foreach ($pages[0]->getRightLineNumbers() as $number): ?>
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
						<?php foreach ($pages[0]->getRightLines() as $line): ?>
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
			<?php $pages[0]->render() ?>
		</div>

		<p>
			This is the raw diff:
		</p>

		<pre><?php echo htmlspecialchars($diffs[0]) ?></pre>

		<p>
			This is a more complex diff, so copying it here to try it:
		</p>

		<div class="container">
			<?php $pages[1]->render() ?>
		</div>

		<p>
			This is the raw diff:
		</p>

		<pre><?php echo htmlspecialchars($diffs[1]) ?></pre>

		<hr />

		<h2>Unit test data</h2>
		
		<?php for ($fileNo = 2; $fileNo < count($files); $fileNo++): ?>

			<p>Graphical diff:</p>
			<div class="container">
				<?php $pages[$fileNo]->render() ?>
			</div>

			<p>Raw diff:</p>
			<pre><?php echo htmlspecialchars($diffs[$fileNo]) ?></pre>

		<?php endfor ?>

		<?php // So we can see the end of the demo better ?>
		<p style="clear: both;">&nbsp;</p>
	</body>
</html>