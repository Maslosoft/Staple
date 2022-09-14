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

use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Helpers\SiteWalker;
use Maslosoft\Staple\Models\RequestItem;
use Maslosoft\Staple\Widgets\Vo\SubNavItem;
use Maslosoft\Staple\Widgets\Vo\SubNavSeparator;

/**
 * SubNavRecursive
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SubNavRecursive extends SubNav
{

	public $baseUrl = '';
	public $urlSuffix = '';
	public $items = [];

	/**
	 * How many level from top to skip
	 * @var int
	 */
	public $skipLevel = 0;

	/**
	 * Root path
	 * @var string
	 */
	public $root = '';

	/**
	 * Scan path
	 * @var string
	 */
	public $path = '';
	public $options = [
		'path' => '',
		'items' => ''
	];

	/**
	 * View
	 * @var MiniView
	 */
	public $mv = null;

	public function __construct($options = [])
	{
		if (!empty($options))
		{
			$this->options = array_merge($this->options, $options);
		}

		// Apply configuration
		EmbeDi::fly()->apply($this->options, $this);

		// Setup view
		$this->mv = new MiniView($this);
	}

	/**
	 * Get view instance
	 * Used by items
	 * @return MiniView
	 */
	public function getView()
	{
		return $this->mv;
	}

	public function getItems()
	{
		$w = new SiteWalker($this->root);
		$w->start($this->path)->scan();

		$items = [];
		if (!empty($this->items))
		{
			foreach ($this->items as $url => $title)
			{
				if ($title === '--')
				{
					$items[] = new SubNavSeparator();
				}
				else
				{
					$items[] = new SubNavItem($url, $title, $this);
				}
			}
		}
		$rootItem = $w->get();
		if ($this->skipLevel > 0)
		{
			for ($i = -1; $i < $this->skipLevel; $i++)
			{
				$walkerItems = $rootItem->items;
				if (!isset($walkerItems[0]))
				{
					continue;
				}
				$rootItem = $walkerItems[0];
			}
		}
		else
		{
			$walkerItems = $rootItem->items;
		}

		$walkerItems = $this->convertItems($walkerItems);
		$walkerItems = $this->sort($walkerItems);
		$allItems = array_merge($items, $walkerItems);

		return $allItems;
	}

	private function sort($items)
	{
		if (empty($items))
		{
			return $items;
		}
		$sorted = [];
		$groups = [];
		$groupId = 0;
		$groups[$groupId] = [];
		foreach ($items as $item)
		{
			if ($item instanceof SubNavSeparator)
			{
				$groupId++;
				$groups[$groupId] = [];
				continue;
			}
			$item->items = $this->sort($item->items);
			$groups[$groupId][] = $item;
		}
		$lastId = count($groups) - 1;
		foreach ($groups as $id => $group)
		{
			usort($group, [$this, 'sortGroup']);

			// Do not add separator to the last group
			$sep = [];
			if ($id !== $lastId)
			{
				$sep = [
					new SubNavSeparator()
				];
			}
			$sorted = array_merge($sorted, $group, $sep);
		}
		return $sorted;
	}

	public function sortGroup($one, $two)
	{
		return strcmp($one->title, $two->title);
	}

	private function convertItems($walkerItems)
	{
		$items = [];
		foreach ($walkerItems as $requestItem)
		{
			/* @var $requestItem RequestItem */
			$item = new SubNavItem($this->baseUrl . $requestItem->url . $this->urlSuffix, $requestItem->title, $this);
			$item->items = $this->convertItems($requestItem->items);
			$items[] = $item;
		}
		return $items;
	}

	public function __toString()
	{
		return (string)$this->mv->render('sub-nav-recursive/nav', ['mv' => $this->mv], true);
	}

}
