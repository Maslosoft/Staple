<?php

use Maslosoft\Staple\Widgets\Gallery;
use Maslosoft\Staple\Widgets\Vo\GalleryFile;
?>
<?php
/* @var $this Gallery */
/* @var $file GalleryFile */
?>
<div style="margin: 0px auto;">
	<?php foreach ($this->getFiles() as $file): ?>
		<a href="<?= $file->getUrl(); ?>" data-lightbox="gallery" class="img-lightbox">
			<img src="<?= $file->getThumbUrl(); ?>"  class="img-thumbnail img-margins" style="vertical-align: top;"/>
		</a>
	<?php endforeach; ?>
</div>