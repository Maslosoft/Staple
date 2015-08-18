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

use Maslosoft\Staple\Interfaces\RendererInterface;
use Parsedown;

/**
 * MdRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class MdRenderer extends AbstractRenderer implements RendererInterface
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
