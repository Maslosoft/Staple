<?php

/**
 * This software package is licensed under `AGLP, Commercial` license[s].
 *
 * @package maslosoft/staple
 * @license AGLP, Commercial
 *
 * @copyright Copyright (c) Peter Maselkowski <pmaselkowski@gmail.com>
 *
 */

namespace Maslosoft\Staple\Renderers;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Interfaces\RendererInterface;

class PhpRenderer extends AbstractRenderer implements RendererInterface
{

	public function render($view = 'index', $data = [])
	{
		$mv = new MiniView($this, $this->getOwner()->getRootPath());
		$mv->setViewsPath($this->getOwner()->getContentPath());
		return $mv->render($view, $data, true);
	}

}
