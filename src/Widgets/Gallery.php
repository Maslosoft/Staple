<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Widgets;

use Maslosoft\MiniView\MiniView;

/**
 * Gallery
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Gallery
{

	public $options = [
		'folder' => '',
		'thumbW' => 500,
		'thumbH' => 500,
	];

	/**
	 * View
	 * @var MiniView
	 */
	private $mv = null;

	public function __construct($options = [])
	{
		if (is_string($options))
		{
			$this->options['folder'] = $options;
			unset($options);
		}
		if (!empty($options))
		{
			$this->options = array_merge($this->options, $options);
		}
		$this->mv = new MiniView($this);
	}

	public function __toString()
	{
		;
	}

}
