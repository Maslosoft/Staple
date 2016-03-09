<?php

use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Widgets\SubNav;
use Maslosoft\Staple\Widgets\Vo\SubNavItem;
?>
<?php
/* @var $this SubNav */
/* @var $item SubNavItem */
/* @var $mv MiniView */
?>
<nav class="sub-nav">
	<ul>
		<?php foreach ($this->getItems() as $item): ?>
			<?= $this->mv->render('sub-nav-recursive/item', ['item' => $item], true) ?>
		<?php endforeach; ?>
	</ul>
</nav>
