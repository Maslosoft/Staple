<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Widgets\Vo;

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
		$ext = preg_quote($this->file->getExtension());
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
		return $this->getUrlAt($this->gallery->thumbWidth, $this->gallery->thumbHeight);
	}

	private function getUrlAt($width, $height)
	{
		return sprintf('/%s/%s@(%dx%d).thumb.%s', $this->gallery->getBaseUrl(), $this->baseName, $width, $height, $this->extension);
	}

}
