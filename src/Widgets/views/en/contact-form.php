<?php

use Maslosoft\Staple\Widgets\ContactForm;
?>
<?php

/* @var $this ContactForm */
?>
<?php

$label = (object) [
			'name' => 'Full name',
			'email' => 'E-mail',
			'subject' => 'Message subject',
			'body' => 'Message body',
			'submit' => 'Send',
			'success' => 'Message has been send, thank you %s'
];
$errorLabels = [
	'name' => 'Full name is required',
	'email' => 'E-mail is required',
	'emailFormat' => 'E-mail is not properly formatted',
	'subject' => 'Message subject is required',
	'body' => 'Message body is required',
];
?>
<?php

require __DIR__ . '/../contact-form.php';
?>