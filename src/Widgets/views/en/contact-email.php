<?php

use Maslosoft\Staple\Widgets\ContactForm;
?>
<?php
/* @var $this ContactForm */
/* @var $data object */
?>
<html>
	<body>
		<h4>Contact Form Message from <a href="http://<?= $_SERVER['HTTP_HOST']; ?>"><?= $_SERVER['HTTP_HOST']; ?></a></h4>

		<b>From: <?= htmlspecialchars($data->name) ?></b> (<a href="mailto:<?= htmlspecialchars($data->email) ?>"><?= htmlspecialchars($data->email) ?></a>)

		<h3><?= htmlspecialchars($data->subject); ?></h3>

		<blockquote>
			<?= nl2br(htmlspecialchars($data->body)); ?>
		</blockquote>
		<p>
			Recipient of this message is: <b><?= $this->to ?></b> (<?= htmlspecialchars($this->email) ?>).
		</p>
	</body>
</html>