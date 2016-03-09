<?php

use Maslosoft\Ilmatar\Components\Controller;
use Maslosoft\Staple\Models\RequestItem;
?>
<?php
/* @var $this Controller */
/* @var $item RequestItem */
?>

<li>
	<a href="<?= $item->url; ?>"><?= $item->title; ?></a>
	<?php if (!empty($item->items)): ?>
		<ul>
			<?php foreach ($item->items as $sub): ?>
				<?= $this->mv->render('sub-nav-recursive/item', ['item' => $sub], true) ?>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</li>