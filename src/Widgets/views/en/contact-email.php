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
		<h4>Contact Form Message from <a href="http://<?= $_SERVER['HTTP_HOST']; ?>"><?= $_SERVER['HTTP_HOST']; ?></a></h4>

		<b>From: <?= $data->name ?></b> (<a href="mailto:<?= $data->email ?>"><?= $data->email ?></a>)

		<h3><?= $data->subject; ?></h3>

		<blockquote>
			<?= $data->body; ?>
		</blockquote>
		<p>
			Recipient of this message is: <b><?= $this->to ?></b> (<?= $this->email ?>).
		</p>
	</body>
</html>