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

use Maslosoft\Staple\Interfaces\NavigableInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;
use Parsedown;

/**
 * MdRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class MdRenderer extends AbstractRenderer implements RendererInterface, NavigableInterface
{

	/**
	 * Extension used for markdown files
	 * @var string
	 */
	public $extension = 'md';

	public function render($view = 'index', $data = [])
	{
		$path = sprintf('%s/%s/%s.%s', $this->getOwner()->getRootPath(), $this->getOwner()->getContentPath(), $view, $this->extension);
		$text = file_get_contents($path);
		return (new Parsedown)->text($text);
	}

}
