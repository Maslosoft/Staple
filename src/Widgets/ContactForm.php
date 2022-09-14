<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/staple
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link https://maslosoft.com/staple/
 */

namespace Maslosoft\Staple\Widgets;

use Exception;
use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\MiniView\MiniView;

/**
 * ContactForm
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ContactForm
{

	public const DefaultLang = 'en';

	/**
	 * Language
	 * @var string
	 */
	public string $lang = self::DefaultLang;
	public string $email = '';
	public string $to = '';
	public array $fields = ['name', 'email', 'subject', 'body'];
	public array $options = [
		'lang' => self::DefaultLang,
		'email' => '',
		'fields' => ['name', 'email', 'subject', 'body']
	];
	public array $error = [];

	/**
	 * View
	 * @var MiniView
	 */
	private MiniView $mv;
	private bool $success = false;

	/**
	 * @param array|string $options
	 */
	public function __construct(array|string $options = [])
	{
		if (is_string($options))
		{
			$this->options['email'] = $options;
		}
		elseif (!empty($options))
		{
			$this->options = array_merge($this->options, $options);
		}
		if (empty($this->options['lang']))
		{
			$this->options['lang'] = self::DefaultLang;
		}

		// Apply configuration
		EmbeDi::fly()->apply($this->options, $this);

		// Setup view
		$this->mv = new MiniView($this);

		if (!empty($_POST['ContactForm']))
		{
			if(!empty($_POST['email']))
			{
				$this->success = true;
				return;
			}
			$data = (object) $_POST['ContactForm'];
			if (!isset($data->name))
			{
				$data->name = $data->email;
			}
			if (!isset($data->subject))
			{
				$data->subject = substr($data->body, 0, 32);
			}
			if ($this->validate($data))
			{
				$email = $this->mv->render(sprintf('%s/%s', $this->lang, 'contact-email'), ['data' => $data], true);

				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: <$this->email>" . "\r\n";
				$headers .= "Reply-to: $data->name <$data->email>" . "\r\n";

				$this->success = mail($this->email, $data->subject, $email, $headers);
				if(!$this->success)
				{
					$this->error[] = 'notSent';
				}
			}
		}
	}

	public function hasField($field): bool
	{
		return in_array($field, $this->fields, true);
	}

	public function isSuccess(): bool
	{
		return $this->success;
	}

	protected function validate($data): bool
	{
		$this->error = [];
		foreach ($this->fields as $field)
		{
			if (empty($data->$field))
			{
				$this->error[] = $field;
			}
		}
		if (!filter_var($data->email, FILTER_VALIDATE_EMAIL))
		{
			$this->error[] = 'emailFormat';
		}
		if (empty($this->error))
		{
			return true;
		}
		return false;
	}

	public function __toString()
	{
		try
		{
			return (string)$this->mv->render(sprintf('%s/%s', $this->lang, 'contact-form'), [], true);
		}
		catch (Exception $exc)
		{
			echo $exc->getTraceAsString();
		}
		return '';
	}

}
