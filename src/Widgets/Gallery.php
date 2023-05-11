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

namespace Maslosoft\Staple\Widgets;

use DirectoryIterator;
use Exception;
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

	public const DefaultPath = 'gallery';

	/**
	 * Default width and height of large image. Should fit nicely on displays
	 */
	public const DefaultWidth = 1600;
	public const DefaultHeight = 1200;

	/**
	 * Default thumbnail width and height, should fit nicely in layout
	 */
	public const DefaultThumbWidth = 237;
	public const DefaultThumbHeight = 237;
	public const DefaultThumbCss = 'img-thumbnail img-margins img-responsive';

	public static string $ogTags = '';

	/**
	 * Path relative to application root
	 * @var string
	 */
	public string $path = '';
	public int $width = self::DefaultWidth;
	public int $height = self::DefaultHeight;
	public int $thumbWidth = self::DefaultThumbWidth;
	public int $thumbHeight = self::DefaultThumbHeight;
	public string $thumbCss = self::DefaultThumbCss;
	public int|null $lg = null;
	public int|null $md = 4;
	public int|null $sm = 2;
	public int|null $xs = 2;
	public array $options = [
		'path' => self::DefaultPath,
		'width' => self::DefaultWidth,
		'height' => self::DefaultHeight,
		'thumbWidth' => self::DefaultThumbWidth,
		'thumbHeight' => self::DefaultThumbHeight,
		'thumbCss' => self::DefaultThumbCss
	];

	/**
	 * View
	 * @var MiniView
	 */
	public MiniView $view;

	public function __construct(string|array $options = [])
	{
		if (is_string($options))
		{
			$this->options['path'] = $options;
		}
		elseif (!empty($options))
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
		$this->view = new MiniView($this);

		$this->path = sprintf('%s/%s', Staple::fly()->getContentPath(), $this->options['path']);
	}

	public function getBaseUrl()
	{
		return $this->options['path'];
	}

	public function getFiles(): array
	{
		$files = [];
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
				$galleryFile = new GalleryFile($file, $this);
				self::$ogTags .= sprintf('<meta property="og:image" content="%s"></meta>', $galleryFile->getUrl());
				$files[$file->getFilename()] = $galleryFile;
			}
		}
		ksort($files);
		return array_values($files);
	}

	public function getSizes(): string
	{
		$sizes = [];
		$names = ['lg', 'md', 'sm', 'xs'];
		foreach ($names as $size)
		{
			if ($this->{$size} === null)
			{
				continue;
			}
			$value = (int) $this->{$size};
			if (12 % $value > 0)
			{
				throw new \InvalidArgumentException(sprintf('Value for `%s` must divide number 12 equally, `%s` given', $size, $value));
			}
			if ($value < 1 || $value > 12)
			{
				throw new \InvalidArgumentException(sprintf('Value for `%s` must be between 1 and 12, `%s` given', $size, $value));
			}
			$sizes[] = sprintf('col-%s-%s', $size, 12 / $value);
		}

		return implode(' ', $sizes);
	}

	public function __toString()
	{
		try
		{
			return (string)$this->view->render('gallery', [], true);
		}
		catch (Exception $exc)
		{
			echo $exc->getTraceAsString();
		}
		return '';
	}

}
