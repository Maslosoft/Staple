<?php

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
