<?php

use Maslosoft\Staple\Widgets\Carousel;
use Maslosoft\Staple\Widgets\Vo\CarouselItem;
?>
<?php
/* @var $this Carousel */
/* @var $item CarouselItem */
?>

<div id="<?= $this->getId(); ?>" class="carousel slide <?php if ($this->classic): ?>carousel-classic<?php endif; ?>" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<?php foreach ($this->getItems() as $id => $item): ?>
			<li data-target="#<?= $this->getId(); ?>" data-slide-to="<?= $id; ?>" class="<?php if ($id == 0): ?>active<?php endif; ?>"></li>
		<?php endforeach; ?>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<?php foreach ($this->getItems() as $id => $item): ?>
			<div class="item <?php if ($id == 0): ?>active<?php endif; ?>" style="background-image:url('<?= $item->getImage(); ?>');">
				<?php if ($item->getUrl()): ?>
					<a class="landing" href="<?= $item->getUrl(); ?>"></a>
				<?php endif; ?>
				<div class="carousel-caption">
					<?php if ($item->getTitle()): ?>
						<h3><?= $item->getTitle(); ?></h3>
					<?php endif; ?>
					<?php if ($item->getCaption()): ?>
						<p><?= $item->getCaption(); ?></p>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<!-- Controls -->
	<a class="left carousel-control" href="#<?= $this->getId(); ?>" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Poprzedni</span>
	</a>
	<a class="right carousel-control" href="#<?= $this->getId(); ?>" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Następny</span>
	</a>
</div>