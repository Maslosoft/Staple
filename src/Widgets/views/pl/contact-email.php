<?php

use Maslosoft\Ilmatar\Widgets\Form\ActiveForm;
use Maslosoft\Staple\Widgets\ContactForm;
?>
<?php
/* @var $this ContactForm */
/* @var $form ActiveForm */
?>
<html>
	<body>
		<h4>Wiadomość z Formularza Kontaktowego z <a href="http://<?= $_SERVER['HTTP_HOST']; ?>"><?= $_SERVER['HTTP_HOST']; ?></a></h4>

		<b>Od: <?= htmlspecialchars($data->name) ?></b> (<a href="mailto:<?= htmlspecialchars($data->email); ?>"><?= htmlspecialchars($data->email); ?></a>)

		<h3><?= htmlspecialchars($data->subject); ?></h3>


		<blockquote>
			<?= nl2br(htmlspecialchars($data->body)); ?>
		</blockquote>
		<p>
			Odbiorcą tej wiadomości jest: <b><?= $this->to ?></b> (<?= htmlspecialchars($this->email); ?>).
		</p>
	</body>
</html>