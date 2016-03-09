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
	 * HTML file extension used in temlates
	 * @var string
	 */
	public $extension = 'html';

	public function render($view = 'index', $data = [])
	{
		return file_get_contents(sprintf('%s/%s/%s.%s', $this->getOwner()->getRootPath(), $this->getOwner()->getContentPath(), $view, $this->extension));
	}

}
