<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Helpers;

use PHPThumb\GD;

/**
 * InlineThumb
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class InlineThumb
{

	/**
	 *
	 * @var GD
	 */
	private $gd = null;
	public $width, $height = 120;
	public $adaptive = true;

	public function __construct($filename, $width = 120, $height = 120, $adaptive = true)
	{
		$this->gd = new GD($filename);
	}

	public function __toString()
	{
		if ($this->adaptive)
		{
			$this->gd->adaptiveResize($this->width, $this->height);
		}
		else
		{
			$this->gd->resize($this->width, $this->height);
		}

		return sprintf('data:%s;base64,%s', $this->gd->getFormat(), base64_encode($this->gd->getImageAsString()));
	}

}
