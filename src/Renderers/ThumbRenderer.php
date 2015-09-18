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

use Maslosoft\Staple\Exceptions\NotFoundException;
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
		$contentPath = $this->getOwner()->getContentPath();
		$rootPath = $this->getOwner()->getRootPath();

		$matches = [];
		if (preg_match('~@\((\d+)x(\d+)\)$~', $view, $matches))
		{
			$this->width = $matches[1];
			$this->height = $matches[2];
			$pattern = preg_quote($matches[0]);
			$view = preg_replace("~$pattern$~", '', $view);
		}

		$thumbName = sprintf('%s/%s.%s', $rootPath, $view, $this->extension);

		// Get thumbnail dir for later use
		$thumbDir = dirname($thumbName);

		// Try to make a thumbnail dir
		if (!file_exists($thumbDir))
		{
			@mkdir($thumbDir, 0777, true);
		}

		$fileName = sprintf('%s/%s.%s', $contentPath, $view, 'JPG');


		if (!file_exists($fileName))
		{
			throw new NotFoundException(sprintf('File not found: `%s`', $fileName));
		}

		$image = new GD($fileName);
		$image->adaptiveResize($this->width, $this->height);

		// ensure we can write into dir or overwrite a file
		if (is_writeable($thumbDir) || is_writeable($thumbName))
		{
			$image->save($thumbName);
		}
		$image->show();
		exit();
	}

	public function setExtension($extension)
	{
		$this->extension = $extension;
	}

}
