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
use Maslosoft\Staple\Widgets\Vo\CarouselItem;

/**
 * Carousel
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Carousel
{

	const DefaultId = 'carousel';

	/**
	 * Default image width and height. Should fit nicely on layouts
	 */
	const DefaultWidth = 1600;
	const DefaultHeight = 1200;

	public $id = self::DefaultId;
	public $classic = false;
	public $width = self::DefaultWidth;
	public $height = self::DefaultHeight;
	public $items = [];
	public $options = [
		'id' => self::DefaultId,
		'width' => self::DefaultWidth,
		'height' => self::DefaultHeight,
		'items' => []
	];

	/**
	 * View
	 * @var MiniView
	 */
	private $mv = null;
	private static $idCounter = 0;

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

		// Set auto id if id is default
		if ($this->id === self::DefaultId && self::$idCounter > 0)
		{
			$this->id = sprintf('%s-%d', $this->id, self::$idCounter++);
		}
	}

	public function getItems()
	{
		foreach ($this->items as $item)
		{
			yield new CarouselItem($item, $this);
		}
	}

	public function getId()
	{
		return $this->id;
	}

	public function __toString()
	{
		return $this->mv->render('carousel', [], true);
	}

}
