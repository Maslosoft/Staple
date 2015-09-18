<?php

use Maslosoft\Ilmatar\Widgets\Form\ActiveForm;
use Maslosoft\Ilmatar\Components\Controller;
?>
<?php
/* @var $this Controller */
/* @var $form ActiveForm */
?>

<div id="<?= $this->getId(); ?>" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#<?= $this->getId(); ?>" data-slide-to="0" class="active"></li>
		<li data-target="#<?= $this->getId(); ?>" data-slide-to="1"></li>
		<li data-target="#<?= $this->getId(); ?>" data-slide-to="2"></li>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<div class="item active" style="background-image:url('/sources/carousel/IMG_1769.JPG');">
			<div class="carousel-caption">
				<h3>Surfing</h3>
				<p>Wyjazdy na surfing</p>
			</div>
		</div>
		<div class="item" style="background-image:url('/sources/carousel/IMG_1803.JPG');">
			<div class="carousel-caption">
				<h3>Snowboard</h3>
				<p>Wyjazdy na snowboard</p>
			</div>
		</div>
		<div class="item" style="background-image:url('/sources/carousel/IMG_1751.JPG');">
			<div class="carousel-caption">
				<h3>Longboard</h3>
				<p>Treningi longboard</p>
			</div>
		</div>
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