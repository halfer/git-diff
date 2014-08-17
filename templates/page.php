<?php
/* @var $page ilovephp\DiffPage */
/* @var $forceStatus string */
?>
<div class="file <?php if ($forceStatus) echo 'full-width' ?>">
	<?php if ($forceStatus != ilovephp\DiffPage::INSERTED): ?>
		<div class="left side">
			<div style="display: table;">
				<?php $page->renderSide('left', (bool) $forceStatus) ?>
			</div>
		</div>	
	<?php endif ?>
	<?php if ($forceStatus != ilovephp\DiffPage::DELETED): ?>
		<div class="right side">
			<div style="display: table;">
				<?php $page->renderSide('right', (bool) $forceStatus) ?>
			</div>
		</div>
	<?php endif ?>
</div>
