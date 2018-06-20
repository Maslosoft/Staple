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
