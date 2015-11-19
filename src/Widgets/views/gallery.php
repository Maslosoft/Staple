<?php

use Maslosoft\Staple\Widgets\Gallery;
use Maslosoft\Staple\Widgets\Vo\GalleryFile;
?>
<?php
/* @var $this Gallery */
/* @var $file GalleryFile */
?>
<div class="staple-gallery row">
	<?php if (empty($this->getSizes())): ?>
		<div class="col-sm-12">
			<a href="<?= $file->getUrl(); ?>" style="cursor:zoom-in;width:100%;">
				<img src="<?= $file->getThumbUrl(); ?>"  class="<?= $this->thumbCss; ?>" style="vertical-align: top;width:100%;"/>
			</a>
		</div>
	<?php else: ?>
		<?php foreach ($this->getFiles() as $file): ?>
			<div class="<?= $this->getSizes(); ?>">
				<a href="<?= $file->getUrl(); ?>" style="cursor:zoom-in;width:100%;">
					<img src="<?= $file->getThumbUrl(); ?>"  class="<?= $this->thumbCss; ?>" style="vertical-align: top;width:100%;"/>
				</a>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>