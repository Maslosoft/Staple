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

use Maslosoft\Staple\Interfaces\RendererExtensionInterface;
use Maslosoft\Staple\Interfaces\RendererInterface;

/**
 * ThumbRenderer
 * TODO: Create image thumbs out of an image.
 * 1. Should use extensions like: thumb.jpg, thumb.png
 * 3. Should create a thumb with predefined or requested size and cache it in browser
 * 4. Should be implemented somewhat similar to PassThroughRenderer
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ThumbRenderer extends AbstractRenderer implements RendererInterface, RendererExtensionInterface
{

	public function render($view = 'index', $data = array())
	{

	}

	public function setExtension($extension)
	{

	}

}
