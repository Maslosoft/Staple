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

use Maslosoft\Staple\Helpers\FileLoader;
use Maslosoft\Staple\Interfaces\NavigableInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;

/**
 * HtmlRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class HtmlRenderer extends AbstractRenderer implements RendererInterface, NavigableInterface
{

	/**
	 * HTML file extension used in templates
	 * @var string
	 */
	public $extension = 'html';

	public function render($view = 'index', $data = [])
	{
		$path = sprintf('%s/%s/%s.%s', $this->getOwner()->getRootPath(), $this->getOwner()->getContentPath(), $view, $this->extension);

		return FileLoader::load($path);
	}

}
