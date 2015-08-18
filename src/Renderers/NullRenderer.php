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

/**
 * NullRenderer
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class NullRenderer extends AbstractRenderer implements RendererInterface
{

	public function render($view = 'index', $data = [])
	{
		return '';
	}

}
