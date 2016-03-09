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
use Maslosoft\Staple\Interfaces\NavigableInterface;
use Maslosoft\Staple\Interfaces\RendererExtensionInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;
use Parsedown;

/**
 * PhpMdRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class PhpMdRenderer extends AbstractRenderer implements RendererInterface, RendererExtensionInterface, NavigableInterface
{

	public $extension = 'php.md';

	public function render($view = 'index', $data = [])
	{
		$mv = new MiniView($this);
		$fileName = sprintf('%s/%s/%s.%s', $this->getOwner()->getRootPath(), $this->getOwner()->getContentPath(), $view, $this->extension);
		$content = $mv->renderFile($fileName, $data, true);
		return (new Parsedown)->text($content);
	}

	public function setExtension($extension)
	{
		$this->extension = $extension;
	}

}
