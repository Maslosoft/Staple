<?php

use Maslosoft\Staple\Widgets\SubNav;
use Maslosoft\Staple\Widgets\Vo\SubNavItem;
?>
<?php
/* @var $this SubNav */
/* @var $item SubNavItem */
?>
<nav class="sub-nav">
	<ul>
		<?php foreach ($this->getItems() as $item): ?>
			<li>
				<a href="<?= $item->getUrl(); ?>"><?= $item->getTitle(); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
