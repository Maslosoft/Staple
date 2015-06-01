<?php

namespace Maslosoft\Staple\Renderers;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Interfaces\RendererInterface;

class PhpRenderer extends AbstractRenderer implements RendererInterface
{

	public function render($view = 'index')
	{
		return (new MiniView($this, $this->getBasePath()))->render($view);
	}

}
