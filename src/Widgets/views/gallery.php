<?php

use Maslosoft\Staple\Widgets\Gallery;
use Maslosoft\Staple\Widgets\Vo\GalleryFile;
?>
<?php
/* @var $this Gallery */
/* @var $file GalleryFile */
?>
<div style="margin: 0px auto;" class="staple-gallery">
	<?php foreach ($this->getFiles() as $file): ?>
		<a href="<?= $file->getUrl(); ?>" style="cursor:zoom-in;">
			<img src="<?= $file->getThumbUrl(); ?>"  class="img-thumbnail img-margins" style="vertical-align: top;"/>
		</a>
	<?php endforeach; ?>
</div>