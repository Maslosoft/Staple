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
use Maslosoft\Staple\Interfaces\VirtualInterface;
use PHPThumb\GD;

/**
 * ThumbRenderer
 * TODO: Create image thumbs out of an image.
 * 1. Should use extensions like: thumb.jpg, thumb.png
 * 3. Should create a thumb with predefined or requested size and cache it in browser
 * 4. Should be implemented somewhat similar to PassThroughRenderer
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ThumbRenderer extends AbstractRenderer implements RendererInterface, RendererExtensionInterface, VirtualInterface
{

	private $extension = '';
	public $width = 300;
	public $height = 200;

	public function render($view = 'index', $data = array())
	{
		$rootPath = $this->getOwner()->getContentPath();

		$thumbName = sprintf('%s.%s', $view, $this->extension);

		$fileName = sprintf('%s/%s.%s', $rootPath, $view, 'JPG');

		$image = new GD($fileName);
		$image->adaptiveResize($this->width, $this->height);
//		$image->save($thumbName);
		$image->show();
		exit();
	}

	public function setExtension($extension)
	{
		$this->extension = $extension;
	}

}
