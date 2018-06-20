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

namespace Maslosoft\Staple\Widgets\Vo;

use Maslosoft\Staple\Widgets\Carousel;

/**
 * Carousel Item Value Object
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class CarouselItem
{

	private $title = '';
	private $caption = '';
	private $image = '';
	private $url = '';

	public function __construct($data, Carousel $carousel)
	{
		// Try different title names
		foreach (['title', 'label', 'name'] as $field)
		{
			if (!empty($data[$field]))
			{
				$this->title = $data[$field];
			}
		}
		if (!empty($data['caption']))
		{
			$this->caption = $data['caption'];
		}
		if (!empty($data['image']))
		{
			$this->image = $data['image'];
		}
		if (!empty($data['url']))
		{
			$this->url = $data['url'];
		}

		// Decorate
		$this->decorate($this->title);
		$this->decorate($this->caption);
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getCaption()
	{
		return $this->caption;
	}

	public function getImage()
	{
		return $this->image;
	}

	public function getUrl()
	{
		return $this->url;
	}

	private function decorate(&$text)
	{
		if (!empty($this->url))
		{
			$text = sprintf('<a href="%s">%s</a>', $this->url, $text);
		}
	}

}
