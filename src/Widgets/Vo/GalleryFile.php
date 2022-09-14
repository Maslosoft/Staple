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

namespace Maslosoft\Staple\Widgets\Vo;

use Maslosoft\Staple\Renderers\ThumbRenderer;
use Maslosoft\Staple\Widgets\Gallery;
use SplFileInfo;

/**
 * Gallery File Value Object
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class GalleryFile
{

	private $file = null;
	private $gallery = null;
	private $baseName;
	private $extension;

	public function __construct(SplFileInfo $file, Gallery $gallery)
	{
		$this->file = $file;

		$ext = preg_quote($this->file->getExtension(), '~');
		$this->extension = $this->file->getExtension();
		$this->baseName = preg_replace("~\.$ext$~", '', $this->file->getFilename());
		$this->gallery = $gallery;
	}

	public function getUrl()
	{
		return $this->getUrlAt($this->gallery->width, $this->gallery->height);
	}

	public function getThumbUrl()
	{
		return $this->getUrlAt($this->gallery->thumbWidth, $this->gallery->thumbHeight, ThumbRenderer::OptionCrop);
	}

	private function getUrlAt($width, $height, $options = '')
	{
		return sprintf('/%s/%s@(%dx%d)%s.thumb.%s', $this->gallery->getBaseUrl(), $this->baseName, $width, $height, $options, $this->extension);
	}

}
