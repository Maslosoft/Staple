<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/staple
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link http://maslosoft.com/staple/
 */

namespace Maslosoft\Staple\Renderers;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Interfaces\NavigableInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;

class PhpRenderer extends AbstractRenderer implements RendererInterface, NavigableInterface
{

	public function render($view = 'index', $data = [])
	{
		$mv = new MiniView($this, $this->getOwner()->getRootPath());
		$mv->setViewsPath($this->getOwner()->getContentPath());
		return $mv->render($view, $data, true);
	}

}
