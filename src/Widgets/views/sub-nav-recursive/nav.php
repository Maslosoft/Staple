<?php

use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Widgets\SubNav;
use Maslosoft\Staple\Widgets\Vo\SubNavItem;
use Maslosoft\Staple\Widgets\Vo\SubNavSeparator;
?>
<?php
/* @var $this SubNav */
/* @var $item SubNavItem */
/* @var $mv MiniView */
?>
<nav class="sub-nav">
	<ul>
		<?php foreach ($this->getItems() as $item): ?>
			<?php if ($item instanceof SubNavItem && !empty($item->style)): ?>
				<?php $item->style .= 'margin-left:1em;' ?>
			<?php endif; ?>
			<?php if ($item instanceof SubNavSeparator): ?>
			</ul>
			<ul>
			<?php endif; ?>
			<?= $item; ?>
			<?php if ($item instanceof SubNavSeparator): ?>
			</ul>
			<ul>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</nav>
