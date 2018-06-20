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
use Maslosoft\Staple\Helpers\FileLoader;
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
		FileLoader::load($fileName);
		$content = $mv->renderFile($fileName, $data, true);
		return (new Parsedown)->text($content);
	}

	public function setExtension($extension)
	{
		$this->extension = $extension;
	}

}
