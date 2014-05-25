<?php
/*
 * Renders the line numbers for all page sections
 * 
 * @var $page
 * @var $isFullWidth
 */
?>

<div class="diff-content">
	<?php foreach ($page->getSections() as $ord => $section): ?>
		<div
			<?php // If we're missing out top lines, make that clear ?>
			class="section <?php if ($ord == 0 && $section->getFirstLineNumberForSide($side) > 1) echo 'top-missing' ?>"
		>
			<?php foreach ($section->getLinesForSide($side) as $line): ?>
				<?php if ($line instanceof ilovephp\DiffLine): ?>
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
	<?php endforeach ?>
</div>
