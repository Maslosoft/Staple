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

use Maslosoft\Staple\Widgets\Vo\SubNavItem;

/**
 * SubNav
 * TODO If items are set, init from items.
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SubNav extends Widget
{
	public array $options = [
		'items' => ''
	];

	public function getItems(): array
	{
		$items = [];
		foreach ($this->items as $url => $title)
		{
			$items[] = new SubNavItem($url, $title, $this);
		}
		return $items;
	}

	public function __toString()
	{
		return (string)$this->mv->render('sub-nav', [], true);
	}

}
