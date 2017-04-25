<?php

/**
 * This software package is licensed under AGPL or Commercial license.
 *
 * @package maslosoft/staple
 * @licence AGPL or Commercial
 * @copyright Copyright (c) Piotr Masełkowski <pmaselkowski@gmail.com>
 * @copyright Copyright (c) Maslosoft
 * @link http://maslosoft.com/staple/
 */

namespace Maslosoft\Staple\Helpers;

use Maslosoft\Staple\Interfaces\NavigableInterface;
use Maslosoft\Staple\Interfaces\ProcessorAwareInterface;
use Maslosoft\Staple\Interfaces\RendererAwareInterface;
use Maslosoft\Staple\Models\RequestItem;
use Maslosoft\Staple\Request\HttpRequest;
use Maslosoft\Staple\Staple;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use UnexpectedValueException;

/**
 * SiteWalker
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SiteWalker extends AbstractWalker
{

	/**
	 * Scanning depth
	 * @var int
	 */
	private $depth = -1;

	/**
	 * Starting dir, relative to base website path
	 *
	 * @param string $dir
	 * @return SiteWalker
	 */
	public function start($dir, $depth = -1)
	{
		$url = (new HttpRequest())->getPath();
		$this->path = realpath($this->path . DIRECTORY_SEPARATOR . trim($dir, '/\\'));

		$urlParts = preg_split('~/~', trim($url, '/'));
		$pathParts = preg_split('~/~', trim($this->path, '/'));
		$relativeUrl = '/' . implode('/', array_intersect($pathParts, $urlParts));

		$this->relativePath = $relativeUrl;
		$this->depth = (int) $depth;
		if ($this->depth === 0)
		{
			throw new UnexpectedValueException('Parameter `depth` cannot be equall zero');
		}
		return $this;
	}

	/**
	 *
	 * @return static
	 */
	public function scan()
	{
		$this->item->url = '/';
		$this->scanFiles($this->path, $this->item);
		return $this;
	}

	private function scanFiles($path, $parent)
	{
		$finder = new Finder();
		$finder->in($path);
		$finder->files();
		$finder->ignoreDotFiles(true);
		$finder->depth(0);
		$finder->sortByName();
		$finder->followLinks();

		$items = [];
		$index = null;

		foreach ($finder as $entity)
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

			$isIndex = false;
			if (preg_match('~^index\.~', basename($name)))
			{
				$isIndex = true;
			}

			$item = new RequestItem;

			$path = $entity->getPathname();
			$url = $this->relativePath . str_replace($this->path, '', $path);
			if ($isIndex)
			{
				$url = dirname($url) . '/';
				$index = $item;
				$this->scanFolders(dirname($path), $index);
			}
			$renderer = $this->staple->getRenderer($path);

			// Skip assets
			if (!$renderer instanceof NavigableInterface)
			{
				continue;
			}

			$data = (object) (new PreProcessor)->getData($this, $path, $entity->getBasename());

			$item->url = $url;
			$item->title = !empty($data->title) ? $data->title : '* ' . ucfirst(basename($url));
			$parent->items[] = $item;
		}
		return $index;
	}

	private function scanFolders($path, $parent)
	{
		$finder = new Finder();
		$finder->in($path);
		$finder->directories();
		$finder->ignoreDotFiles(true);
		$finder->depth(0);
		$finder->sortByName();

		foreach ($finder as $entity)
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

			$this->scanFiles($entity->getPathname(), $parent);
		}
	}

	/**
	 * Get root item of pages
	 * @return RequestItem
	 */
	public function get()
	{
		return $this->item;
	}

}
