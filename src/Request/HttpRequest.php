<?php

namespace Maslosoft\Staple\Request;

use Maslosoft\Staple\Interfaces\RequestAwareInterface;
use Maslosoft\Staple\Interfaces\RequestInterface;

class HttpRequest implements RequestInterface
{

	public function dispatch(RequestAwareInterface $owner)
	{
		$fileName = '';
		$renderer = $owner->getRenderer();

		return $renderer->render($view);
	}

}
