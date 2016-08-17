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

namespace Maslosoft\Staple\Widgets;

use Maslosoft\EmbeDi\EmbeDi;
use Maslosoft\MiniView\MiniView;
use Maslosoft\Staple\Widgets\Vo\SubNavItem;

/**
 * SubNav
 * TODO If items are set, init from items.
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class SubNav
{

	public $items = [];
	public $options = [
		'items' => ''
	];

	/**
	 * View
	 * @var MiniView
	 */
	private $mv = null;

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

	public function getItems()
	{
		foreach ($this->items as $url => $title)
		{
			yield new SubNavItem($url, $title, $this);
		}
	}

	public function __toString()
	{
		return $this->mv->render('sub-nav', [], true);
	}

}
