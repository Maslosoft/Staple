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
use SplFileInfo;

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

	const OptionCrop = 'c';

	private $extension = '';
	public $width = 300;
	public $height = 200;
	public $options = [];

	public function render($view = 'index', $data = array())
	{
		$view = urldecode($view);
		$contentPath = $this->getOwner()->getContentPath();
		$rootPath = $this->getOwner()->getRootPath();

		$matches = [];

		if (preg_match('~@\((\d+)x(\d+)\)([a-z]{1})?$~', $view, $matches))
		{
			$this->width = $matches[1];
			$this->height = $matches[2];
			if (isset($matches[3]))
			{
				$this->options = preg_split('~~', $matches[3], PREG_SPLIT_NO_EMPTY);
			}
			$pattern = preg_quote($matches[0]);
			$baseView = preg_replace("~$pattern$~", '', $view);
		}
		$thumbName = sprintf('%s/%s.%s', $rootPath, $view, $this->extension);

		// Get thumbnail dir for later use
		$thumbDir = dirname($thumbName);

		// Try to make a thumbnail dir
		if (!file_exists($thumbDir))
		{
			@mkdir($thumbDir, 0777, true);
		}

		$baseExt = str_replace('thumb.', '', $this->extension);
		$fileName = sprintf('%s/%s.%s', $contentPath, $baseView, $baseExt);


		if (!file_exists($fileName))
		{
			throw new NotFoundException(sprintf('File not found: `%s`', $fileName));
		}

		if (!file_exists($thumbName))
		{
			$image = new GD($fileName);
			if (in_array(self::OptionCrop, $this->options))
			{
				$image->adaptiveResize($this->width, $this->height);
			}
			else
			{
				$image->resize($this->width, $this->height);
			}

			// ensure we can write into dir or overwrite a file
			if (is_writeable($thumbDir) || is_writeable($thumbName))
			{
				$image->save($thumbName);
			}
		}

		$info = new SplFileInfo($thumbName);
		$size = $info->getSize();

		if ($size > 0)
		{
			header(sprintf('Content-Length: %d', $size));
		}


		switch (strtolower($info->getExtension()))
		{
			case 'gif':
				header('Content-type: image/gif');
				break;
			case 'jpg':
				header('Content-type: image/jpeg');
				break;
			case 'png':
			case 'string':
				header('Content-type: image/png');
				break;
		}

		header(sprintf('ETag: %s', md5($thumbName)));
		header(sprintf('Last-Modified: %s', gmdate('D, d M Y H:i:s \G\M\T', $info->getMTime())));
		header(sprintf('Content-Disposition: filename="%s"', basename($fileName)));

		// Cache it
		header('Pragma: public');
		header('Cache-Control: max-age=86400');
		header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
		echo file_get_contents($thumbName);
		exit();
	}

	public function setExtension($extension)
	{
		$this->extension = $extension;
	}

}
