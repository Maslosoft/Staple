<?php

use Maslosoft\Ilmatar\Components\Controller;
use Maslosoft\Staple\Models\RequestItem;
?>
<?php
/* @var $this Controller */
/* @var $item RequestItem */
?>

<li style="<?= $item->style; ?>">
	<a href="<?= $item->url; ?>"><?= $item->title; ?></a>
	<?php if (!empty($item->items)): ?>
		<ul>
			<?php foreach ($item->items as $sub): ?>
				<?= $sub; ?>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</li>