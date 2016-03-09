<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\Staple\Helpers;

use Maslosoft\Staple\Interfaces\NavigableInterface;
use Maslosoft\Staple\Interfaces\ProcessorAwareInterface;
use Maslosoft\Staple\Interfaces\RendererAwareInterface;
use Maslosoft\Staple\Models\RequestItem;
use Maslosoft\Staple\Staple;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use UnexpectedValueException;

/**
 * SiteWalker
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SiteWalker implements RendererAwareInterface, ProcessorAwareInterface
{

	/**
	 * Scanning path
	 * @var string
	 */
	private $path = '';

	/**
	 * Base path, as set in constructor
	 * @var string
	 */
	private $basePath = '';

	/**
	 * Path relative to base path
	 * @var string
	 */
	private $relativePath = '';

	/**
	 * Scanning depth
	 * @var int
	 */
	private $depth = -1;

	/**
	 * Staple instance
	 * @var Staple
	 */
	private $staple = null;

	/**
	 * Root item instance
	 * @var RequestItem
	 */
	private $item = null;

	public function __construct($path = '')
	{
		$this->staple = Staple::fly();
		if (empty($path))
		{
			$path = $this->staple->getContentPath(true);
		}
		$this->path = realpath(rtrim($path, '/\\'));
		$this->basePath = $this->path;
		$this->item = new RequestItem;
	}

	/**
	 * Starting dir, relative to base website path
	 *
	 * @param string $dir
	 * @return SiteWalker
	 */
	public function start($dir, $depth = -1)
	{
		$this->path = realpath($this->path . DIRECTORY_SEPARATOR . trim($dir, '/\\'));
		$this->relativePath = str_replace($this->basePath, '', $this->path);
		$this->depth = (int) $depth;
		if ($this->depth === 0)
		{
			throw new UnexpectedValueException('Parameter `depth` cannot be equall zero');
		}
		return $this;
	}

	public function scan()
	{
		$directoryIterator = new RecursiveDirectoryIterator($this->path);
		$iterator = new RecursiveIteratorIterator($directoryIterator);
		$iterator->setMaxDepth($this->depth);

		foreach ($iterator as $entity)
		{
			/* @var $entity SplFileInfo */
			$name = $entity->getFilename();

			// Skip items starting with underscore
			if (preg_match('~^_~', $name))
			{
				continue;
			}

			// Skip items starting with dot
			if (preg_match('~^\.~', $name))
			{
				continue;
			}
			$path = $entity->getPathname();
			$url = $this->relativePath . str_replace($this->path, '', $path);
			if (preg_match('~^index\.~', basename($url)))
			{
				$url = dirname($url) . '/';
			}
			$renderer = $this->staple->getRenderer($path);

			// Skip assets
			if (!$renderer instanceof NavigableInterface)
			{
				continue;
			}

			$data = (object) (new PreProcessor)->getData($this, $path, $entity->getBasename());

			$item = new RequestItem;
			$item->url = $url;
			$item->title = !empty($data->title) ? $data->title : '* ' . ucfirst(basename($url));
			$this->item->items[] = $item;
		}
		return $this;
	}

	/**
	 * Get root item of pages
	 * @return RequestItem
	 */
	public function get()
	{
		return $this->item;
	}

	public function getContentPath()
	{
		return $this->path;
	}

	public function getLayoutPath()
	{
		return $this->staple->getLayoutPath();
	}

	public function getPostProcessors()
	{
		return $this->staple->getPostProcessors();
	}

	public function getPreProcessors()
	{
		return $this->staple->getPreProcessors();
	}

	public function getRenderer($filename)
	{
		return $this->staple->getRenderer($filename);
	}

	public function getRootPath()
	{
		return $this->path;
	}

	public function setLayoutPath($layoutPath)
	{
		$this->staple->setLayoutPath($layoutPath);
	}

}
