<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Widgets;

use DirectoryIterator;
use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Staple;
use Maslosoft\Staple\Widgets\Vo\GalleryFile;

/**
 * Gallery
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Gallery
{

	const DefaultPath = 'gallery';

	/**
	 * Default width and height of large image. Should fit nicely on displays
	 */
	const DefaultWidth = 1600;
	const DefaultHeight = 1200;

	/**
	 * Default thumbnail width and height, should fit nicely in layout
	 */
	const DefaultThumbWidth = 192;
	const DefaultThumbHeight = 150;

	/**
	 * Path relative to application root
	 * @var string
	 */
	public $path = '';
	public $width = self::DefaultWidth;
	public $height = self::DefaultHeight;
	public $thumbWidth = self::DefaultThumbWidth;
	public $thumbHeight = self::DefaultThumbHeight;
	public $options = [
		'path' => self::DefaultPath,
		'width' => self::DefaultWidth,
		'height' => self::DefaultHeight,
		'thumbWidth' => self::DefaultThumbWidth,
		'thumbHeight' => self::DefaultThumbHeight
	];

	/**
	 * View
	 * @var MiniView
	 */
	private $mv = null;

	public function __construct($options = [])
	{
		if (is_string($options))
		{
			$this->options['path'] = $options;
			unset($options);
		}
		if (!empty($options))
		{
			$this->options = array_merge($this->options, $options);
		}
		if (empty($this->options['path']))
		{
			$this->options['path'] = self::DefaultPath;
		}

		// Apply configuration
		EmbeDi::fly()->apply($this->options, $this);

		// Setup view
		$this->mv = new MiniView($this);

		$this->path = sprintf('%s/%s', Staple::fly()->getContentPath(), $this->options['path']);
	}

	public function getBaseUrl()
	{
		return $this->options['path'];
	}

	public function getFiles()
	{
		$dirIt = new DirectoryIterator($this->path);
		foreach ($dirIt as $file)
		{
			if ($file->isDir() || $file->isDot())
			{
				continue;
			}
			$ext = strtolower($file->getExtension());
			if (in_array($ext, ['jpg', 'gif', 'png']))
			{
				yield new GalleryFile($file, $this);
			}
		}
	}

	public function __toString()
	{
		return $this->mv->render('gallery', [], true);
	}

}
