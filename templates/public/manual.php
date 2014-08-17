<?php
$pages = array();
$diffs = array();

$pages[0] = new \ilovephp\DiffPage();
$diffs[0] = file_get_contents($root . '/demo/example.diff');
$pages[0]->parseDiff($diffs[0]);

use ilovephp\DiffLine;
?>

<?php // jQuery should already be loaded before we load this ?>
<script type="text/javascript" src="/js/indenter.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.container').gitDiffIndentTabs();
	});
</script>

<p>
	This manual rendering is at file level, though it doesn't make it clear it's not the whole
	file (note that manual rendering probably isn't ideal, as it might not keep
	up to date with the renderer).
</p>

<p>The JavaScript to fix up tab-indentation is enabled on this page.</p>

<div class="container">
	<div class="file">
		<div class="left side">
			<div class="line-numbers">
				<?php foreach ($pages[0]->getLeftLineNumbers() as $number): ?>
					<?php if ($number): ?>
						<div class="line line-number-line">
							<code><?php echo $number ?></code>
						</div>
					<?php else: ?>
						<div class="line line-number-empty">
							<code>&nbsp;</code>
						</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
			<div class="diff-content">
				<?php foreach ($pages[0]->getLeftLines() as $line): ?>
					<?php if ($line instanceof DiffLine): ?>
						<div class="line diff-line <?php echo $line->getTypeName() ?>">
							<code><?php echo htmlentities($line->getText()) ?></code>
						</div>
					<?php else: ?>
						<div class="line diff-line-empty">
							<code></code>
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
							<code><?php echo $number ?></code>
						</div>
					<?php else: ?>
						<div class="line line-number-empty">
							<code>&nbsp;</code>
						</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
			<div class="diff-content">
				<?php foreach ($pages[0]->getRightLines() as $line): ?>
					<?php if ($line instanceof DiffLine): ?>
						<div class="line diff-line <?php echo $line->getTypeName() ?>">
							<code><?php echo htmlentities($line->getText()) ?></code>
						</div>
					<?php else: ?>
						<div class="line diff-line-empty">
							<code></code>
						</div>
					<?php endif ?>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>
