<?php

use Maslosoft\Staple\Widgets\ContactForm;
?>
<?php

/* @var $this ContactForm */
?>
<?php

$label = (object) [
			'name' => 'Imię i nazwisko',
			'email' => 'E-mail',
			'subject' => 'Temat wiadomości',
			'body' => 'Treść wiadomości',
			'submit' => 'Wyślij',
			'success' => 'Wiadomość została wysłana, dziekuję %s'
];
$errorLabels = [
	'name' => 'Imie i nazwisko jest wymagane',
	'email' => 'E-mail jest wymagany',
	'emailFormat' => 'E-mail ma nieprawidłowy format',
	'subject' => 'Temat wiadomości jest wymagany',
	'body' => 'Treść wiadomości jest wymagana',
];
?>
<?php

require __DIR__ . '/../contact-form.php';
?>