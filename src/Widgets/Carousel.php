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
use Maslosoft\Staple\Widgets\Vo\CarouselItem;

/**
 * Carousel
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Carousel
{

	public const DefaultId = 'carousel';

	/**
	 * Default image width and height. Should fit nicely on layouts
	 */
	public const DefaultWidth = 1600;
	public const DefaultHeight = 1200;

	public string $id = self::DefaultId;
	public bool $classic = false;
	public int $width = self::DefaultWidth;
	public int $height = self::DefaultHeight;
	public array $items = [];
	public array $options = [
		'id' => self::DefaultId,
		'width' => self::DefaultWidth,
		'height' => self::DefaultHeight,
		'items' => []
	];

	/**
	 * View
	 * @var MiniView
	 */
	private MiniView $mv;
	private static int $idCounter = 0;

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

	public function getItems(): array
	{
		$items = [];
		foreach ($this->items as $item)
		{
			$items[] = new CarouselItem($item, $this);
		}
		return $items;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function __toString()
	{
		return (string)$this->mv->render('carousel', [], true);
	}

}
