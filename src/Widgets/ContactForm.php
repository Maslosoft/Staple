<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

	const DefaultLang = 'en';

	/**
	 * Language
	 * @var string
	 */
	public $lang = self::DefaultLang;
	public $email = '';
	public $to = '';
	public $options = [
		'lang' => self::DefaultLang,
		'email' => '',
	];
	public $error = [];

	/**
	 * View
	 * @var MiniView
	 */
	private $mv = null;
	private $success = false;

	public function __construct($options = [])
	{
		if (is_string($options))
		{
			$this->options['email'] = $options;
			unset($options);
		}
		if (!empty($options))
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

//		var_dump($_POST);
		if (!empty($_POST['ContactForm']))
		{
			$data = (object) $_POST['ContactForm'];
			if ($this->validate($data))
			{
				$email = $this->mv->render(sprintf('%s/%s', $this->lang, 'contact-email'), ['data' => $data], true);

				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: <$this->email>" . "\r\n";
				$headers .= "Reply-to: $data->name <$data->email>" . "\r\n";

				$this->success = mail($this->email, $data->subject, $email, $headers);
			}
		}
	}

	public function isSuccess()
	{
		return $this->success;
	}

	protected function validate($data)
	{
		$this->error = [];
		foreach (['name', 'email', 'subject', 'body'] as $field)
		{
			if (empty($data->$field))
			{
				array_push($this->error, $field);
			}
		}
		if (!filter_var($data->email, FILTER_VALIDATE_EMAIL))
		{
			array_push($this->error, 'emailFormat');
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
			return $this->mv->render(sprintf('%s/%s', $this->lang, 'contact-form'), [], true);
		}
		catch (Exception $exc)
		{
			echo $exc->getTraceAsString();
		}
	}

}
