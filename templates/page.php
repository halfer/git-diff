<?php
/* @var $page ilovephp\DiffPage */
/* @var $forceStatus string */
?>
<div class="file <?php if ($forceStatus) echo 'full-width' ?>">
	<?php if ($forceStatus != ilovephp\DiffPage::INSERTED): ?>
		<div class="left side">
			<div class="inner-side">
				<?php $page->renderSide('left', (bool) $forceStatus) ?>
			</div>
		</div>	
	<?php endif ?>
	<?php if ($forceStatus != ilovephp\DiffPage::DELETED): ?>
		<div class="right side">
			<div class="inner-side">
				<?php $page->renderSide('right', (bool) $forceStatus) ?>
			</div>
		</div>
	<?php endif ?>
</div>
