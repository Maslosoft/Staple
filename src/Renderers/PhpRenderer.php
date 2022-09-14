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

namespace Maslosoft\Staple\Renderers;

use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Interfaces\NavigableInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;
use function assert;

class PhpRenderer extends AbstractRenderer implements RendererInterface, NavigableInterface
{

	public function render($view = 'index', $data = []): string
	{
		$owner = $this->getOwner();
		assert($owner !== null);
		$mv = new MiniView($this, $owner->getRootPath());
		$mv->setViewsPath($owner->getContentPath());
		return $mv->render($view, $data, true);
	}

}
