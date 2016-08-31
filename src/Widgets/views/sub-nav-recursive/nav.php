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
			<?= $item; ?>
		<?php endforeach; ?>
	</ul>
</nav>
