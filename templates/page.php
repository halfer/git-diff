<?php
/* @var $page ilovephp\DiffPage */
/* @var $forceStatus string */
?>
<div class="file <?php if ($forceStatus) echo 'full-width' ?>">
	<?php if ($forceStatus != ilovephp\DiffPage::INSERTED): ?>
		<div class="left side">
			<?php $page->renderSide('left', (bool) $forceStatus) ?>
		</div>	
	<?php endif ?>
	<?php if ($forceStatus != ilovephp\DiffPage::DELETED): ?>
		<div class="right side">
			<?php $page->renderSide('right', (bool) $forceStatus) ?>
		</div>
	<?php endif ?>
</div>
