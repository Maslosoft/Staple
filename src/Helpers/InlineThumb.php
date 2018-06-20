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
