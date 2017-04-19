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

namespace Maslosoft\Staple\Widgets\Vo;

use Maslosoft\Staple\Widgets\SubNav;
use Maslosoft\Staple\Widgets\SubNavRecursive;

/**
 * SubNavItem
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SubNavItem
{

	public $title = '';
	public $url = '';
	public $items = [];
	public $style = '';

	/**
	 *
	 * @var SubNav
	 */
	private $owner = null;

	public function __construct($url, $title, SubNav $nav)
	{
		$this->owner = $nav;
		$this->url = $url;
		$pattern = "~^\s*\d+\.\s*~";
		if (preg_match($pattern, $title))
		{
			$this->style .= 'list-style-type: decimal;';
			$title = preg_replace($pattern, '', $title);
		}
		$this->title = $title;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function __toString()
	{
		return $this->owner->getView()->render('sub-nav-recursive/item', ['item' => $this], true);
	}

}
