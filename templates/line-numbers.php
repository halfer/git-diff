<?php
/*
 * Renders the line numbers for all page sections
 * 
 * @var $page
 */
?>

<div class="line-numbers">
	<?php foreach ($page->getSections() as $ord => $section): ?>
		<div
			<?php // If we're missing out top lines, make that clear ?>
			class="line-numbers-section <?php if ($ord == 0 && $section->getFirstLineNumberForSide($side) > 1) echo 'top-missing' ?>"
		>
			<?php foreach ($section->getLineNumbersForSide($side) as $number): ?>
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
	<?php endforeach ?>
</div>