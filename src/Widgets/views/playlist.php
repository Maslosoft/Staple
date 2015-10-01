<?php

use Maslosoft\Staple\Widgets\Playlist;
use Maslosoft\Staple\Widgets\Vo\PlaylistItem;
?>
<?php
/* @var $this Playlist */
/* @var $item PlaylistItem */
?>

<div class="maslosoft-playlist">
	<?php foreach ($this->getItems() as $item): ?>
		<a href="<?= $item->getUrl(); ?>"><?= $item->getTitle(); ?></a>
	<?php endforeach; ?>
</div>