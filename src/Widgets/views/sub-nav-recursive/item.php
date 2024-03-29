<?php

use Maslosoft\Staple\Widgets\Vo\SubNavItem;
?>
<?php

/* @var $item SubNavItem */
?>

<li style="<?= $item->style; ?>">
	<a href="<?= $item->url; ?>"><?= $item->getTitle(); ?></a>
	<?php if (!empty($item->items)): ?>
		<ul>
			<?php foreach ($item->items as $sub): ?>
				<?= $sub; ?>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</li>